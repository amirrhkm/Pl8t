<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tally Up</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-image: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2029&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
        </style>
    </head>

    <body class="h-full">
        <header class="bg-transparent">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold text-white drop-shadow-lg">{{ $staff->name }}</h1>
                    <a href="{{ route('crew.dashboard', ['staff' => $staff->name]) }}" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </div>
                <p class="text-xl text-white text-center mt-2 drop-shadow-md">Shift Summary</p>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $years = [2024, 2025];
                        $months = collect($years)->flatMap(function($year) {
                            return collect(range(1, 12))->map(function($month) use ($year) {
                                return \Carbon\Carbon::create($year, $month, 1);
                            });
                        });
                        $previousYear = null;
                    @endphp

                    @foreach ($months as $date)
                    @if ($previousYear !== null && $previousYear !== $date->year)
                        <div class="col-span-full h-8"></div>
                    @endif
                    @php $previousYear = $date->year; @endphp

                    @php
                        $yearMonth = $date->format('Y-m');
                        $data = $monthlyData[$yearMonth] ?? null;
                        $totalHours = $data ? ($data['reg_hours'] + $data['reg_ot_hours'] + $data['ph_hours'] + $data['ph_ot_hours']) : 0;
                        $totalSalary = $data ? ($data['reg_pay'] + $data['reg_ot_pay'] + $data['ph_pay'] + $data['ph_ot_pay']) : 0;
                        $isClickable = $totalHours > 0 || $totalSalary > 0;
                    @endphp
                        <a href="{{ $isClickable ? route('crew.details', ['staff' => $staff->id, 'year' => $date->year, 'month' => $date->month]) : '#' }}" 
                        class="block p-6 rounded-xl border shadow-lg transition duration-300 ease-in-out {{ $isClickable 
                            ? 'bg-gradient-to-br from-white to-gray-100 border-gray-200 hover:shadow-xl hover:-translate-y-1 transform' 
                            : 'bg-gray-200 border-gray-300 cursor-not-allowed' }}">
                            <div class="text-center">
                                <h5 class="mb-3 text-2xl font-bold tracking-tight {{ $isClickable ? 'text-gray-900' : 'text-gray-500' }}">{{ $date->format('F Y') }}</h5>
                                <div class="space-y-2">
                                    <p class="font-medium {{ $isClickable ? 'text-gray-700' : 'text-gray-500' }}">
                                        <span class="block text-sm {{ $isClickable ? 'text-gray-500' : 'text-gray-400' }}">Total Hours</span>
                                        <span class="text-xl {{ $isClickable ? 'text-blue-600' : 'text-gray-600' }}">{{ number_format($totalHours, 1) }}</span>
                                    </p>
                                    <p class="font-medium {{ $isClickable ? 'text-gray-700' : 'text-gray-500' }}">
                                        <span class="block text-sm {{ $isClickable ? 'text-gray-500' : 'text-gray-400' }}">Salary</span>
                                        <span class="text-xl {{ $isClickable ? 'text-green-600' : 'text-gray-600' }}">RM {{ number_format($totalSalary, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </main>

        <footer class="bg-transparent py-4">
            <div class="container mx-auto px-4 flex justify-center items-center space-x-4">
                <a href="https://www.linkedin.com/in/mrnrhkm/" target="_blank" class="text-white hover:text-gray-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                <div class="text-white text-sm">
                    Crafted by Amir Nurhakim
                </div>
                <a href="https://github.com/amirrhkm" target="_blank" class="text-white hover:text-gray-300">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                </a>
            </div>
        </footer>
    </body>
</html>