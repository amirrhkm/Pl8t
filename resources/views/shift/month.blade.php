<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>
        <span class="text-xl font-medium text-white-700">
            {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
        </span>
    </x-slot:description>

    <div class="flex justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl overflow-hidden rounded-xl shadow-lg bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>   
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Opening</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Closing</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">OT</th>
                        <th class="py-3 px-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($shifts as $date => $dayShifts)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 
                                   {{ $dayShifts->contains(fn($shift) => $shift->isPublicHoliday()) 
                                      ? 'bg-amber-50' 
                                      : '' }}">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-lg font-semibold text-gray-700">
                                        {{ Carbon\Carbon::parse($date)->format('d') }}
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-gray-900">
                                        {{ Carbon\Carbon::parse($date)->format('D') }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    @foreach ($dayShifts as $shift)
                                        @if ($shift->staff && $shift->staff->name !== "admin" && Carbon\Carbon::parse($shift->start_time)->format('H:i') < '12:00')
                                            <span class="bg-green-100 px-3 py-1.5 rounded-full text-sm font-medium text-green-800 cursor-help transition-all hover:bg-green-200"
                                                  title="{{ Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($shift->end_time)->format('H:i') }}">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    @if (count($dayShifts) == 1 && $dayShifts->first()->staff->name === "admin")
                                        <span class="text-sm text-gray-500 italic">
                                            No shifts assigned
                                        </span>
                                    @endif
                                    @foreach ($dayShifts as $shift)
                                        @if ($shift->staff && $shift->staff->name !== "admin" && Carbon\Carbon::parse($shift->end_time)->format('H:i') == '23:00')
                                            <span class="bg-orange-100 px-3 py-1.5 rounded-full text-sm font-medium text-orange-800 cursor-help transition-all hover:bg-orange-200"
                                                  title="{{ Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($shift->end_time)->format('H:i') }}">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    @foreach ($dayShifts as $shift)
                                        @php
                                            $hours = Carbon\Carbon::parse($shift->start_time)->diffInHours(Carbon\Carbon::parse($shift->end_time)) - $shift->break_duration;
                                        @endphp
                                        @if ($shift->staff && $shift->staff->name !== "admin" && $hours > 8)
                                            <span class="bg-red-100 px-3 py-1.5 rounded-full text-sm font-medium text-red-800 cursor-help transition-all hover:bg-red-200"
                                                  title="{{ $hours }} hours (including {{ $shift->break_duration }}h break)">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('shift.details', ['date' => $date]) }}" 
                                   class="text-gray-800 hover:text-green-600 inline-flex items-center gap-1 transition-colors duration-200">
                                    <span class="text-sm font-medium">Edit</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center">
        <form action="{{ route('shift.clear-month') }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to clear all shifts for this month? This action cannot be undone.');">
            @csrf
            <button type="submit" 
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Clear Month</span>
            </button>
        </form>
    </div>
</x-layout>