<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About TallyUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .gradient-text {
            background: linear-gradient(to right, #fff, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #4F46E5, #7C3AED, #2563EB);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #EC4899, #8B5CF6, #3B82F6);
        }
        .gradient-accent {
            background: linear-gradient(135deg, #06B6D4, #3B82F6, #8B5CF6);
        }
        
        /* Particle animation for floating elements */
        .particle {
            animation: particle-float 8s ease-in-out infinite;
        }
        @keyframes particle-float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -10px) rotate(5deg); }
            50% { transform: translate(-5px, -20px) rotate(-5deg); }
            75% { transform: translate(-10px, -5px) rotate(3deg); }
        }
    </style>
</head>
<body class="bg-[conic-gradient(at_bottom_left,_var(--tw-gradient-stops))] from-indigo-900 via-purple-900 to-blue-900 text-white min-h-screen">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-4 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0">
            <!-- Abstract shapes and particles -->
            <div class="particle absolute top-20 left-1/4 w-32 h-32 rounded-full bg-gradient-secondary opacity-20 blur-2xl"></div>
            <div class="particle absolute top-40 right-1/4 w-40 h-40 rounded-full bg-gradient-accent opacity-20 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
            
            <!-- Code snippets floating -->
            <div class="particle absolute top-20 right-10 p-4 bg-gray-800/30 backdrop-blur-sm rounded-lg border border-gray-700 hidden lg:block">
                <pre class="text-xs text-indigo-300">
const revenue = calculateRevenue();
profit.increase(revenue);</pre>
            </div>
            
            <!-- Floating metrics -->
            <div class="particle absolute bottom-40 left-10 p-4 bg-gray-800/30 backdrop-blur-sm rounded-lg border border-gray-700 hidden lg:block">
                <div class="text-emerald-400 text-sm">↑ 23% Growth</div>
            </div>
        </div>
        
        <div class="relative max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-left space-y-8">
                    <h1 class="text-6xl md:text-7xl font-bold">
                        <span class="gradient-text">Revolutionize</span>
                        <br />Your Business
                    </h1>
                    <p class="text-xl text-indigo-200 max-w-2xl">
                        Streamline financial operations in your F&B business with our all-in-one solution for staff scheduling, payroll processing, and sales analytics.
                    </p>
                    <div class="flex gap-4">
                        <a href="/" class="group relative inline-flex items-center overflow-hidden rounded-full bg-indigo-600 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500">
                            <span class="absolute -end-full transition-all group-hover:end-4">
                                →
                            </span>
                            <span class="text-sm font-medium transition-all group-hover:me-4">
                                Get Started
                            </span>
                        </a>
                        <a href="#demo" class="inline-flex items-center px-8 py-3 rounded-full border border-indigo-400 text-indigo-400 hover:bg-indigo-400 hover:text-white transition">
                            Watch Demo
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="animate-float">
                        <!-- <img src="/img/dashboard-preview.png" alt="TallyUp Dashboard" class="rounded-xl shadow-2xl shadow-indigo-500/20" /> -->
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full blur-xl opacity-50"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-xl opacity-50"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section (New) -->
    <!-- <section id="demo" class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12 text-center gradient-text">See TallyUp in Action</h2>
            <div class="relative rounded-2xl overflow-hidden bg-indigo-800/20 backdrop-blur-sm p-8">
                <div class="aspect-video">
                    <img src="/img/app-demo.png" alt="TallyUp Demo" class="rounded-lg shadow-2xl" />
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/80 to-transparent flex items-end justify-center pb-8">
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-indigo-900 px-6 py-3 rounded-full font-medium hover:bg-indigo-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                        </svg>
                        Watch Full Demo
                    </a>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Why TallyUp Section -->
    <section class="py-20 bg-indigo-800/50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12 text-center">Why TallyUp Exists</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4">Simplify Management</h3>
                    <p class="text-indigo-200">Streamline your staff scheduling, payroll processing, and inventory management in one unified platform.</p>
                </div>
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4">Save Time</h3>
                    <p class="text-indigo-200">Automate repetitive tasks and reduce manual data entry with our intelligent workflow systems.</p>
                </div>
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4">Boost Efficiency</h3>
                    <p class="text-indigo-200">Make data-driven decisions with real-time analytics and comprehensive reporting tools.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12 text-center">What TallyUp Offers</h2>
            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-indigo-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Staff Management</h3>
                            <p class="text-indigo-200">Comprehensive employee profiles, shift scheduling, and attendance tracking.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-indigo-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Automated Payroll</h3>
                            <p class="text-indigo-200">Automated calculations based on individual staff rates and employment types.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-indigo-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Inventory Control</h3>
                            <p class="text-indigo-200">Track stock levels, manage invoices, and monitor supplies efficiently.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-indigo-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Sales Analytics</h3>
                            <p class="text-indigo-200">Comprehensive sales tracking and performance analytics dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-indigo-900/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <p class="text-indigo-200">© 2024 TallyUp. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="https://www.linkedin.com/in/mrnrhkm/" class="text-indigo-200 hover:text-white transition duration-150">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <a href="https://github.com/amirrhkm" class="text-indigo-200 hover:text-white transition duration-150">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
