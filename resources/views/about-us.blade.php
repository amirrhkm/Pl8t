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
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #ff7e5f, #feb47b, #ff6f61);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fad0c4);
        }
        .gradient-accent {
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee, #fbc2eb);
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
        .random-float {
            position: absolute;
            animation: random-float 10s infinite;
        }
        @keyframes random-float {
            0% { transform: translate(0, 0); }
            25% { transform: translate(calc(10px * var(--random-x)), calc(10px * var(--random-y))); }
            50% { transform: translate(calc(-10px * var(--random-x)), calc(-10px * var(--random-y))); }
            75% { transform: translate(calc(5px * var(--random-x)), calc(5px * var(--random-y))); }
            100% { transform: translate(0, 0); }
        }
        .interactive:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const particles = document.querySelectorAll('.random-float');
            particles.forEach(particle => {
                particle.style.setProperty('--random-x', Math.random() * 2 - 1);
                particle.style.setProperty('--random-y', Math.random() * 2 - 1);
            });
        });
    </script>
</head>
<body class="bg-[conic-gradient(at_bottom_left,_var(--tw-gradient-stops))] from-pink-900 via-red-900 to-yellow-900 text-white min-h-screen">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-4 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0">
            <!-- Abstract shapes and particles -->
            <div class="particle absolute top-20 left-1/4 w-32 h-32 rounded-full bg-gradient-secondary opacity-20 blur-2xl"></div>
            <div class="particle absolute top-40 right-1/4 w-40 h-40 rounded-full bg-gradient-accent opacity-20 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
            
            <!-- Code snippets floating -->
            <div class="random-float top-20 right-10 p-4 bg-gray-800/30 backdrop-blur-sm rounded-lg border border-gray-700 hidden lg:block">
                <pre class="text-xs text-indigo-300">
