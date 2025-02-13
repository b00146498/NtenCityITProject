<x-guest-layout>
    <head>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f5f1e9;
            }

            .register-container {
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
            }

            .logo img {
                width: 200px;
                margin-bottom: 20px;
            }

            .title {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                color: #333;
                text-align: center;
            }

            .form-title {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                color: #333;
                text-align: left;
            }

            input[type=text], input[type=email], input[type=password] {
                width: 100%;
                padding: 12px;
                margin: 8px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            input::placeholder {
                color: gray;
                font-size: 14px;
            }

            button {
                background-color: black;
                color: white;
                padding: 14px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                margin-top: 10px;
            }

            button:hover {
                opacity: 0.8;
            }

            .already-registered {
                display: block;
                margin-top: 10px;
                font-size: 14px;
                color: gray;
                text-decoration: none;
            }

            .already-registered:hover {
                color: black;
            }
        </style>
    </head>

    <div class="register-container">
        <div class="logo">
            <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo">
        </div>

        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-title">Sign Up</div>
            <div>
                <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Name" />
            </div>

            <div class="mt-4">
                <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required placeholder="Email" />
            </div>

            <div class="mt-4">
                <x-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
            </div>

            <div class="mt-4">
                <x-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required placeholder="Confirm Password" />
            </div>

            <button type="submit">Register</button>

            <a class="already-registered" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </form>
    </div>
</x-guest-layout>
