<x-layout>
    <x-slot:heading>Add Staff for {{ Carbon\Carbon::parse($date)->format('d F Y') }}</x-slot:heading>

    <div class="flex space-x-6">
        <div class="bg-white bg-opacity-30 p-6 rounded-lg shadow flex-grow">
            <form action="{{ route('shift.store') }}" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="mb-4">
                    <label for="staff_id" class="block text-sm font-medium text-white">Staff</label>
                    <select name="staff_id" id="staff_id" class="p-2 mt-1 block w-full">
                        @foreach ($staff as $member)
                            @if ($member->name !== "admin")
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-white">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-sm font-medium text-white">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label for="break_duration" class="block text-sm font-medium text-white">Break Duration (hours)</label>
                    <input type="number" step="0.5" name="break_duration" id="break_duration" class="p-2 mt-1 block w-full" value="0">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Shift</button>
                </div>
            </form>
        </div>

        <div class="bg-white bg-opacity-30 p-6 rounded-lg shadow w-64">
            <h3 class="text-sm font-medium text-white mb-2">Shortcut Buttons:</h3>
            <div class="space-y-2">
                <button type="button" class="bg-green-500 text-white px-3 py-1 rounded w-full" onclick="setShift('07:30', '16:00', 1)">7:30 AM - 4:00 PM (Opening)</button>
                <button type="button" class="bg-gradient-to-r from-green-500 to-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('10:30', '23:00', 1.5)">10:30 AM - 11:00 PM (Middle)</button>
                <button type="button" class="bg-orange-500 text-white px-3 py-1 rounded w-full" onclick="setShift('14:30', '23:00', 1)">2:30 PM - 11:00 PM (Closing)</button>
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