const revenue = calculateRevenue();
profit.increase(revenue);</pre>
            </div>
            
            <!-- Floating metrics -->
            <div class="random-float bottom-40 left-10 p-4 bg-gray-800/30 backdrop-blur-sm rounded-lg border border-gray-700 hidden lg:block">
                <div class="text-emerald-400 text-sm">↑ 99.99% Growth</div>
            </div>
        </div>
        
        <div class="relative max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-left space-y-8">
                    <h1 class="text-6xl md:text-7xl font-bold">
                        <span class="gradient-text">Revolutionize</span>
                        <br />Your Business
                    </h1>
                    <p class="text-xl text-pink-200 max-w-2xl">
                        Streamline financial operations in your F&B business with our all-in-one solution for staff scheduling, payroll processing, and sales analytics.
                    </p>
                    <div class="flex gap-4">
                        <a href="/login" class="group relative inline-flex items-center overflow-hidden rounded-full bg-pink-600 px-8 py-3 text-white focus:outline-none focus:ring active:bg-pink-500 interactive">
                            <span class="absolute -end-full transition-all group-hover:end-4">
                                →
                            </span>
                            <span class="text-sm font-medium transition-all group-hover:me-4">
                                Get Started
                            </span>
                        </a>
                        <a href="#demo" class="inline-flex items-center px-8 py-3 rounded-full border border-pink-400 text-pink-400 hover:bg-pink-400 hover:text-white transition interactive">
                            Watch Demo
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="animate-float">
                        <!-- <img src="/img/dashboard-preview.png" alt="TallyUp Dashboard" class="rounded-xl shadow-2xl shadow-pink-500/20" /> -->
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-r from-yellow-500 to-red-500 rounded-full blur-xl opacity-50"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-gradient-to-r from-green-500 to-blue-500 rounded-full blur-xl opacity-50"></div>
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

    <!-- Transforming F&B Section - Diagonal with offset grid -->
    <section class="py-20 relative">
        <div class="absolute inset-0 bg-indigo-900/50 transform -skew-y-3"></div>
        <div class="max-w-7xl mx-auto px-4 relative">
            <h2 class="text-4xl font-bold mb-16 text-center">Transforming F&B Management</h2>
            <div class="grid md:grid-cols-3 gap-8 md:gap-12">
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm transform md:translate-y-12">
                    <h3 class="text-2xl font-semibold mb-4">Simplify Management</h3>
                    <p class="text-indigo-200">Streamline your staff scheduling, payroll processing, and inventory management in one unified platform.</p>
                </div>
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4">Save Time</h3>
                    <p class="text-indigo-200">Automate repetitive tasks and reduce manual data entry with our intelligent workflow systems.</p>
                </div>
                <div class="bg-indigo-700/50 p-8 rounded-xl backdrop-blur-sm transform md:translate-y-24">
                    <h3 class="text-2xl font-semibold mb-4">Boost Efficiency</h3>
                    <p class="text-indigo-200">Make data-driven decisions with real-time analytics and comprehensive reporting tools.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Origin Story Section - Zigzag layout -->
    <section class="relative py-32">
        <div class="absolute inset-0">
            <div class="particle absolute top-20 left-1/4 w-24 h-24 rounded-full bg-gradient-primary opacity-20 blur-xl"></div>
            <div class="particle absolute bottom-20 right-1/4 w-32 h-32 rounded-full bg-gradient-secondary opacity-20 blur-xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-20 text-center gradient-text">From Challenge to Innovation</h2>
            
            <div class="space-y-24">
                <!-- Challenge Block -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="bg-indigo-900/30 backdrop-blur-sm rounded-2xl p-8 border border-indigo-500/30 transform hover:scale-105 transition-transform">
                        <h3 class="text-xl font-semibold mb-4 text-indigo-300">The Challenge</h3>
                        <p class="text-indigo-200">Working in F&B, we witnessed firsthand the struggles with manual payroll calculations. Staff members tracked their own hours, leading to discrepancies and confusion in salary calculations.</p>
                    </div>
                    <div class="relative hidden md:block">
                        <div class="absolute -top-8 -right-8 w-32 h-32 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
                        <div class="h-48 bg-indigo-500/10 rounded-lg animate-float flex items-center justify-center">
                            <svg class="w-24 h-24 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Vision Block -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="relative hidden md:block order-2">
                        <div class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
                        <div class="h-48 bg-indigo-500/10 rounded-lg animate-float flex items-center justify-center">
                            <svg class="w-24 h-24 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-indigo-900/30 backdrop-blur-sm rounded-2xl p-8 border border-indigo-500/30 transform hover:scale-105 transition-transform order-1">
                        <h3 class="text-xl font-semibold mb-4 text-indigo-300">The Vision</h3>
                        <p class="text-indigo-200">What started as a simple payroll calculator evolved into something bigger. Managers needed a centralized system for everything - from staff scheduling to inventory management.</p>
                    </div>
                </div>

                <!-- Solution Block -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="bg-indigo-900/30 backdrop-blur-sm rounded-2xl p-8 border border-indigo-500/30 transform hover:scale-105 transition-transform">
                        <h3 class="text-xl font-semibold mb-4 text-indigo-300">The Solution</h3>
                        <p class="text-indigo-200">TallyUp was born to bridge this gap, offering a comprehensive solution that handles payroll automation, staff scheduling, inventory tracking, and business analytics - all in one place.</p>
                    </div>
                    <div class="relative hidden md:block">
                        <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
                        <div class="h-48 bg-indigo-500/10 rounded-lg animate-float flex items-center justify-center">
                            <svg class="w-24 h-24 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section - Hexagon Grid -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/50 to-purple-900/50 transform skew-y-3"></div>
        <div class="max-w-7xl mx-auto px-4 relative">
            <h2 class="text-4xl font-bold mb-20 text-center">Powering Your Success</h2>
            <div class="grid md:grid-cols-2 gap-16">
                <!-- Left Column -->
                <div class="space-y-12 transform md:-translate-y-8">
                    <!-- Staff Management -->
                    <div class="group hover:scale-105 transition-transform">
                        <div class="flex items-start space-x-4 bg-indigo-700/30 p-6 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-indigo-400 mt-1 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Staff Management</h3>
                                <p class="text-indigo-200">Comprehensive employee profiles, shift scheduling, and attendance tracking.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payroll Processing -->
                    <div class="group hover:scale-105 transition-transform">
                        <div class="flex items-start space-x-4 bg-indigo-700/30 p-6 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-indigo-400 mt-1 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Payroll Processing</h3>
                                <p class="text-indigo-200">Automated salary calculations, overtime tracking, and payment management.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Dashboard -->
                    <div class="group hover:scale-105 transition-transform">
                        <div class="flex items-start space-x-4 bg-indigo-700/30 p-6 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-indigo-400 mt-1 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Analytics Dashboard</h3>
                                <p class="text-indigo-200">Real-time insights into sales, labor costs, and business performance metrics.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-12 transform md:translate-y-12">
                    <!-- Inventory Management -->
                    <div class="group hover:scale-105 transition-transform">
                        <div class="flex items-start space-x-4 bg-indigo-700/30 p-6 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-indigo-400 mt-1 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Inventory Management</h3>
                                <p class="text-indigo-200">Track stock levels, manage suppliers, and automate purchase orders.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Tracking -->
                    <div class="group hover:scale-105 transition-transform">
                        <div class="flex items-start space-x-4 bg-indigo-700/30 p-6 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-indigo-400 mt-1 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-semibold mb-2">Sales Tracking</h3>
                                <p class="text-indigo-200">Monitor daily sales, analyze trends, and generate detailed reports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-32">
        <div class="absolute inset-0">
            <div class="particle absolute top-20 left-1/4 w-24 h-24 rounded-full bg-gradient-primary opacity-20 blur-xl"></div>
            <div class="particle absolute bottom-20 right-1/4 w-32 h-32 rounded-full bg-gradient-secondary opacity-20 blur-xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-20 text-center gradient-text">The Journey of TallyUp</h2>
            
            <div class="space-y-12">
                <div class="bg-indigo-900/30 backdrop-blur-sm rounded-2xl p-8 border border-indigo-500/30 transform hover:scale-105 transition-transform">
                    <p class="text-indigo-200 leading-relaxed">
                        Hi, I'm Amir Nurhakim, a 23-year-old developer passionate about creating impactful solutions. TallyUp began as a personal project to enhance my portfolio with a practical application. While working at Bask Bear Coffee, I noticed a recurring issue: part-time staff, including myself, often faced discrepancies in payroll calculations. This inspired me to develop a tool that automates payroll by integrating shift assignments and calculations.
                    </p>
                    <p class="text-indigo-200 leading-relaxed mt-4">
                        As I delved deeper, I realized the potential to expand this tool into a comprehensive admin dashboard. This would not only streamline payroll but also provide business analytics to guide sales and operational strategies. Thus, TallyUp evolved to include sales and inventory modules, tailored to meet the specific needs of franchise outlets like ours, without relying on third-party integrations.
                    </p>
                    <p class="text-indigo-200 leading-relaxed mt-4">
                        TallyUp is more than just a project; it's a solution born from real-world challenges, designed to empower managers with the tools they need to succeed. I hope this origin story gives inspiration to some of the fresh graduates who want to offer something by providing a service from their own design.
                    </p>
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
