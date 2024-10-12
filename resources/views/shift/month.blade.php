<x-layout>
    <x-slot:heading>Shifts for {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</x-slot:heading>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Staff Working Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shifts as $date => $dayShifts)
                    <tr>
                        <td class="py-2 px-4 border-b align-top">{{ Carbon\Carbon::parse($date)->format('d') }}</td>
                        <td class="py-2 px-4 border-b">
                            @if (count($dayShifts) === 1 && $dayShifts[0]->staff->name === "admin")
                                <div class="mb-2">
                                    No Staff Assigned
                                </div>
                            @else
                                @foreach ($dayShifts as $shift)
                                    @if ($shift->staff && $shift->staff->name !== "admin")
                                        <div class="mb-2">
                                            <strong>{{ $shift->staff->nickname }}:</strong>
                                            {{ Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - 
                                            {{ Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                        </div>
                                    @elseif (!$shift->staff)
                                        <div class="mb-2">
                                            <strong>Unknown Staff:</strong>
                                            {{ Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - 
                                            {{ Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
