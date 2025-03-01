<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>{{ Carbon\Carbon::parse($date)->format('d F Y') }}</x-slot:description>

    <div class="flex justify-center mb-4">
        <div class="bg-white rounded-lg shadow p-4">
            <form action="{{ route('shift.togglePublicHoliday') }}" method="POST" class="flex items-center">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <label class="mr-2">Public Holiday:</label>
                <label class="switch">
                    <input type="checkbox" name="is_public_holiday" onchange="this.form.submit()" 
                        {{ $isPublicHoliday ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
            </form>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="w-1/2 overflow-x-auto rounded-lg shadow">
            <table class="w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left font-semibold">Staff</th>
                        <th class="py-3 px-4 border-b text-center font-semibold">Shift Hours</th>
                        <th class="py-3 px-4 border-b text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($shifts->count() == 1 && $shifts->first()->staff->name === "admin")
                        <tr>
                            <td colspan="3" class="py-8 text-center">
                                <p class="text-lg font-semibold text-gray-700">No shifts assigned for this day.</p>
                            </td>
                        </tr>
                    @else
                        @php
                            $shifts = $shifts->sortBy(function ($shift) {
                                if ($shift->start_time == '07:30:00' && $shift->end_time == '23:00:00') return 1;
                                if ($shift->start_time == '07:30:00') return 2;
                                if ($shift->start_time == '10:30:00') return 3;
                                if ($shift->end_time == '23:00:00') return 4;
                                return 5;
                            });
                        @endphp
                        @foreach ($shifts as $shift)
                            @if ($shift->staff->name !== "admin")
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $shift->staff->nickname }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @php
                                            $startTime = Carbon\Carbon::parse($shift->start_time)->format('H:i');
                                            $endTime = Carbon\Carbon::parse($shift->end_time)->format('H:i');
                                            $shiftHours = "$startTime - $endTime";
                                            $containerClass = '';
                                            
                                            if ($startTime == '07:30' && $endTime == '23:00') {
                                                $containerClass = 'bg-gradient-to-r from-green-100 to-orange-100';
                                            } elseif ($startTime == '10:30' && $endTime == '23:00') {
                                                $containerClass = 'bg-gradient-to-r from-green-100 to-orange-100';
                                            } elseif ($startTime == '07:30' || $startTime == '10:30') {
                                                $containerClass = 'bg-green-100';
                                            } elseif ($endTime == '23:00') {
                                                $containerClass = 'bg-orange-100';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 rounded inline-block {{ $containerClass }}">
                                            {{ $shiftHours }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('shift.edit', ['shift' => $shift->id, 'redirect' => 'details']) }}" class="text-gray-800 hover:text-green-600 mr-2">Edit</a>
                                        <form action="{{ route('shift.destroy', $shift->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to remove {{ $shift->staff->nickname }} from this shift?')">Remove</button>
                                        </form>
                                        </td>
                                    </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center space-x-4">
        <a href="{{ route('shift.week', ['date' => $date]) }}" class="bg-white bg-opacity-30 p-6 rounded-lg text-white px-6 py-2 rounded-lg hover:bg-green-600 transition duration-300 ease-in-out font-semibold">Back to Week</a>
        <a href="{{ route('shift.month', ['year' => Carbon\Carbon::parse($date)->year, 'month' => Carbon\Carbon::parse($date)->month]) }}" class="bg-white bg-opacity-30 p-6 rounded-lg text-white px-6 py-2 rounded-lg hover:bg-green-600 transition duration-300 ease-in-out font-semibold">Back to Month</a>
        <a href="{{ route('shift.create', ['date' => $date, 'is_public_holiday' => $isPublicHoliday]) }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-800 transition duration-300 ease-in-out font-semibold">Add Staff</a>
    </div>
</x-layout>

<style>
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