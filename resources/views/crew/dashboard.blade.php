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
                background: linear-gradient(to top, #000000, #1a1a1a);
                background-attachment: fixed;
            }
        </style>
    </head>

    <body class="h-full">
        <header class="bg-transparent">
            <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                <h1 class="text-2xl sm:text-4xl font-bold text-white text-center drop-shadow-lg pt-5 sm:pt-10">Welcome back, {{ $staff->nickname }}!</h1>
                <p class="text-lg sm:text-xl text-white text-center mt-2 drop-shadow-md">Here's your progression so far.</p>
            </div>
        </header>
        
        <main>
            <div class="mx-auto max-w-7xl px-2 sm:px-4 py-3 sm:py-6">
                <div class="min-h-full pb-5 sm:pb-10">
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-4 sm:p-8 rounded-xl shadow-lg">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 space-y-2 sm:space-y-0">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $staff->nickname }}'s Dashboard</h2>
                            <div class="flex items-center space-x-6">
                                <a href="{{ route('crew.overview', ['staff' => $staff->id]) }}" class="text-gray-800 hover:text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('account.settings') }}" class="text-gray-800 hover:text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="inline-flex items-center">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
        
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-10">
                            <div class="bg-white p-3 sm:p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                                <h3 class="text-sm sm:text-lg font-semibold mb-1 sm:mb-2 text-gray-800">Regular Hours</h3>
                                <p class="text-3xl sm:text-5xl font-bold text-gray-800">{{ number_format($month_reg_hours, 2) }}</p>
                                <p class="text-lg sm:text-2xl font-semibold text-green-600 mt-1 sm:mt-2">+{{ number_format($month_reg_ot_hours, 2) }} OT</p>
                            </div>
                            <div class="bg-white p-3 sm:p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                                <h3 class="text-sm sm:text-lg font-semibold mb-1 sm:mb-2 text-gray-800">PH Hours</h3>
                                <p class="text-3xl sm:text-5xl font-bold text-gray-800">{{ number_format($month_ph_hours, 2) }}</p>
                                <p class="text-lg sm:text-2xl font-semibold text-green-600 mt-1 sm:mt-2">+{{ number_format($month_ph_ot_hours, 2) }} OT</p>
                            </div>
                            <div class="bg-white p-3 sm:p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                                <h3 class="text-sm sm:text-lg font-semibold mb-1 sm:mb-2 text-gray-800 text-center">{{ now()->format('M') }} Total</h3>
                                <p class="text-2xl sm:text-4xl font-bold text-gray-800">RM {{ number_format($this_month_salary, 2) }}</p>
                                <p class="text-base sm:text-xl font-semibold {{ $percentage_diff_last_month >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1 sm:mt-2">
                                    {{ $percentage_diff_last_month >= 0 ? '+' : '' }}{{ number_format($percentage_diff_last_month, 2) }}%
                                </p>
                            </div>
                            <div class="bg-white p-3 sm:p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                                <h3 class="text-sm sm:text-lg font-semibold mb-1 sm:mb-2 text-gray-800">Previous</h3>
                                <div class="text-center space-y-1">
                                    <div class="text-center">
                                        <p class="text-xs sm:text-md font-semibold text-gray-700">{{ $lastMonthName }}: RM {{ number_format($last_month_salary, 2) }}</p>
                                        <p class="text-xs sm:text-sm {{ $percentage_diff_last_month >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $percentage_diff_last_month >= 0 ? '+' : '' }}{{ number_format($percentage_diff_last_month, 2) }}%
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs sm:text-md font-semibold text-gray-700">{{ $twoMonthsAgoName }}: RM {{ number_format($two_months_ago_salary, 2) }}</p>
                                        <p class="text-xs sm:text-sm {{ $percentage_diff_two_months_ago >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $percentage_diff_two_months_ago >= 0 ? '+' : '' }}{{ number_format($percentage_diff_two_months_ago, 2) }}%
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs sm:text-md font-semibold text-gray-700">{{ $threeMonthsAgoName }}: RM {{ number_format($three_months_ago_salary, 2) }}</p>
                                        <p class="text-xs sm:text-sm {{ $percentage_diff_three_months_ago >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $percentage_diff_three_months_ago >= 0 ? '+' : '' }}{{ number_format($percentage_diff_three_months_ago, 2) }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-3 sm:p-6 rounded-lg shadow-md mb-2">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 space-y-2 sm:space-y-0">
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-800">This Week's Timetable</h3>
                                <p class="text-xs sm:text-sm font-semibold text-gray-800 px-2 sm:px-3 py-1 rounded-full shadow-sm bg-gray-50">
                                    {{ Carbon\Carbon::parse($date)->startOfWeek()->format('d M') }} - {{ Carbon\Carbon::parse($date)->endOfWeek()->format('d M Y') }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-800 text-white">
                                                <th class="py-2 px-3 text-left">Day</th>
                                                <th class="py-2 px-3 text-left">Date</th>
                                                <th class="py-2 px-3 text-left">Shifts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $startOfWeek = now()->startOfWeek();
                                                $endOfWeek = now()->endOfWeek();
                                            @endphp
                                            @foreach(range(0, 6) as $dayOffset)
                                                @php
                                                    $currentDay = $startOfWeek->copy()->addDays($dayOffset);
                                                    $dateKey = $currentDay->format('Y-m-d');
                                                    $isToday = $currentDay->isToday();
                                                    $shifts = $weeklyShifts[$dateKey] ?? collect();
                                                @endphp
                                                <tr class="hover:bg-green-10 transition-colors {{ $isToday ? 'bg-green-100' : ($loop->even ? 'bg-gray-50' : '') }}">
                                                    <td class="py-2 px-3 font-semibold {{ $isToday ? 'text-green-700' : 'text-gray-800' }}">
                                                        {{ $currentDay->format('D') }}
                                                    </td>
                                                    <td class="py-2 px-3 {{ $isToday ? 'text-green-700' : 'text-gray-600' }}">
                                                        {{ $currentDay->format('d M') }}
                                                    </td>
                                                    <td class="py-2 px-3">
                                                        @if($shifts->isNotEmpty())
                                                            @php
                                                                $sortedShifts = $shifts->sortBy(function ($shift) {
                                                                    $startTime = $shift->start_time->format('H:i');
                                                                    $endTime = $shift->end_time->format('H:i');
                                                                    if ($startTime == '07:30' && $endTime == '23:00') return 1;
                                                                    if ($startTime == '07:30') return 2;
                                                                    if ($startTime == '10:30') return 3;
                                                                    if ($startTime == '14:30') return 4;
                                                                    if ($startTime == '17:00') return 5;
                                                                    if ($startTime == '18:00') return 6;
                                                                    return 7;
                                                                });
                                                            @endphp
                                                            <ul class="space-y-1">
                                                                @foreach($sortedShifts as $shift)
                                                                    @php
                                                                        $startTime = $shift->start_time->format('H:i');
                                                                        $endTime = $shift->end_time->format('H:i');
                                                                        $bgColor = 'bg-indigo-100';
                                                                        $textColor = 'text-indigo-800';

                                                                        if ($startTime == '07:30' && $endTime == '23:00') {
                                                                            $bgColor = 'bg-red-100';
                                                                            $textColor = 'text-red-800';
                                                                        } elseif ($startTime == '10:30') {
                                                                            $bgColor = 'bg-yellow-100';
                                                                            $textColor = 'text-yellow-800';
                                                                        } elseif ($startTime == '07:30') {
                                                                            $bgColor = 'bg-green-100';
                                                                            $textColor = 'text-green-800';
                                                                        } elseif ($endTime == '23:00') {
                                                                            $bgColor = 'bg-orange-100';
                                                                            $textColor = 'text-orange-800';
                                                                        }
                                                                    @endphp
                                                                    <li class="flex items-center justify-between">
                                                                        <span class="text-gray-800 flex items-center">
                                                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                                            {{ $shift->staff->nickname }}
                                                                        </span>
                                                                        <span class="ml-2 text-md {{ $bgColor }} {{ $textColor }} px-1.5 py-0.5 rounded-full">
                                                                            {{ $startTime }}-{{ $endTime }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span class="text-gray-500 italic text-xs">No Shifts</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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