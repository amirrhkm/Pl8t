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

    <body class="h-full">
        <header class="bg-transparent">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl sm:text-4xl font-bold text-white drop-shadow-lg">{{ $staff->name }}</h1>
                    <a href="{{ route('crew.dashboard', ['staff' => $staff->name]) }}" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                    </a>
                </div>
                <p class="text-lg sm:text-xl text-white text-center mt-2 drop-shadow-md">{{ $date->format('F') }} Shift Details</p>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-2 sm:px-6 py-4 sm:py-6 lg:px-8">
            <div class="overflow-x-auto mb-6 sm:mb-8 rounded-lg shadow">
                <table class="min-w-full bg-white text-sm sm:text-base">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">Date</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">Start</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">End</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">Reg Hrs</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">OT Hrs</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">PH Hrs</th>
                            <th class="py-2 px-2 sm:px-4 border-b text-center">PH OT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthShifts as $shift)
                            @php
                                $total_hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
                                
                                // Manual Ingestion for Supervisor (Saturday)
                                if((int)$shift->staff_id === 7 && $shift->date->isSaturday()){
                                    $otHours = max(0, $total_hours - 4);
                                    $hours = $total_hours - $otHours;
                                }else{
                                    $otHours = max(0, $total_hours - 8);
                                    $hours = $total_hours - $otHours;
                                }

                                $reg_hours = 0.0;
                                $reg_ot_hours = 0.0;
                                $ph_hours = 0.0;
                                $ph_ot_hours = 0.0;

                                if ($shift->is_public_holiday) {
                                    $ph_hours = $hours;
                                    $ph_ot_hours = $otHours;
                                } else {
                                    $reg_hours = $hours;
                                    $reg_ot_hours = $otHours;
                                }
                            @endphp
                            <tr>
                                <td class="py-2 px-4 border-b text-center">{{ Carbon\Carbon::parse($shift->date)->format('d/m') }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $shift->start_time->format('H:i') }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $shift->end_time->format('H:i') }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $reg_hours }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $reg_ot_hours }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $ph_hours }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $ph_ot_hours }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="3" class="py-2 px-4 border-b font-bold text-right">Total Hours:</td>
                            <td class="py-2 px-4 border-b font-bold text-center">{{ $month_reg_hours }}</td>
                            <td class="py-2 px-4 border-b font-bold text-center">{{ $month_reg_ot_hours }}</td>
                            <td class="py-2 px-4 border-b font-bold text-center">{{ $month_ph_hours }}</td>
                            <td class="py-2 px-4 border-b font-bold text-center">{{ $month_ph_ot_hours }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 sm:mt-8 bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-xl sm:text-2xl font-bold mb-4">Payroll Details</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Employee Name:</strong> {{ $staff->name }}</p>
                        <p><strong>Month:</strong> {{ $monthShifts->first()->date->format('F Y') }}</p>
                        @if($staff->employment_type === 'part_time')
                            <p><strong>Rate:</strong> RM {{ $staff->rate }}</p>
                        @endif
                    </div>
                    <div>
                        <p><strong>Regular Hours:</strong> {{ $month_reg_hours }}</p>
                        <p><strong>Overtime Hours:</strong> {{ $month_reg_ot_hours }}</p>
                        <p><strong>Public Holiday Hours:</strong> {{ $month_ph_hours }}</p>
                        <p><strong>Public Holiday Overtime Hours:</strong> {{ $month_ph_ot_hours }}</p>
                    </div>
                </div>
                <table class="w-full mt-4 text-sm sm:text-base">
                    <thead>
                        <tr>
                            <th class="text-left">Earnings</th>
                            <th class="text-right">Amount (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($staff->employment_type === 'part_time')
                            <tr>
                                <td>Regular Pay</td>
                                <td class="text-right">{{ number_format($reg_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Regular Overtime Pay</td>
                                <td class="text-right">{{ number_format($reg_ot_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Public Holiday Pay</td>
                                <td class="text-right">{{ number_format($ph_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Public Holiday Overtime Pay</td>
                                <td class="text-right">{{ number_format($ph_ot_pay, 2) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Regular Overtime Pay</td>
                                <td class="text-right">{{ number_format($reg_ot_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Public Holiday Overtime Pay</td>
                                <td class="text-right">{{ number_format($ph_ot_pay, 2) }}</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td>{{ $staff->employment_type === 'part_time' ? 'Total Salary' : 'Total Overtime Pay' }}</td>
                            <td class="text-right">{{ number_format($total_salary, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </body>

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
</html>