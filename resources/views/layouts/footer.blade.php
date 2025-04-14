<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer - Mara Savings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <style>
        @font-face {
          font-family: 'Futura LT';
          src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
               url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
               url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }
        /* Base styles */
        * {
            font-family: 'Futura LT', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        footer {
            background: #45a049;
            color: #ffffff;
            padding: 5rem 2rem 1rem;
            position: relative;
        }

        /* Wave decoration at the top */
        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' opacity='.1'%3E%3C/path%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' fill='%23ffffff' opacity='.2'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            transform: rotateX(180deg);
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 2rem;
        }

        .footer-section {
            padding: 0 1rem;
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: #ffffff;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .footer-logo i {
            font-size: 2rem;
            color: #ffffff;
            margin-right: 0.5rem;
        }

        .footer-logo span {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
        }

        .footer-section p {
            color: #ffffff;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 0.75rem;
        }

        .footer-section a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .footer-section a:hover {
            color: #e0f2e1;
            transform: translateX(5px);
        }

        .footer-section i {
            color: #ffffff;
            font-size: 1.1rem;
        }

        .social-icons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .social-icons a:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .social-icons i {
            color: #ffffff;
            font-size: 1.2rem;
        }

        .newsletter-form {
            display: flex;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .newsletter-form input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .newsletter-form input:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        .newsletter-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            background: #2c6a2e;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0 1rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .newsletter-form button:hover {
            background: #225322;
        }

        .divider {
            margin: 2rem 0;
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bottom-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .bottom-footer a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 1rem;
            transition: color 0.2s ease;
        }

        .bottom-footer a:hover {
            color: #e0f2e1;
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .footer-section h3::after {
                left: 0;
            }

            .bottom-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .bottom-footer .links {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
            }

            .bottom-footer a {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <!-- About Us -->
            <div class="footer-section">
                <div class="footer-logo">
                    <i class="mdi mdi-bank"></i>
                    <span>Mara Savings</span>
                </div>
                <p>
                    Your trusted financial partner for savings, loans, and investment solutions. We help individuals and businesses achieve financial security and growth with personalized financial services.
                </p>
                <div class="newsletter-form">
                    <input type="email" placeholder="Your email address">
                    <button>Subscribe</button>
                </div>
                <div class="social-icons">
                    <a href="#"><i class="mdi mdi-facebook"></i></a>
                    <a href="#"><i class="mdi mdi-twitter"></i></a>
                    <a href="#"><i class="mdi mdi-linkedin"></i></a>
                    <a href="#"><i class="mdi mdi-instagram"></i></a>
                </div>
            </div>

            <!-- Services -->
            <div class="footer-section">
                <h3>Our Services</h3>
                <ul>
                    <li><a href="/services"><i class="mdi mdi-view-grid"></i>All Services</a></li>
                    <li><a href="/savings"><i class="mdi mdi-piggy-bank"></i>Savings Accounts</a></li>
                    <li><a href="/loans"><i class="mdi mdi-cash-multiple"></i>Loans</a></li>
                    <li><a href="/investments"><i class="mdi mdi-chart-line"></i>Investments</a></li>
                    <li><a href="/retirement"><i class="mdi mdi-currency-usd"></i>Retirement Planning</a></li>
                    <li><a href="/insurance"><i class="mdi mdi-shield-check"></i>Insurance</a></li>
                    <li><a href="/financial-advisory"><i class="mdi mdi-account-tie"></i>Financial Advisory</a></li>
                    <li><a href="/mobile-banking"><i class="mdi mdi-cellphone"></i>Mobile Banking</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="/online-banking"><i class="mdi mdi-account-circle"></i>Online Banking</a></li>
                    <li><a href="/help-center"><i class="mdi mdi-headset"></i>Help Center</a></li>
                    <li><a href="/resources"><i class="mdi mdi-file-document"></i>Resources</a></li>
                    <li><a href="/financial-education"><i class="mdi mdi-lightbulb"></i>Financial Education</a></li>
                    <li><a href="/workshops"><i class="mdi mdi-school"></i>Financial Workshops</a></li>
                    <li><a href="/faq"><i class="mdi mdi-help-circle"></i>FAQ</a></li>
                    <li><a href="/contact"><i class="mdi mdi-message-text"></i>Contact Support</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div class="footer-section">
                <h3>Contact Information</h3>
                <p><i class="mdi mdi-map-marker"></i>123 Financial Avenue, Mara City, MC 12345</p>
                <p><a href="tel:+15551234567"><i class="mdi mdi-phone"></i>(555) 123-4567</a></p>
                <p><a href="mailto:info@marasavings.com"><i class="mdi mdi-email"></i>info@marasavings.com</a></p>
                <p><i class="mdi mdi-clock-time-three"></i>Monday - Friday: 9AM - 5PM<br>Saturday: 9AM - 1PM<br>24/7 Online Banking</p>
            </div>
        </div>

        <hr class="divider">

        <div class="bottom-footer">
            <div class="copyright">&copy; 2025 Mara Savings. All rights reserved.</div>
            <div class="links">
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
                <a href="/security">Security Statement</a>
                <a href="/sitemap">Sitemap</a>
            </div>
        </div>
    </footer>
</body>
</html>
