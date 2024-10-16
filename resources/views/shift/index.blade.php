<x-layout>
    <x-slot:heading>Shift Central</x-slot:heading>
    
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Shift Dashboard</h2>
            <p class="text-lg font-semibold text-gray-600">{{ now()->format('d M Y (l)') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600">Quick Stats</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center">
                        <span class="text-gray-600">Total shifts this month:</span>
                        <span class="text-2xl font-bold text-indigo-700">{{ $totalShiftsThisMonth }}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-gray-600">Upcoming shifts:</span>
                        <span class="text-2xl font-bold text-green-600">{{ $upcomingShifts }}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-gray-600">Staff on duty today:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $staffOnDutyToday }}</span>
                    </li>
                </ul>
            </div>

            <!-- Recent Activity Logs -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600">Recent Activity</h3>
                @if(is_array($recentActivities) || $recentActivities instanceof \Traversable)
                    <ul class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($recentActivities as $activity)
                            <li class="flex items-center space-x-2 text-sm">
                                @if(is_object($activity) && property_exists($activity, 'created_at'))
                                    <span class="text-gray-400">{{ $activity->created_at->format('M d, H:i') }}</span>
                                @endif
                                <span class="text-gray-600">
                                    @if(is_object($activity) && property_exists($activity, 'description'))
                                        {{ $activity->description }}
                                    @elseif(is_string($activity))
                                        {{ $activity }}
                                    @else
                                        Activity details not available
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No recent activities to display.</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('shift.today', ['date' => now()->format('Y-m-d')]) }}" class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        Manage Today's Shifts
                    </a>
                    <a href="{{ route('shift.month', ['year' => date('Y'), 'month' => date('m')]) }}" class="block w-full text-center bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        View This Month's Shifts
                    </a>
                    <a href="{{ route('staff.index') }}" class="block w-full text-center bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                        Manage Staff
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white bg-opacity-80 p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-bold mb-4 text-indigo-600 text-center">Shift Overview by Month</h2>
            <div class="flex justify-center items-center space-x-1">
                @foreach (range(1, 12) as $month)
                    <a href="{{ route('shift.month', ['year' => date('Y'), 'month' => $month]) }}" 
                    class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white hover:from-indigo-600 hover:to-blue-600 font-bold 
                            w-20 h-20 rounded-full flex items-center justify-center 
                            text-lg transition duration-300 ease-in-out transform hover:scale-110 shadow-md">
                        {{ date('M', mktime(0, 0, 0, $month, 1)) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>