<x-layout>
    <x-slot:heading>Shift Details for {{ $staff->name }}</x-slot:heading>

    <div class="overflow-x-auto mb-8 rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-center">Date</th>
                    <th class="py-2 px-4 border-b text-left text-center">Start Time</th>
                    <th class="py-2 px-4 border-b text-left text-center">End Time</th>
                    <th class="py-2 px-4 border-b text-left text-center">Regular Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">Regular OT Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">PH Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">PH OT Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthShifts as $shift)
                    @php
                        $hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
                        $otHours = max(0, $hours - 8);

                        $reg_hours = 0.0;
                        $reg_ot_hours = 0.0;
                        $ph_hours = 0.0;
                        $ph_ot_hours = 0.0;

                        if ($shift->is_public_holiday) {
                            $ph_hours = $hours;
                            $ph_ot_hours = $otHours;
                        } else {
                            $reg_hours = $hours;
                            $reg_ot_hours = $otHours;
                        }
                    @endphp
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ Carbon\Carbon::parse($shift->date)->format('d/m') }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $shift->start_time->format('H:i') }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $shift->end_time->format('H:i') }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $reg_hours }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $reg_ot_hours }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $ph_hours }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $ph_ot_hours }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100">
                <tr>
                    <td colspan="3" class="py-2 px-4 border-b font-bold text-right">Total Hours:</td>
                    <td class="py-2 px-4 border-b font-bold text-center">{{ $month_reg_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold text-center">{{ $month_reg_ot_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold text-center">{{ $month_ph_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold text-center">{{ $month_ph_ot_hours }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Payslip for {{ $staff->name }}</h2>
            <a href="{{ route('staff.payslip.download', ['staff' => $staff->id, 'month' => $monthShifts->first()->date->format('Y-m')]) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Download Payslip
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>Employee Name:</strong> {{ $staff->name }}</p>
                <p><strong>Month:</strong> {{ $monthShifts->first()->date->format('F Y') }}</p>
                <p><strong>Rate:</strong> RM {{ $staff->rate }}</p>
            </div>
            <div>
                <p><strong>Regular Hours:</strong> {{ $month_reg_hours }}</p>
                <p><strong>Overtime Hours:</strong> {{ $month_reg_ot_hours }}</p>
                <p><strong>Public Holiday Hours:</strong> {{ $month_ph_hours }}</p>
                <p><strong>Public Holiday Overtime Hours:</strong> {{ $month_ph_ot_hours }}</p>
            </div>
        </div>
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left">Earnings</th>
                    <th class="text-right">Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Regular Pay</td>
                    <td class="text-right">{{ number_format($reg_pay, 2) }}</td>
                </tr>
                <tr>
                    <td>Regular Overtime Pay</td>
                    <td class="text-right">{{ number_format($reg_ot_pay, 2) }}</td>
                </tr>
                <tr>
                    <td>Public Holiday Pay</td>
                    <td class="text-right">{{ number_format($ph_pay, 2) }}</td>
                </tr>
                <tr>
                    <td>Public Holiday Overtime Pay</td>
                    <td class="text-right">{{ number_format($ph_ot_pay, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td>Total Salary</td>
                    <td class="text-right">{{ number_format($total_salary, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-layout>