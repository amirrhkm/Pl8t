<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    <x-slot:description>Add member to {{ Carbon\Carbon::parse($date)->format('d F Y') }} shift</x-slot:description>

    <div class="flex space-x-6 justify-center">
        <div class="bg-white bg-opacity-30 p-6 rounded-lg shadow w-1/3">
            <form action="{{ route('shift.store') }}" method="POST" class="flex flex-col h-full">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="mb-4">
                    <label for="staff_id" class="block text-sm font-medium text-white">Staff</label>
                    <select name="staff_id" id="staff_id" class="p-2 mt-1 block w-full">
                        @php $availableStaff = 0; @endphp
                        @foreach ($staff as $member)
                            @if ($member->name !== "admin" && !$member->shifts->contains(function($shift) use ($date) {
                                return $shift->date->isSameDay(Carbon\Carbon::parse($date));
                            }))
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @php $availableStaff++; @endphp
                            @endif
                        @endforeach
                    </select>
                    @if ($availableStaff === 0)
                        <p class="text-red-500 text-sm mt-2">No staff members available for this shift.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-white">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full">
                    @error('start_time')
                        <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-sm font-medium text-white">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="mt-1 block w-full">
                    @error('end_time')
                        <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="break_duration" class="block text-sm font-medium text-white">Break Duration (hours)</label>
                    <input type="number" step="0.5" name="break_duration" id="break_duration" class="p-2 mt-1 block w-full" value="0">
                </div>

                <input type="hidden" name="is_public_holiday" value="{{ $isPublicHoliday }}">

                <div class="flex-grow"></div>

                <div class="flex justify-end mt-4">
                    <a href="{{ route('shift.details', ['date' => $date]) }}" class="text-white px-4 py-2 rounded transition duration-300 ease-in-out">Cancel</a>
                    <button type="submit" class="bg-gray-800 hover:bg-green-600 shadow text-white px-4 py-2 rounded {{ $availableStaff === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $availableStaff === 0 ? 'disabled' : '' }}>Add Shift</button>
                </div>
            </form>
        </div>

        <div class="bg-white bg-opacity-30 p-6 rounded-lg shadow w-64">
            <h3 class="text-sm font-medium text-white mb-2">Common Shifts:</h3>
            <div class="space-y-2">
                <button type="button" class="bg-green-500 text-white px-3 py-1 rounded w-full" onclick="setShift('07:30', '16:00', 1)">7:30 AM - 4:00 PM (Opening)</button>
                <button type="button" class="bg-gradient-to-r from-green-500 to-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('10:30', '23:00', 1.5)">10:30 AM - 11:00 PM (Middle)</button>
                <button type="button" class="bg-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('14:30', '23:00', 1)">2:30 PM - 11:00 PM (Closing)</button>
                <button type="button" class="bg-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('17:00', '23:00', 0.5)">5:00 PM - 11:00 PM (Closing)</button>
                <button type="button" class="bg-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('18:00', '23:00', 0)">6:00 PM - 11:00 PM (Closing)</button>
                <button type="button" class="bg-red-500 text-white px-3 py-1 rounded w-full" onclick="setShift('07:30', '23:00', 2)">7:30 AM - 11:00 PM (Opening-Closing)</button>
            </div>
        </div>
    </div>

    <script>
        function setShift(startTime, endTime, breakDuration) {
            document.getElementById('start_time').value = startTime;
            document.getElementById('end_time').value = endTime;
            document.getElementById('break_duration').value = breakDuration;
        }
    </script>
</x-layout>