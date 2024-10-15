<x-layout>
    <x-slot:heading>Shift Overview</x-slot:heading>
    
    <div class="flex justify-center">
        <div class="mb-8 bg-white bg-opacity-30 p-4 rounded-lg shadow inline-block">
            <h2 class="text-xl font-bold mb-4 text-white text-center">2024</h2>
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                @foreach (range(1, 12) as $month)
                    <a href="{{ route('shift.month', ['year' => 2024, 'month' => $month]) }}" 
                    class="bg-white text-blue-500 hover:bg-blue-500 hover:text-white font-bold 
                            w-14 h-14 rounded-full flex items-center justify-center 
                            text-xl transition duration-300 ease-in-out transform hover:scale-110">
                        {{ $month }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>