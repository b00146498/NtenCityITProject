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

            .login-container {
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

            input[type=email], input[type=password] {
                width: 100%;
                padding: 12px;
                margin: 8px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
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

            .forgot-password {
                display: block;
                margin-top: 10px;
                font-size: 14px;
                color: gray;
                text-decoration: none;
            }

            .forgot-password:hover {
                color: black;
            }
        </style>
    </head>

    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Username" />
            </div>

            <div class="mt-4">
                <x-input id="password" class="block w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password" placeholder="Password" />
            </div>

            <div class="block mt-4 text-left">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit">Login</button>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </form>
    </div>
</x-guest-layout>
