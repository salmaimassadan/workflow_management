<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use this instead of Model
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable // Extend Authenticatable instead of Model
{
    use HasFactory, Notifiable; // You can also use Notifiable if you're sending notifications

    protected $fillable = [
        'name',
        'firstname',
        'email',
        'password',
        'phone',
        'image',
        'service_id',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function courriers()
    {
        return $this->hasMany(Courrier::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
