<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main-content {
            display: flex;
            width: 90%;
            max-width: 700px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .2);
            overflow: hidden;
        }

        .company__info {
            background-color: #800000;
            color: #fff;
            padding: 2em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login_form {
            flex: 1;
            background-color: #fff;
            padding: 2em;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form__input {
            border: none;
            border-bottom: 1px solid #aaa;
            padding: 1em;
            margin-bottom: 1.5em;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form__input:focus {
            border-bottom-color: #800000;
        }

        .btn {
            background-color: #800000;
            color: #fff;
            border: none;
            padding: 0.75em;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 1em;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #590000;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875em;
            margin-top: -1em;
            margin-bottom: 1em;
        }

        @media screen and (max-width: 640px) {
            .main-content {
                flex-direction: column;
                align-items: center;
                width: 90%;
            }

            .company__info {
                display: none;
            }

            .login_form {
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="company__info">
            
            <img src="{{ asset('./images/logo.png') }}"  alt= "C2M's LOGO" style="width: 200px; height: 200px; border-radius:60% ">
            <h4>C2M SYSTEM</h4>
        </div>
        <div class="login_form">
            <h2>Log In</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" id="email" class="form__input" placeholder="Email" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <input type="password" name="password" id="password" class="form__input" placeholder="Password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <input type="submit" value="Log In" class="btn">
            </form>
        </div>
    </div>
</body>
</html>
