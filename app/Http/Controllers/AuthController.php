<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Notification;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if the email belongs to a User or an Employee
        $user = User::where('email', $request->email)->first();
        $employee = Employee::where('email', $request->email)->first();

        if ($user && Auth::guard('web')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $request->remember)) {
            // Redirect Users to the User dashboard
            return redirect()->route('dashboard');
        } elseif ($employee && Auth::guard('employee')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $request->remember)) {
            // Redirect Employees based on their role
            return $this->redirectBasedOnRole($employee->role);
        }

        // If unsuccessful, prepare error message
        $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);

        // Redirect back to the login form with error messages and old input (excluding password)
        return redirect()->back()->withErrors($errors)->withInput($request->only('email', 'remember'));
    }

    protected function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'responsable':
                return redirect()->route('responsable.dashboard');
            case 'indexeur':
                return redirect()->route('auditor.dashboard');
            case 'utilisateur':
                return redirect()->route('utilisateur.dashboard');
            case 'secrétaire':
                return redirect()->route('secretary.dashboard');
            default:
                return redirect()->route('operator.dashboard');
        }
    }

    public function logout(Request $request)
    {
        $guard = Auth::guard('employee')->check() ? 'employee' : 'web';
        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function editProfile($id)
    {   
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        $user = Auth::guard('employee')->check() ? Employee::findOrFail($id) : User::findOrFail($id);
        return view('users.editprofile', compact('user', 'notifications'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::guard('employee')->check() ? Employee::findOrFail($id) : User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            // Store the new image
            $path = $request->file('image')->store('images', 'public');
            $user->image = $path;
        }

        $user->save();

        return redirect()->route('users.edit-profile', $user->id)->with('success', 'Profile updated successfully');
    }

    public function editPassword($id)
    {   
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        $user = Auth::guard('employee')->check() ? Employee::findOrFail($id) : User::findOrFail($id);
        return view('users.editPassword', compact('user', 'notifications'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::guard('employee')->check() ? Employee::findOrFail($id) : User::findOrFail($id);

        // Check if the old password is correct
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->route('users.edit-password', $user->id)
                ->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('users.edit-password', $user->id)->with('success', 'Password updated successfully');
    }
}
