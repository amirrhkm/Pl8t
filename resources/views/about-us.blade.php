<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About TallyUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Hero Section -->
    <section class="bg-gradient-to-t from-black to-[#1a1a1a] pt-32 pb-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Revolutionize Your Business
            </h1>
            <p class="text-lg md:text-xl text-white/80 mb-8">
                Streamline financial operations in your F&B business with our all-in-one solution.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="/login" class="inline-block px-8 py-3 bg-white text-black rounded-md hover:bg-green-600 hover:text-white transition">
                    Get Started
                </a>
                <a href="#demo" class="inline-block px-8 py-3 border border-white text-white rounded-md hover:bg-white/10 transition">
                    Watch Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 bg-black">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center">Dashboard Preview</h2>
            
            <div x-data="{ 
                currentIndex: 0,
                images: [
                    { 
                        src: '/img/dashboard_main.jpg',
                        title: 'Admin Dashboard', 
                        description: 'Reliable and easy to use tools' 
                    },
                    { 
                        src: '/img/dashboard_inventory.jpg',
                        title: 'Inventory Management', 
                        description: 'Track delivery orders, stock levels, and wastage in real-time' 
                    },
                    { 
                        src: '/img/dashboard_summary.jpg',
                        title: 'Business Analytics', 
                        description: 'Real-time insights into your business performance' 
                    },
                    { 
                        src: '/img/dashboard_shift.jpg',
                        title: 'Shift Management', 
                        description: 'Easily assign and track shifts' 
                    },
                    { 
                        src: '/img/dashboard_sales.jpg',
                        title: 'Sales Report', 
                        description: 'Track daily sales performance and trends' 
                    },
                    { 
                        src: '/img/dashboard_staff.jpg',
                        title: 'Staff Management', 
                        description: 'Effortlessly manage your team details' 
                    },
                    { 
                        src: '/img/dashboard_payroll.jpg',
                        title: 'Payroll Processing', 
                        description: 'Automated salary calculations' 
                    }
                ]
            }" class="border border-white/20 p-8 rounded-lg">
                <!-- Dashboard Image -->
                <div class="aspect-[16/9] bg-black border border-white/20 mb-4">
                    <img :src="images[currentIndex].src" 
                         :alt="images[currentIndex].title"
                         class="w-full h-full object-cover rounded">
                </div>

                <!-- Caption -->
                <div class="text-center">
                    <h3 class="text-xl font-bold" x-text="images[currentIndex].title"></h3>
                    <p class="text-white/80 mt-2" x-text="images[currentIndex].description"></p>
                </div>

                <!-- Simple Navigation -->
                <div class="flex justify-center gap-2 mt-4">
                    <template x-for="(image, index) in images" :key="index">
                        <button @click="currentIndex = index"
                                :class="{'bg-white': currentIndex === index, 'bg-white/30': currentIndex !== index}"
                                class="w-2 h-2 rounded-full">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center">Key Features</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="border border-white/20 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">Staff Management</h3>
                    <p class="text-white/80">Comprehensive employee profiles and scheduling.</p>
                </div>
                <div class="border border-white/20 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">Payroll Processing</h3>
                    <p class="text-white/80">Automated salary calculations and tracking.</p>
                </div>
                <div class="border border-white/20 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">Analytics Dashboard</h3>
                    <p class="text-white/80">Real-time insights into business performance.</p>
                </div>
                <div class="border border-white/20 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">Inventory Management</h3>
                    <p class="text-white/80">Track stock levels and manage suppliers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 bg-gradient-to-b from-black to-[#1a1a1a]">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">About TallyUp</h2>
            <div class="prose prose-lg mx-auto prose-invert">
                <p class="text-white/80">
                    TallyUp began as a solution to streamline payroll calculations for F&B businesses. Created by Amir Nurhakim, it has evolved into a comprehensive management system that helps businesses automate their operations and make data-driven decisions.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8">
        <div class="max-w-4xl mx-auto px-4 flex justify-between items-center">
            <p class="text-white/80">Created by Amir Nurhakim</p>
            <div class="flex space-x-4">
                <a href="https://www.linkedin.com/in/mrnrhkm/" class="text-white/80 hover:text-white">LinkedIn</a>
                <a href="https://github.com/amirrhkm" class="text-white/80 hover:text-white">GitHub</a>
            </div>
        </div>
    </footer>
</body>
</html>
