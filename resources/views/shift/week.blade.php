<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>This Week's Shifts</x-slot:description>

    <div class="flex justify-center">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 rounded-xl shadow-lg w-1/2">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2 sm:mb-0">This Week's Shifts</h2>
                <p class="text-sm font-semibold text-gray-800 bg-white px-3 py-1 rounded-full shadow-sm">
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
                                $startOfWeek = Carbon\Carbon::parse($date)->startOfWeek();
                                $endOfWeek = Carbon\Carbon::parse($date)->endOfWeek();
                            @endphp
                            @foreach(range(0, 6) as $dayOffset)
                                @php
                                    $currentDay = $startOfWeek->copy()->addDays($dayOffset);
                                    $dateKey = $currentDay->format('Y-m-d');
                                    $isToday = $currentDay->isToday();
                                @endphp
                                <tr class="hover:bg-green-100 transition-colors {{ $isToday ? 'bg-green-50' : ($loop->even ? 'bg-gray-50' : '') }} cursor-pointer"
                                    onclick="window.location.href='{{ route('shift.details', ['date' => $dateKey]) }}'">
                                    <td class="py-2 px-3 font-semibold {{ $isToday ? 'text-green-600' : 'text-gray-800' }}">
                                        {{ $currentDay->format('D') }}
                                    </td>
                                    <td class="py-2 px-3 {{ $isToday ? 'text-green-600' : 'text-gray-600' }}">
                                        {{ $currentDay->format('d M') }}
                                    </td>
                                    <td class="py-2 px-3">
                                        @if(isset($weeklyShifts[$dateKey]) && $weeklyShifts[$dateKey]->isNotEmpty())
                                            @php
                                                $sortedShifts = $weeklyShifts[$dateKey]->sortBy(function ($shift) {
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
                                                            {{ $shift->staff->name }}
                                                        </span>
                                                        <span class="ml-2 text-xs {{ $bgColor }} {{ $textColor }} px-1.5 py-0.5 rounded-full">
                                                            {{ $startTime }}-{{ $endTime }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-500 italic text-xs">No shifts</span>
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
    <div class="mt-4 flex justify-center">
        <form action="{{ route('shift.clear-week') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all shifts for this week');">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full shadow-sm transition duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </form>
    </div>
</x-layout>