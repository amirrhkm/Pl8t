<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    
    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Shift Dashboard</h2>
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
                        <span class="text-2xl font-bold text-gray-800">{{ $totalOvertimeHours }}</span>
                    </li>
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Staff on duty today:</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $staffOnDutyToday }}</span>
                    </li>
                </ul>
            </div>

            <!-- Shift Overview by Month -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Month Overview</h3>
                    <div class="flex space-x-2">
                        <button onclick="setYear(2024)" class="px-3 py-1 rounded text-sm font-medium transition-colors duration-200 
                            {{ request()->input('year', date('Y')) == '2024' ? 'bg-gray-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            2024
                        </button>
                        <button onclick="setYear(2025)" class="px-3 py-1 rounded text-sm font-medium transition-colors duration-200
                            {{ request()->input('year', date('Y')) == '2025' ? 'bg-gray-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            2025
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (range(1, 12) as $month)
                        <a href="{{ route('shift.month', ['year' => request()->input('year', date('Y')), 'month' => $month]) }}" 
                        class="text-white font-bold py-2 px-3 rounded flex items-center justify-center 
                                text-sm transition duration-300 ease-in-out hover:bg-opacity-90 shadow-md
                                bg-gray-800 hover:bg-green-600">
                            {{ date('M', mktime(0, 0, 0, $month, 1)) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('shift.today', ['date' => now()->format('Y-m-d')]) }}" class="block w-full text-center bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        This Day
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('shift.week', ['date' => now()->subWeek()->format('Y-m-d')]) }}" class="text-sm flex-1 text-center bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                            Last Week
                        </a>
                        <a href="{{ route('shift.week', ['date' => now()->format('Y-m-d')]) }}" class="text-sm flex-1 text-center bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                            This Week
                        </a>
                        <a href="{{ route('shift.week', ['date' => now()->addWeek()->format('Y-m-d')]) }}" class="text-sm flex-1 text-center bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                            Next Week
                        </a>
                    </div>
                    <a href="{{ route('shift.month', ['year' => date('Y'), 'month' => date('m')]) }}" class="block w-full text-center bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
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
                        <div class="text-center py-2 px-1 {{ $currentDay->isToday() ? 'bg-green-500 bg-opacity-20' : 'bg-gray-100' }} rounded">
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

        <!-- Staff Off-Day Record -->
        <!-- <div class="bg-white bg-opacity-90 p-6 rounded-lg shadow-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">Staff on Off-Day</h2>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-green-100 border border-green-800"></span>
                        <span class="text-xs text-gray-600">Full-time</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-gray-100 border border-gray-800"></span>
                        <span class="text-xs text-gray-600">Part-time</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-7 gap-2">
                @php
                    $startOfWeek = now()->startOfWeek();
                @endphp
                @foreach(range(0, 6) as $dayOffset)
                    @php
                        $currentDay = $startOfWeek->copy()->addDays($dayOffset);
                        $dateKey = $currentDay->format('Y-m-d');
                        $offDayStaff = $offDayRecords[$dateKey] ?? collect();
                        $isToday = $currentDay->isToday();
                    @endphp
                    <div class="relative {{ $isToday ? 'ring-2 ring-blue-400' : '' }}">
                        <div class="text-center py-3 px-2 bg-gray-50 rounded-lg hover:shadow-md transition-all duration-200">
                            <!-- Date Header -->
                            <!-- <div class="mb-2 {{ $isToday ? 'bg-green-500 bg-opacity-20 -mt-3 py-1 rounded-t-lg' : '' }}">
                                <span class="block text-sm font-bold text-gray-700">{{ $currentDay->format('D') }}</span>
                                <span class="block text-xs text-gray-500">{{ $currentDay->format('d M') }}</span>
                            </div> -->
                            
                            <!-- Staff Count Badge -->
                            <!-- @if($offDayStaff->isNotEmpty())
                                <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $offDayStaff->count() }}
                                </span>
                            @endif -->
                            
                            <!-- Staff List -->
                            <!-- <div class="min-h-[80px] flex items-center justify-center">
                                @if($offDayStaff->isNotEmpty())
                                    <div class="space-y-1.5 w-full">
                                        @php
                                            $fullTimeStaff = $offDayStaff->filter(fn($staff) => $staff->employment_type === 'full_time');
                                            $partTimeStaff = $offDayStaff->filter(fn($staff) => $staff->employment_type !== 'full_time');
                                        @endphp
                                        
                                        {{-- Full-time staff first --}}
                                        @foreach($fullTimeStaff as $staffMember)
                                            <div class="flex justify-center">
                                                <span class="text-xs font-medium bg-green-100 text-green-800 px-3 py-1 rounded-full border border-green-200 w-full truncate">
                                                    {{ $staffMember->nickname }}
                                                </span>
                                            </div>
                                        @endforeach
                                        
                                        {{-- Part-time staff second --}}
                                        @foreach($partTimeStaff as $staffMember)
                                            <div class="flex justify-center">
                                                <span class="text-xs font-medium bg-gray-100 text-gray-800 px-3 py-1 rounded-full border border-gray-200 w-full truncate">
                                                    {{ $staffMember->nickname }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No off-day staff</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> -->
    </div>
</x-layout>

<script>
    function setYear(year) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('year', year);
        window.location.search = urlParams.toString();
    }
</script>
