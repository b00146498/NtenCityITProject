<x-guest-layout>
    <head>
        <!-- ✅ Font Awesome for the eye icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

            .password-wrapper {
                position: relative;
            }

            .toggle-password {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                font-size: 18px;
                color: gray;
            }

            .password-strength {
                font-size: 14px;
                text-align: left;
                margin-top: 4px;
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
                <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Full Name" />
            </div>

            <div class="mt-4">
                <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required placeholder="Email" />
            </div>

            <!-- Password + Visibility + Strength -->
            <div class="mt-4 password-wrapper">
                <x-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </span>
                <div id="strengthMessage" class="password-strength text-muted"></div>
            </div>

            <div class="mt-4">
                <x-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required placeholder="Confirm Password" />
            </div>

            <!-- Role Dropdown -->
            <div class="mt-4">
                <label for="role" class="block font-medium text-sm text-gray-700">Role:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="client">Client</option>
                    <option value="employee">Professional</option>
                </select>
            </div> 

            <button type="submit">Register</button>

            <a class="already-registered" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </form>
    </div>

    <!-- ✅ Password toggle + strength script -->
    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        document.getElementById("password").addEventListener("input", function () {
            const strengthMessage = document.getElementById("strengthMessage");
            const value = this.value;

            if (value.length < 6) {
                strengthMessage.textContent = "Too short (min 6 characters)";
                strengthMessage.style.color = "red";
            } else if (!/[A-Z]/.test(value) || !/[0-9]/.test(value)) {
                strengthMessage.textContent = "Add a number and uppercase letter";
                strengthMessage.style.color = "orange";
            } else {
                strengthMessage.textContent = "Strong password";
                strengthMessage.style.color = "green";
            }
        });
    </script>
</x-guest-layout>
