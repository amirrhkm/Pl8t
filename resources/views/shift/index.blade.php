<x-layout>
    <x-slot:heading>Shift Overview</x-slot:heading>
    
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">2024 Monthly Shifts</h2>
        <div class="grid grid-cols-4 gap-4">
            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                <a href="{{ route('shift.month', ['year' => 2024, 'month' => $index + 1]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    {{ $month }}
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
