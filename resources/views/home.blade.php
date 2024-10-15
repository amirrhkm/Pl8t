<x-layout>
    <x-slot:heading>
        Welcome to TallyUp
    </x-slot:heading>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Dashboard</h2>
        <p class="mb-4">Welcome to TallyUp, your efficient staff management system.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">Total Staff</h3>
                <p class="text-3xl font-bold">{{ $totalStaff }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">Active Shifts Today</h3>
                <p class="text-3xl font-bold">{{ $activeShiftsToday }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">Total Hours This Month</h3>
                <p class="text-3xl font-bold">{{ $totalHoursThisMonth }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">Avg. Daily Attendance</h3>
                <p class="text-3xl font-bold">{{ $avgDailyAttendance }}%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-red-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Upcoming Public Holidays</h3>
                <ul>
                    @foreach($upcomingHolidays as $holiday)
                        <li>{{ $holiday->date->format('d M Y') }} - {{ $holiday->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-indigo-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Top 5 Staff by Hours</h3>
                <ul>
                    @foreach($topStaffByHours as $staff)
                        <li>{{ $staff->name }} - {{ $staff->total_hours }} hours</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Staff Management</h3>
                <p>Manage your staff members and their information.</p>
                <a href="/staff" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Staff</a>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Shift Management</h3>
                <p>Manage and view staff shifts and schedules.</p>
                <a href="/shift" class="mt-2 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">View Shifts</a>
            </div>
        </div>
    </div>
</x-layout>