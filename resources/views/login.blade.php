<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TallyUp</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(to top, #000000, #1a1a1a);
                background-attachment: fixed;
            }
        </style>
    </head>

    <body class="h-full flex items-center justify-center">
        <!-- Mobile Warning -->
        <!-- <div class="md:hidden fixed inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl p-6 shadow-2xl w-[340px] max-h-[600px] overflow-hidden">
                <!-- Header Section
                <div class="text-center">
                    <div class="mb-4">
                        <svg class="w-12 h-12 mx-auto text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Desktop Experience Recommended</h2>
                    <p class="text-gray-600 text-sm mb-4">TallyUp works best on larger screens. For the optimal experience, please access via desktop or laptop.</p>
                </div>

                <!-- Features Section
                <div class="bg-indigo-50 rounded-xl p-4 mb-4">
                    <h3 class="font-semibold text-indigo-800 mb-2 text-xs">Why Desktop?</h3>
                    <ul class="text-xs text-indigo-700 space-y-1.5">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Full access to comprehensive dashboard views</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Enhanced staff management capabilities</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Efficient shift management and assignment</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Efficient stock delivery invoice tracking</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Optimised payroll processing</span>
                        </li>
                    </ul>
                </div>

                <!-- Coming Soon Badge
                <div class="text-center mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mobile optimization coming soon!
                    </span>
                </div>

                <!-- Social Links Section
                <div class="pt-2 border-t border-gray-200">
                    <p class="text-xs text-gray-600 mb-2 text-center"></p>
                    <div class="flex justify-center space-x-5">
                        <a href="https://www.linkedin.com/in/mrnrhkm/" target="_blank" 
                           class="text-gray-600 hover:text-indigo-600 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="https://github.com/amirrhkm" target="_blank" 
                           class="text-gray-600 hover:text-indigo-600 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="mailto:amirhakimoffical@gmail.com" 
                           class="text-gray-600 hover:text-indigo-600 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </a>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 text-center">Crafted by Amir Nurhakim</p>
                </div>
            </div>
        </div> -->

        <div class="container mx-auto px-4 py-8">
            @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-md w-full md:w-1/2 mx-auto">
                <p class="font-bold">Warning</p>
                <p>{{ session('warning') }}</p>
            </div>
            @endif
            <div class="rounded-lg shadow-xl overflow-hidden max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row">
                    <!-- Login Form -->
                    <div class="w-full md:w-1/2 p-6 md:p-8 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg flex flex-col justify-center">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 md:mb-6 text-center">Sign in</h2>
                        <p class="text-sm text-white mb-4 md:mb-6 text-center">Enter your username and password to continue.</p>
                        <form action="{{ route('login') }}" method="POST" class="space-y-4 md:space-y-6 max-w-sm mx-auto">
                            @csrf
                            <div>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <input id="name" name="name" type="text" placeholder="Username" class="pl-10 mt-1 block w-full px-3 py-3 md:py-2 bg-white bg-opacity-80 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base md:text-sm">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <input id="password" name="password" type="password" placeholder="Password" class="pl-10 mt-1 block w-full px-3 py-3 md:py-2 bg-white bg-opacity-80 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base md:text-sm">
                                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-700 text-sm">
                                        Show
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="pt-3 md:pt-5 flex justify-center">
                                <button type="submit" class="w-full flex justify-center items-center py-3 md:py-2 px-4 border border-transparent rounded-full shadow-sm text-base md:text-sm font-medium text-white bg-black hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Information Panel - Hidden on mobile, visible on desktop -->
                    <div class="hidden md:block w-full md:w-1/2 bg-green-600 p-8 text-white">
                        <h2 class="text-3xl font-bold mb-6">Welcome to Pl8t</h2>
                        <p class="mb-4">Your all-in-one solution for streamlining staff management, payroll processing, sales metrics, and more.</p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-sm">Automated payroll calculations based on individual staff rates and employment types</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-sm">Employee dashboard featuring monthly hour contributions, payroll analytics, and current week's shift assignments</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-sm">Powerful tools for efficient shift management and assignment, directly linked to payroll calculations</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-sm">Efficiently track stock delivery invoices and total sales, with analytical insights for better business understanding</span>
                            </li>
                        </ul>
                        <p class="mt-6">Got a problem managing your staff? Time to <strong>Pl8t</strong> and simplify your workflow!</p>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Footer -->
            <footer class="mt-6 md:mt-8 text-center text-white">
                <div class="flex justify-center space-x-6">
                    <a href="https://www.linkedin.com/in/mrnrhkm/" target="_blank" class="hover:text-gray-300 transition duration-150 ease-in-out">
                        <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="https://github.com/amirrhkm" target="_blank" class="hover:text-gray-300 transition duration-150 ease-in-out">
                        <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="mailto:amirhakimoffical@gmail.com" class="hover:text-gray-300 transition duration-150 ease-in-out">
                        <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </a>
                </div>
                <p class="mt-2 text-sm md:text-xs">Crafted by Amir Nurhakim</p>
            </footer>
        </div>

        <script>
            function togglePasswordVisibility(id) {
                const input = document.getElementById(id);
                const button = input.nextElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    button.textContent = "Hide";
                } else {
                    input.type = "password";
                    button.textContent = "Show";
                }
            }
        </script>
    </body>
</html>