<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Admin Dashboard</h2>
            <div class="flex items-center">
                <p class="text-lg font-semibold text-gray-600">{{ now()->format('d M Y (l)') }}</p>
                <a href="{{ route('account.settings') }}" class="text-indigo-500 hover:text-indigo-600 mr-2 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline-flex items-center">
                    @csrf
                    <button type="submit" class="pl-2 text-red-500 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form> 
            </div>
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