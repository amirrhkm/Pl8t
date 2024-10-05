<x-layout>
    <x-slot:heading>Staff List</x-slot:heading>
    
    <div class="space-y-4">
        @foreach ($staffs as $staff)
            <a href="/staff/{{ $staff->id }}" class="block px-4 py-6 border border-gray-200 rounded-lg">
                <div class="font-bold text-blue-500">{{ $staff->name }}</div>
                <strong> {{ $staff->nickname }}: </strong>
            </a>
        @endforeach
    </div>
</x-layout>