<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Admin Dashboard</h2>
            <p class="text-lg font-semibold text-gray-600">{{ now()->format('d M Y (l)') }}</p>
        </div>
        <p class="mb-8 text-gray-600"><strong>BBC078 P15</strong>: Bask Bear Coffee Presint 15 </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">Total Staff</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $totalStaff }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-green-600">Active Shifts Today</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $activeShiftsToday }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-2 text-yellow-600">{{ now()->format('F') }} Total Hours</h3>
                <p class="text-4xl font-bold text-gray-800">{{ $totalHoursThisMonth }}</p>
                <p class="text-sm mt-2">
                    <span class="text-gray-800">
                        {{ $hoursPercentageChange >= 0 ? 'increased by ' : 'decreased by ' }}
                    </span>
                    <span class="{{ $hoursPercentageChange >= 0 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $hoursPercentageChange >= 0 ? '+' : '-' }}{{ number_format(abs($hoursPercentageChange), 2) }}%
                    </span>
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-2 text-purple-600">{{ now()->format('F') }} Total PT Salary</h3>
                <p class="text-4xl font-bold text-gray-800">RM {{ $totalPartTimeStaffSalaryThisMonth }}</p>
                <p class="text-sm mt-2">
                    <span class="text-gray-800">
                        {{ $salaryPercentageChange >= 0 ? 'increased by ' : 'decreased by ' }}
                    </span>
                    <span class="{{ $salaryPercentageChange >= 0 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $salaryPercentageChange >= 0 ? '+' : '-' }}{{ number_format(abs($salaryPercentageChange), 2) }}%
                    </span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Upcoming {{ now()->format('Y') }} Public Holidays</h3>
                <ul class="space-y-3">
                    @foreach($upcomingHolidays as $holiday)
                        <li class="flex items-center bg-gradient-to-r from-indigo-50 to-blue-50 p-3 rounded-lg justify-center">
                            <span class="w-28 text-indigo-700 font-semibold whitespace-nowrap">{{ $holiday->date->format('d M Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Top Performers in {{ now()->format('F') }}</h3>
                <ul class="space-y-2">
                    @foreach($topStaffByHours as $staff)
                        <li class="flex items-center justify-between">
                            <span class="text-gray-800">{{ $staff->name }}</span>
                            <span class="text-indigo-600 font-medium">{{ $staff->shifts_sum_total_hours }} hours</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Team Hub</h3>
                <p class="text-gray-600 mb-4">Manage staff profiles, roles, and payroll.</p>
                    <a href="/staff" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 ease-in-out">Manage Members</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Shift Central</h3>
                <p class="text-gray-600 mb-4">Organize schedules, track hours, and optimize workforce.</p>
                    <a href="/shift" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300 ease-in-out">Manage Shifts</a>
            </div>
        </div>
    </div>
</x-layout>