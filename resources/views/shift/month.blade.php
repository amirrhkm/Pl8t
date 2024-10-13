<x-layout>
    <x-slot:heading>Shifts for {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</x-slot:heading>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Staff Working Hours</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
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
                                            <a href="{{ route('shift.edit', $shift->id) }}" class="text-blue-500 hover:underline ml-2">Edit</a>
                                            <form action="{{ route('shift.destroy', $shift->id) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this shift?')">Delete</button>
                                            </form>
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
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('shift.create', ['date' => $date]) }}" class="text-blue-500 hover:underline">Add Staff</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>