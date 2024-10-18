<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    
    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Shift Dashboard</h2>
            <p class="text-lg font-semibold text-gray-600">{{ now()->format('d M Y (l)') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Quick Stats</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Staff availability status:</span>
                        @php
                            $availabilityClass = '';
                            $availabilityText = '';
                            switch($staffAvailability) {
                                case 1:
                                    $availabilityClass = 'bg-green-100 text-green-800';
                                    $availabilityText = 'Healthy';
                                    break;
                                case 2:
                                    $availabilityClass = 'bg-yellow-100 text-yellow-800';
                                    $availabilityText = 'Okay';
                                    break;
                                case 3:
                                    $availabilityClass = 'bg-red-100 text-red-800';
                                    $availabilityText = 'Critical';
                                    break;
                                default:
                                    $availabilityClass = 'bg-gray-100 text-gray-800';
                                    $availabilityText = 'Unknown';
                            }
                        @endphp
                        <span class="text-sm font-semibold {{ $availabilityClass }} px-3 py-1 rounded-full">{{ $availabilityText }}</span>
                    </li>
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Total {{ now()->format('M') }} OT Hours:</span>
                        <span class="text-2xl font-bold text-red-600">{{ $totalOvertimeHours }}</span>
                    </li>
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Staff on duty today:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $staffOnDutyToday }}</span>
                    </li>
                </ul>
            </div>

            <!-- Shift Overview by Month -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Month Overview</h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (range(1, 12) as $month)
                        <a href="{{ route('shift.month', ['year' => date('Y'), 'month' => $month]) }}" 
                        class="text-white font-bold py-2 px-3 rounded flex items-center justify-center 
                                text-sm transition duration-300 ease-in-out hover:bg-opacity-90 shadow-md
                                {{ $month % 2 == 0 ? 'bg-blue-500' : 'bg-blue-600' }}">
                            {{ date('M', mktime(0, 0, 0, $month, 1)) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('shift.today', ['date' => now()->format('Y-m-d')]) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        This Day
                    </a>
                    <a href="{{ route('shift.week', ['date' => now()->format('Y-m-d')]) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        This Week
                    </a>
                    <a href="{{ route('shift.month', ['year' => date('Y'), 'month' => date('m')]) }}" class="block w-full text-center bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        This Month
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <!-- Shift Overview by Week -->
            <div class="bg-white bg-opacity-90 p-6 rounded-lg shadow-md w-full">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Week Overview</h2>
                <div class="grid grid-cols-7 gap-2">
                    @php
                        $today = now();
                        $weekStart = $today->startOfWeek();
                    @endphp
                    @foreach (range(0, 6) as $dayOffset)
                        @php
                            $currentDay = $weekStart->copy()->addDays($dayOffset);
                            $dateKey = $currentDay->format('Y-m-d');
                        @endphp
                        <div class="text-center py-2 px-1 {{ $currentDay->isToday() ? 'bg-blue-100' : 'bg-gray-100' }} rounded">
                            <span class="block text-sm font-semibold text-gray-700">{{ $currentDay->format('D') }}</span>
                            <span class="block text-xs text-gray-500">{{ $currentDay->format('d M') }}</span>
                            @if(isset($weeklyShifts[$dateKey]))
                                @php
                                    $shifts = $weeklyShifts[$dateKey];
                                    $openingShifts = $shifts->filter(function($shift) {
                                        return $shift->start_time->format('H:i') === '07:30';
                                    })->count();
                                    $middleShifts = $shifts->filter(function($shift) {
                                        return $shift->start_time->format('H:i') === '10:30';
                                    })->count();
                                    $closingShifts = $shifts->filter(function($shift) {
                                        return $shift->end_time->format('H:i') === '23:00';
                                    })->count();
                                @endphp
                                <span class="block text-xs font-medium text-gray-600">{{ $shifts->count() }} staff</span>
                                <span class="block text-xs text-gray-500">O: <strong>{{ $openingShifts }}</strong></span>
                                <span class="block text-xs text-gray-500">M: <strong>{{ $middleShifts }}</strong></span>
                                <span class="block text-xs text-gray-500">C: <strong>{{ $closingShifts }}</strong></span>
                            @else
                                <span class="block text-xs font-medium text-gray-600">No staff</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
