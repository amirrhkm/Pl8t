<x-layout>
    <x-slot:heading>Edit Shift for {{ Carbon\Carbon::parse($shift->date)->format('d F Y') }}</x-slot:heading>

    <form action="{{ route('shift.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="date" value="{{ $shift->date }}">
        <input type="hidden" name="staff_id" value="{{ $shift->staff_id }}">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Staff</label>
            <p class="mt-1 p-2 block w-1/2 bg-gray-100 rounded">{{ $shift->staff->name }}</p>
        </div>

        <div class="mb-4">
            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="mt-1 block w-1/2" value="{{ $shift->start_time->format('H:i') }}">
        </div>

        <div class="mb-4">
            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="time" name="end_time" id="end_time" class="mt-1 block w-1/2" value="{{ $shift->end_time->format('H:i') }}">
        </div>

        <div class="mb-4">
            <label for="break_duration" class="block text-sm font-medium text-gray-700">Break Duration (hours)</label>
            <input type="number" step="0.5" name="break_duration" id="break_duration" class="p-2 mt-1 block w-1/2" value="{{ $shift->break_duration }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update Shift</button>
    </form>
</x-layout>