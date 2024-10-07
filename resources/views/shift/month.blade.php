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
                        <td class="py-2 px-4 border-b align-top">{{ Carbon\Carbon::parse($date)->format('Y-m-d') }}</td>
                        <td class="py-2 px-4 border-b">
                            @foreach ($dayShifts as $shift)
                                <div class="mb-2">
                                    @if ($shift->staff)
                                        <strong>{{ $shift->staff->name }} ({{ $shift->staff->nickname }}):</strong>
                                    @else
                                        <strong>Unknown Staff:</strong>
                                    @endif
                                    {{ Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - 
                                    {{ Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
