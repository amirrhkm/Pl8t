<x-layout>
    <x-slot:heading>Shifts for {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</x-slot:heading>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Staff Working Hours</th>
                    <th class="py-2 px-4 border-b text-left">Public Holiday</th>
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
                            <form action="{{ route('shift.togglePublicHoliday') }}" method="POST">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">
                                <label class="switch">
                                    <input type="checkbox" name="is_public_holiday" onchange="this.form.submit()" 
                                        {{ $dayShifts->first()->is_public_holiday ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </form>
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

<style>
    /* CSS for the toggle switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>