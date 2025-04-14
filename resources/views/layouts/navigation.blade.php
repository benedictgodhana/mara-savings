<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mara Savings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @font-face {
          font-family: 'Futura LT';
          src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
               url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
               url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }

        .nav-bg {
            background:#45a049;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .nav-scrolled {
            background:#45a049;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .text-primary {
            color: #0d9488;
        }

        .bg-primary {
            background: linear-gradient(135deg, #0d9488, #0f766e);
        }

        .hover-effect {
            position: relative;
            overflow: hidden;
        }

        .hover-effect::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #0d9488;
            transition: width 0.3s ease;
        }

        .hover-effect:hover::after {
            width: 100%;
        }

        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.show {
            transform: translateX(0);
        }

        .menu-backdrop {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .menu-backdrop.show {
            opacity: 1;
        }

        @keyframes logoBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .logo-icon {
            animation: logoBounce 2s ease-in-out infinite;
        }

        .contact-button {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
            transition: all 0.3s ease;
        }

        .contact-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
        }

        .login-button {
            background: transparent;
            border: 2px solid #0d9488;
            color: #0d9488;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: rgba(13, 148, 136, 0.1);
            transform: translateY(-2px);
        }

        .nav-icon {
            transition: all 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            transform: translateY(-3px);
        }

        .merch-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .merch-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #0d9488;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .price-tag {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            border-radius: 6px;
            padding: 5px 10px;
            color: white;
            font-weight: 600;
        }

        @media (min-width: 1024px) {
            .mobile-menu {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-white Futura LT antialiased">
    <!-- Backdrop -->
    <div id="menuBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 menu-backdrop hidden lg:hidden"></div>

    <nav class="fixed w-full top-0 z-50 nav-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="#" class="flex items-center">
                    <i class="fas fa-piggy-bank text-3xl text-white logo-icon"></i>
                    <i class="fas fa-coins text-xl text-white ml-1 logo-icon" style="animation-delay: 0.2s"></i>
                    <span class="ml-2 text-2xl font-bold text-white">Mara Savings</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="/" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Home
                </a>
                <a href="/accounts" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Accounts
                </a>

                <a href="/savings" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Savings
                </a>
                <a href="/loans" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Loans
                </a>
                <a href="/investments" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Investments
                </a>
                <a href="/retirement" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Retirement
                </a>
                <a href="/financial-planning" class="nav-link text-white hover:text-teal-200 px-3 py-2 text-sm font-medium flex flex-col items-center">
                    Planning
                </a>

               
                <div class="flex items-center space-x-4">
                    <a href="/register" class="bg-white text-green-600 hover:bg-green-50 px-6 py-2 rounded-full text-sm font-medium flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                         Account
                    </a>
                    <a href="/login" class="bg-teal-600 hover:bg-teal-500 text-white px-6 py-2 rounded-full text-sm font-medium flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Login
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menuButton" class="lg:hidden text-white p-2 rounded-lg hover:bg-teal-600">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu fixed top-20 left-0 w-full bg-white shadow-xl z-50">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="/" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-home text-lg mr-3"></i> Home
            </a>
            <a href="/accounts" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-wallet text-lg mr-3"></i> Accounts
            </a>
            <a href="/savings" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-piggy-bank text-lg mr-3"></i> Savings
            </a>
            <a href="/loans" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-hand-holding-usd text-lg mr-3"></i> Loans
            </a>
            <a href="/investments" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-chart-line text-lg mr-3"></i> Investments
            </a>
            <a href="/retirement" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-umbrella-beach text-lg mr-3"></i> Retirement
            </a>
            <a href="/financial-planning" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-calculator text-lg mr-3"></i> Financial Planning
            </a>
            <a href="/mobile-banking" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-mobile-alt text-lg mr-3"></i> Mobile Banking
                <span class="ml-2 bg-teal-500 text-white text-xs rounded-full px-2 py-1">New</span>
            </a>
            <a href="/resources" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-book text-lg mr-3"></i> Resources
            </a>
            <a href="/locations" class="block text-slate-800 px-4 py-3 rounded-lg hover:bg-slate-100 flex items-center">
                <i class="fas fa-map-marker-alt text-lg mr-3"></i> Locations
            </a>
            <div class="pt-4 space-y-2">
                <a href="/register" class="bg-white border-2 border-green-500 text-green-600 block w-full text-center px-4 py-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </a>
                <a href="/login" class="bg-teal-600 block w-full text-white text-center px-4 py-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-circle mr-2"></i> Login
                </a>
            </div>
        </div>
    </div>
</nav>

    <!-- Spacer -->

    <script>
        // Mobile Menu Toggle
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuBackdrop = document.getElementById('menuBackdrop');
        let isMenuOpen = false;

        function toggleMenu() {
            isMenuOpen = !isMenuOpen;
            mobileMenu.classList.toggle('show');
            menuBackdrop.classList.toggle('show');
            menuButton.innerHTML = isMenuOpen ?
                '<i class="fas fa-times text-2xl"></i>' :
                '<i class="fas fa-bars text-2xl"></i>';
        }

        menuButton.addEventListener('click', toggleMenu);
        menuBackdrop.addEventListener('click', toggleMenu);

        // Close menu on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isMenuOpen) toggleMenu();
        });

        // Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });

        // Active Link Detection
        const currentUrl = window.location.pathname;
        document.querySelectorAll('nav a').forEach(link => {
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>
