<x-layout>
    <x-slot:heading>
        Team Hub
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">{{ $staff->name }}'s Leaves</h2>
            <p class="text-lg font-semibold text-gray-600">{{ now()->format('d M Y (l)') }}</p>
        </div>

        <!-- Leave Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-2 text-blue-600">Sick Leave (MC)</h3>
                @if ($mc_used >= 8)
                    <p class="text-4xl font-bold text-red-500">{{ $mc_used }}<span class="text-2xl text-gray-600">/12</span></p>
                @else
                    <p class="text-4xl font-bold text-gray-800">{{ $mc_used }}<span class="text-2xl text-gray-600">/12</span></p>
                @endif
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-2 text-green-600">Annual Leave (AL)</h3>
                @if ($staff->nickname == 'azlin')
                    @if ($al_used >= 10)
                        <p class="text-4xl font-bold text-red-500">{{ $al_used }}<span class="text-2xl text-gray-600">/14</span></p>
                    @else
                        <p class="text-4xl font-bold text-gray-800">{{ $al_used }}<span class="text-2xl text-gray-600">/14</span></p>
                    @endif
                @else
                    @if ($al_used >= 8)
                        <p class="text-4xl font-bold text-red-500">{{ $al_used }}<span class="text-2xl text-gray-600">/12</span></p>
                    @else
                        <p class="text-4xl font-bold text-gray-800">{{ $al_used }}<span class="text-2xl text-gray-600">/12</span></p>
                    @endif
                @endif
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                <h3 class="text-lg font-semibold mb-2 text-yellow-600">Unpaid Leave (UL)</h3>
                <p class="text-4xl font-bold text-gray-800">{{ $ul_used }}</p>
            </div>
        </div>

        <!-- Leave Application Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <h2 class="text-xl font-semibold p-4 bg-gray-50 border-b border-gray-200">{{ now()->format('Y') }} Leaves</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Leave Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Total Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leaveApplications as $application)
                        @php
                            if ($application->leave_type == 'MC') {
                                $leave_type = 'Sick Leave';
                            } elseif ($application->leave_type == 'AL') {
                                $leave_type = 'Annual Leave';
                            } else {
                                $leave_type = 'Unpaid Leave';
                            }
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $leave_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $application->start_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $application->end_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $application->total_days }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                <form action="{{ route('staff.leave.destroy', $application->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No leave applied yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- New Leave Application Form -->
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-semibold mb-4 text-indigo-800">Apply for Leave</h2>
            <form action="{{ route('staff.leave.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="leave_type">
                        Leave Type
                    </label>
                    <select name="leave_type" id="leave_type" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="MC">Sick Leave (MC)</option>
                        <option value="AL">Annual Leave (AL)</option>
                        <option value="UL">Unpaid Leave (UL)</option>
                    </select>
                </div>
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                            From
                        </label>
                        <input type="text" name="start_date" id="start_date" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                            To
                        </label>
                        <input type="text" name="end_date" id="end_date" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="DD-MM-YYYY">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var startDatePicker = new Pikaday({
                field: document.getElementById('start_date'),
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                container: document.getElementById('start_date').parentNode
            });

            var endDatePicker = new Pikaday({
                field: document.getElementById('end_date'),
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                container: document.getElementById('end_date').parentNode
            });
        });
    </script>
</x-layout>