<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>This Week's Shifts</x-slot:description>

    <div class="flex justify-center">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 rounded-xl shadow-lg w-1/2">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-indigo-800 mb-2 sm:mb-0">This Week's Shifts</h2>
                <p class="text-sm font-semibold text-indigo-600 bg-white px-3 py-1 rounded-full shadow-sm">
                    {{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M Y') }}
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-indigo-600 text-white">
                                <th class="py-2 px-3 text-left">Day</th>
                                <th class="py-2 px-3 text-left">Date</th>
                                <th class="py-2 px-3 text-left">Shifts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentWeek = now()->startOfWeek();
                            @endphp
                            @foreach(range(0, 6) as $dayOffset)
                                @php
                                    $currentDay = $currentWeek->copy()->addDays($dayOffset);
                                    $dateKey = $currentDay->format('Y-m-d');
                                    $isToday = $currentDay->isToday();
                                @endphp
                                <tr class="hover:bg-indigo-50 transition-colors {{ $isToday ? 'bg-indigo-100' : ($loop->even ? 'bg-gray-50' : '') }} cursor-pointer"
                                    onclick="window.location.href='{{ route('shift.details', ['date' => $dateKey]) }}'">
                                    <td class="py-2 px-3 font-semibold {{ $isToday ? 'text-indigo-700' : 'text-gray-800' }}">
                                        {{ $currentDay->format('D') }}
                                    </td>
                                    <td class="py-2 px-3 {{ $isToday ? 'text-indigo-700' : 'text-gray-600' }}">
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
                                                            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-1.5"></span>
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
</x-layout>