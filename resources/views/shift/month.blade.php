<x-layout>
    <x-slot:heading>Shifts for {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</x-slot:heading>

    <div class="flex justify-center">
        <div class="w-3/4 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>   
                        <th class="py-2 px-4 border-b text-left">Date</th>
                        <th class="py-2 px-4 border-b text-left">Opening</th>
                        <th class="py-2 px-4 border-b text-left">Closing</th>
                        <th class="py-2 px-4 border-b text-left">OT</th>
                        <th class="py-2 px-4 border-b text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $date => $dayShifts)
                        <tr>
                            <td class="py-2 px-4 border-b align-top">{{ Carbon\Carbon::parse($date)->format('d') }}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex flex-wrap gap-1">
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
                                <div class="flex flex-wrap gap-1">
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
                                <div class="flex flex-wrap gap-1">
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
                                <a href="{{ route('shift.details', ['date' => $date]) }}" class="text-blue-500 hover:underline">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>