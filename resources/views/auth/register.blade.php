<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Namib</title>

    <link rel="icon" type="image/png" href="/images/logo-removebg-preview.png">

    <!-- Toastr for notifications -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @font-face {
            font-family: 'Futura LT';
            src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
                 url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
                 url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            font-family: 'Futura LT', sans-serif;
            background-image: url('/Images/woman-with-yellow-piggy-bank-hands(1).jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.2); /* Lighter overlay for better visibility */
            backdrop-filter: blur(1px); /* Reduced blur for clearer background */
        }

        .toggle-password {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toggle-password:hover {
            color: #45a049;
        }
    </style>
</head>
<body class="futura antialiased">
    <div class="min-h-screen overlay flex items-center justify-center p-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-lg w-full max-w-md p-6 sm:p-8 shadow-xl">

            <!-- Maritime Logo -->
            <div class="flex justify-center mb-6">
                <a href="/" class="brand-link">
                    <img src="/images/nch-removebg-preview.png" alt="Mara Savings Logo" class="h-16">
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>

            <!-- Status Message Container -->
            <div id="status-message" class="mb-4 text-sm text-green-600 hidden"></div>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="text-sm font-medium text-gray-700">Name</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input
                            id="name"
                            class="pl-10 w-full rounded-md border border-gray-300 py-2.5 px-3 focus:ring-1 focus:ring-green-500 focus:border-green-500"
                            type="text"
                            name="name"
                            required
                            autofocus
                            autocomplete="name" />
                        <div class="mt-1 text-red-500 text-sm" id="name-error"></div>
                    </div>
                </div>

                <!-- Username (New Field) -->
                <div class="mt-4 space-y-1">
                    <label for="username" class="text-sm font-medium text-gray-700">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-at"></i>
                        </span>
                        <input
                            id="username"
                            class="pl-10 w-full rounded-md border border-gray-300 py-2.5 px-3 focus:ring-1 focus:ring-green-500 focus:border-green-500"
                            type="text"
                            name="username"
                            required
                            autocomplete="username" />
                        <div class="mt-1 text-red-500 text-sm" id="username-error"></div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mt-4 space-y-1">
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input
                            id="email"
                            class="pl-10 w-full rounded-md border border-gray-300 py-2.5 px-3 focus:ring-1 focus:ring-green-500 focus:border-green-500"
                            type="email"
                            name="email"
                            required
                            autocomplete="email" />
                        <div class="mt-1 text-red-500 text-sm" id="email-error"></div>
                    </div>
                </div>

                <!-- Password -->
                <div class="mt-4 space-y-1">
                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            id="password"
                            class="pl-10 pr-10 w-full rounded-md border border-gray-300 py-2.5 px-3 focus:ring-1 focus:ring-green-500 focus:border-green-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password" />
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 toggle-password" id="togglePassword">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </span>
                        <div class="mt-1 text-red-500 text-sm" id="password-error"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4 space-y-1">
                    <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            id="password_confirmation"
                            class="pl-10 pr-10 w-full rounded-md border border-gray-300 py-2.5 px-3 focus:ring-1 focus:ring-green-500 focus:border-green-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password" />
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 toggle-password" id="toggleConfirmPassword">
                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                        </span>
                        <div class="mt-1 text-red-500 text-sm" id="password_confirmation-error"></div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-700">
                        Already registered?
                    </a>
                    <button id="registerButton" type="submit"
                    class="ml-4 flex items-center justify-center bg-green-600 hover:bg-green-700 text-white py-2.5 px-6 rounded-md transition-colors">
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 0116 0h-2a6 6 0 00-12 0H4z">
                        </path>
                    </svg>
                    <i class="fas fa-user-plus mr-2"></i>
                    <span id="buttonText">Register</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById("togglePassword").addEventListener("click", function() {
            togglePasswordVisibility("password", "passwordIcon");
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
            togglePasswordVisibility("password_confirmation", "confirmPasswordIcon");
        });

        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }

        // Form submission
        document.getElementById("registerForm").addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);
            const registerButton = document.getElementById("registerButton");
            const buttonText = document.getElementById("buttonText");
            const loadingSpinner = document.getElementById("loadingSpinner");

            // Clear previous errors
            document.getElementById('name-error').textContent = "";
            document.getElementById('username-error').textContent = ""; // New error field
            document.getElementById('email-error').textContent = "";
            document.getElementById('password-error').textContent = "";
            document.getElementById('password_confirmation-error').textContent = "";

            // Show loading state
            registerButton.disabled = true;
            buttonText.textContent = "Registering...";
            loadingSpinner.classList.remove("hidden");

            toastr.info('Creating your account, please wait...', 'Processing');

            try {
                const response = await fetch("{{ route('register') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
                        "Accept": "application/json",
                    },
                    body: formData
                });

                const isJson = response.headers.get("content-type")?.includes("application/json");

                if (!response.ok) {
                    if (isJson) {
                        const data = await response.json();
                        if (data.errors) {
                            if (data.errors.name) {
                                document.getElementById('name-error').textContent = data.errors.name[0];
                            }
                            if (data.errors.username) {
                                document.getElementById('username-error').textContent = data.errors.username[0];
                            }
                            if (data.errors.email) {
                                document.getElementById('email-error').textContent = data.errors.email[0];
                            }
                            if (data.errors.password) {
                                document.getElementById('password-error').textContent = data.errors.password[0];
                            }
                            if (data.errors.password_confirmation) {
                                document.getElementById('password_confirmation-error').textContent = data.errors.password_confirmation[0];
                            }
                            toastr.error('Please check the form for errors.', 'Registration Failed');
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.', 'Error');
                    }
                    return;
                }

                // If response is successful
                toastr.success('Registration successful! Redirecting...', 'Success');
                setTimeout(() => {
                    window.location.href = "{{ route('dashboard') }}";
                }, 2000);

            } catch (error) {
                console.error("Registration error:", error);
                toastr.error('Something went wrong. Please try again.', 'Error');
            } finally {
                // Reset button state after request completes
                registerButton.disabled = false;
                buttonText.textContent = "Register";
                loadingSpinner.classList.add("hidden");
            }
        });
    </script>
</body>
</html>
