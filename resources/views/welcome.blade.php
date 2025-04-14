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
    .hero-glow {
      position: relative;
      overflow: hidden;
    }
    .hero-glow::after {
      content: '';
      position: absolute;
      width: 120%;
      height: 120%;
      top: -10%;
      left: -10%;
      background: radial-gradient(circle at 50% 50%, rgba(69, 160, 73, 0.15) 0%, rgba(69, 160, 73, 0) 70%);
      pointer-events: none;
    }
    .modern-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
    }
    .gradient-border {
      position: relative;
      background-clip: padding-box;
      border: 1px solid transparent;
    }
    .gradient-border::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      z-index: -1;
      margin: -1px;
      border-radius: inherit;
      background: linear-gradient(45deg, #45a049, #2e7d32);
    }
    .hover-tilt {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-tilt:hover {
      transform: perspective(1000px) rotateX(2deg) rotateY(2deg) scale(1.02);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .section-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, #45a049, #2e7d32);
      margin: 1rem auto;
    }
    .stat-number {
      background: linear-gradient(135deg, #45a049, #2e7d32);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .testimonial-card {
      position: relative;
      overflow: hidden;
    }
    .testimonial-card::before {
      content: """;
      position: absolute;
      top: -20px;
      left: 10px;
      font-size: 8rem;
      color: rgba(69, 160, 73, 0.1);
      font-family: Arial;
      line-height: 1;
    }
    .nav-blur {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
    }
    .floating {
      animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }

    /* Carousel Styles */
    .carousel {
      position: relative;
      overflow: hidden;
      width: 100%;
      height: 100%;
    }
    .carousel-inner {
      display: flex;
      transition: transform 0.5s ease;
      height: 100%;
    }
    .carousel-item {
      min-width: 100%;
      height: 100%;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
      position: absolute;
      top: 0;
      left: 0;
    }
    .carousel-item.active {
      opacity: 1;
      z-index: 1;
    }
    .carousel-control {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 10;
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: white;
      font-size: 1.5rem;
      backdrop-filter: blur(5px);
      transition: all 0.3s ease;
    }
    .carousel-control:hover {
      background: rgba(255, 255, 255, 0.4);
    }
    .carousel-control-prev {
      left: 20px;
    }
    .carousel-control-next {
      right: 20px;
    }
    .carousel-indicators {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 10px;
      z-index: 10;
    }
    .carousel-indicator {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .carousel-indicator.active {
      background: white;
      transform: scale(1.2);
    }

    /* Nav styles */
    .nav-bg {
      background:#45a049;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      transform: translateY(0);
      transition: all 0.3s ease;
    }
    .nav-scrolled {
      background: #2e7d32;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="bg-gray-50 antialiased font-sans">
  <!-- Navigation placeholder -->
  <!-- <div class="h-20"></div> -->

    <!-- Navigation Bar -->
    @include ('layouts.navigation')
    <div class="h-20"></div>
   <!-- Enhanced Hero Section -->
   <section class="bg-gradient-to-r from-teal-800 to-teal-900 text-white pt-32 pb-28 hero-glow" id="home">
    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
      <div class="animate-fadeIn">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight floating">
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-200 to-green-200">Financial Freedom</span>
          <span class="block text-3xl md:text-5xl font-medium mt-6">Building Tomorrow's Wealth Today</span>
        </h1>
        <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90">Discover personalized savings solutions with competitive rates and expert guidance to help you reach your financial goals.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-12">
          <button class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-xl text-lg font-medium transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
            <span>Start Saving</span>
            <i class="fas fa-arrow-right text-sm"></i>
          </button>
          <button class="border-2 border-white/30 hover:border-white/50 bg-transparent text-white px-8 py-4 rounded-xl text-lg font-medium transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-calculator"></i>
            <span>Calculate Savings</span>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Modern Services Section -->
  <section class="py-20 bg-white" id="services">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <p class="text-green-600 font-semibold mb-2 tracking-widest text-sm uppercase">Financial Solutions</p>
        <h2 class="text-4xl md:text-5xl font-bold mb-4 section-title">Tailored Savings Options</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="modern-card hover-tilt p-8 rounded-2xl relative gradient-border">
          <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl inline-block mb-6">
            <i class="fas fa-piggy-bank text-3xl text-green-600"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3">High-Yield Savings</h3>
          <p class="text-gray-600 mb-4">Maximize your returns with our premium savings accounts offering industry-leading interest rates.</p>
          <a href="#" class="text-green-600 font-medium group inline-flex items-center gap-2">
            Explore Options
            <i class="fas fa-arrow-right transition-all group-hover:translate-x-1"></i>
          </a>
        </div>

        <div class="modern-card hover-tilt p-8 rounded-2xl relative gradient-border">
          <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl inline-block mb-6">
            <i class="fas fa-chart-line text-3xl text-green-600"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3">Investment Portfolios</h3>
          <p class="text-gray-600 mb-4">Diversified investment options designed to grow your wealth with personalized risk profiles.</p>
          <a href="#" class="text-green-600 font-medium group inline-flex items-center gap-2">
            Start Investing
            <i class="fas fa-arrow-right transition-all group-hover:translate-x-1"></i>
          </a>
        </div>

        <div class="modern-card hover-tilt p-8 rounded-2xl relative gradient-border">
          <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl inline-block mb-6">
            <i class="fas fa-umbrella-beach text-3xl text-green-600"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3">Retirement Planning</h3>
          <p class="text-gray-600 mb-4">Secure your future with tax-advantaged retirement accounts and expert planning guidance.</p>
          <a href="#" class="text-green-600 font-medium group inline-flex items-center gap-2">
            Plan Ahead
            <i class="fas fa-arrow-right transition-all group-hover:translate-x-1"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  @include ('layouts.footer')

  <script>
    // Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
      const items = document.querySelectorAll('.carousel-item');
      const indicators = document.querySelectorAll('.carousel-indicator');
      const prevButton = document.querySelector('.carousel-control-prev');
      const nextButton = document.querySelector('.carousel-control-next');
      let currentIndex = 0;
      const totalItems = items.length;

      function updateCarousel() {
        // Update items
        items.forEach((item, index) => {
          item.classList.remove('active');
          if (index === currentIndex) {
            item.classList.add('active');
          }
        });

        // Update indicators
        indicators.forEach((indicator, index) => {
          indicator.classList.remove('active');
          if (index === currentIndex) {
            indicator.classList.add('active');
          }
        });
      }

      function goToNext() {
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
      }

      function goToPrev() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
      }

      // Set up auto slide
      let carouselInterval = setInterval(goToNext, 5000);

      function resetInterval() {
        clearInterval(carouselInterval);
        carouselInterval = setInterval(goToNext, 5000);
      }

      // Event listeners
      prevButton.addEventListener('click', () => {
        goToPrev();
        resetInterval();
      });

      nextButton.addEventListener('click', () => {
        goToNext();
        resetInterval();
      });

      indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
          currentIndex = index;
          updateCarousel();
          resetInterval();
        });
      });

      // Initialize
      updateCarousel();
    });

    // Scroll Effect for Navigation
    window.addEventListener('scroll', () => {
      const nav = document.querySelector('nav');
      if (nav && window.scrollY > 50) {
        nav.classList.add('nav-scrolled');
      } else if (nav) {
        nav.classList.remove('nav-scrolled');
      }
    });
  </script>
</body>
</html>
