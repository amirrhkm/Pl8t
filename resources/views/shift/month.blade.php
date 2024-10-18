<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>{{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</x-slot:description>

    <div class="flex justify-center">
        <div class="w-3/4 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>   
                        <th class="py-2 px-4 border-b text-left">Date</th>
                        <th class="py-2 px-4 border-b text-left text-center">Opening</th>
                        <th class="py-2 px-4 border-b text-left text-center">Closing</th>
                        <th class="py-2 px-4 border-b text-left text-center">OT</th>
                        <th class="py-2 px-4 border-b text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $date => $dayShifts)
                        <tr>
                            <td class="py-2 px-4 border-b align-top">{{ Carbon\Carbon::parse($date)->format('d') }}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex flex-wrap gap-1 justify-center">
                                    @foreach ($dayShifts as $shift)
                                        @if ($shift->staff && $shift->staff->name !== "admin" && Carbon\Carbon::parse($shift->start_time)->format('H:i') < '12:00')
                                            <span class="bg-green-100 px-2 py-1 rounded text-sm">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex flex-wrap gap-1 justify-center">
                                    @if (count($dayShifts) == 1 && $dayShifts->first()->staff->name === "admin")
                                        <span class="bg-white px-2 py-1 rounded text-sm text-gray-500 italic">
                                            No shifts assigned for this day.
                                        </span>
                                    @endif
                                    @foreach ($dayShifts as $shift)
                                        @if ($shift->staff && $shift->staff->name !== "admin" && Carbon\Carbon::parse($shift->end_time)->format('H:i') == '23:00')
                                            <span class="bg-orange-100 px-2 py-1 rounded text-sm">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex flex-wrap gap-1 justify-center">
                                    @foreach ($dayShifts as $shift)
                                        @php
                                            $hours = Carbon\Carbon::parse($shift->start_time)->diffInHours(Carbon\Carbon::parse($shift->end_time)) - $shift->break_duration;
                                        @endphp
                                        @if ($shift->staff && $shift->staff->name !== "admin" && $hours > 8)
                                            <span class="bg-red-100 px-2 py-1 rounded text-sm">
                                                {{ $shift->staff->nickname }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-2 px-4 border-b text-right">
                                <a href="{{ route('shift.details', ['date' => $date]) }}" class="text-blue-500 hover:underline inline-block">
                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>