<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Namib</title>

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
    </style>
</head>
<body class="futura antialiased">
    <div class="min-h-screen overlay flex items-center justify-center p-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-lg w-full max-w-md p-6 sm:p-8 shadow-xl">

            <!-- Maritime Logo -->
            <div class="flex justify-center mb-6">
                <a href="/" class="brand-link">
                    <img src="/images/nch-removebg-preview.png" alt="Maritime Freight Logo" class="h-16">
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Reset Password</h2>

            <div class="mb-6 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <!-- Status Message Container -->
            <div id="status-message" class="mb-4 text-sm text-green-600 hidden"></div>

            <form id="resetForm" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1">
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
                            autofocus />
                        <div class="mt-1 text-red-500 text-sm" id="email-error"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-700">
                        <i class="fas fa-arrow-left mr-1"></i> Back to login
                    </a>
                    <button id="resetButton" type="submit"
                    class="flex items-center justify-center bg-green-600 hover:bg-green-700 text-white py-2.5 px-4 rounded-md transition-colors">
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 0116 0h-2a6 6 0 00-12 0H4z">
                        </path>
                    </svg>
                    <i class="fas fa-paper-plane mr-2"></i>
                    <span id="buttonText">Email Password Reset Link</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form submission
        document.getElementById("resetForm").addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);
            const resetButton = document.getElementById("resetButton");
            const buttonText = document.getElementById("buttonText");
            const loadingSpinner = document.getElementById("loadingSpinner");

            // Clear previous errors
            document.getElementById('email-error').textContent = "";

            // Show loading state
            resetButton.disabled = true;
            buttonText.textContent = "Sending...";
            loadingSpinner.classList.remove("hidden");

            toastr.info('Sending reset link, please wait...', 'Processing');

            try {
                const response = await fetch("{{ route('password.email') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
                        "Accept": "application/json",
                    },
                    body: formData
                });

                const isJson = response.headers.get("content-type")?.includes("application/json");
                const data = isJson ? await response.json() : {};

                if (!response.ok) {
                    if (isJson && data.errors) {
                        if (data.errors.email) {
                            document.getElementById('email-error').textContent = data.errors.email[0];
                        }
                        toastr.error('Please check the form for errors.', 'Request Failed');
                    } else {
                        toastr.error('Something went wrong. Please try again.', 'Error');
                    }
                    return;
                }

                // If response is successful
                const statusMessage = document.getElementById('status-message');
                statusMessage.textContent = data.status || "Password reset link sent successfully!";
                statusMessage.classList.remove("hidden");

                toastr.success('Password reset link has been sent to your email.', 'Success');

            } catch (error) {
                console.error("Reset request error:", error);
                toastr.error('Something went wrong. Please try again.', 'Error');
            } finally {
                // Reset button state after request completes
                resetButton.disabled = false;
                buttonText.textContent = "Email Password Reset Link";
                loadingSpinner.classList.add("hidden");
            }
        });
    </script>
</body>
</html>
