<x-layout>
    <x-slot:heading>
        Public Holidays Management
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Public Holidays</h2>
            
            <!-- Month/Year Filter -->
            <form id="dateFilterForm" class="flex gap-4">
                <select name="month" id="month" class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('month', now()->month) == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                        </option>
                    @endforeach
                </select>
                <select name="year" id="year" class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @foreach(range(now()->year - 1, now()->year + 1) as $year)
                        <option value="{{ $year }}" {{ request('year', now()->year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-7 gap-2 mb-4">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="text-center font-semibold text-gray-600">{{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7 gap-2">
                @foreach($calendar as $date)
                    <div class="aspect-square">
                        @if($date)
                            <button 
                                data-date="{{ $date->format('Y-m-d') }}"
                                class="holiday-toggle w-full h-full rounded-lg border text-sm transition duration-300 ease-in-out
                                    {{ $holidays->contains($date->format('Y-m-d')) 
                                        ? 'bg-green-600 text-white border-green-600 hover:bg-green-700' 
                                        : 'bg-white text-gray-700 border-gray-300 hover:border-green-600' }}"
                            >
                                {{ $date->format('j') }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Selected Public Holidays</h3>
            <ul id="selectedHolidays" class="space-y-2">
                @foreach($holidays as $holiday)
                    <li class="flex items-center bg-green-600 p-3 rounded-lg justify-center">
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($holiday)->format('d M Y (D)') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.holiday-toggle').forEach(button => {
            button.addEventListener('click', async () => {
                const date = button.dataset.date;
                try {
                    const response = await fetch('/holidays/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ date })
                    });

                    if (response.ok) {
                        const isHoliday = button.classList.contains('bg-white');
                        if (isHoliday) {
                            button.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                            button.classList.add('bg-green-600', 'text-white', 'border-green-600', 'hover:bg-green-700');
                        } else {
                            button.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                            button.classList.remove('bg-green-600', 'text-white', 'border-green-600', 'hover:bg-green-700');
                        }
                        window.location.reload(); // Refresh to update the selected holidays list
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });

        // Handle month/year filter changes
        document.querySelectorAll('#month, #year').forEach(select => {
            select.addEventListener('change', () => {
                const month = document.getElementById('month').value;
                const year = document.getElementById('year').value;
                window.location.href = `/holidays?month=${month}&year=${year}`;
            });
        });
    </script>
    @endpush
</x-layout>
