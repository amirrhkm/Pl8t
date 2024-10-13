<x-layout>
    <x-slot:heading>Shift Details for {{ $staff->name }}</x-slot:heading>

    @php
        $shifts = $staff->shifts->sortBy('date')->groupBy(function($shift) {
            return Carbon\Carbon::parse($shift->date)->format('Y-m');
        });
    @endphp

    @foreach ($shifts as $yearMonth => $monthShifts)
        @php
            $date = Carbon\Carbon::parse($yearMonth);
            $month = $date->format('m');
            $year = $date->format('Y');
            $monthTotalHours = 0;
            $monthOvertimeHours = 0;
        @endphp

        <h2 class="text-xl font-bold mb-4">{{ $date->format('F Y') }}</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Date</th>
                        <th class="py-2 px-4 border-b text-left">Start Time</th>
                        <th class="py-2 px-4 border-b text-left">End Time</th>
                        <th class="py-2 px-4 border-b text-left">Total Hours</th>
                        <th class="py-2 px-4 border-b text-left">Overtime Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthShifts as $shift)
                        @php
                            $totalHours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
                            $overtimeHours = max(0, $totalHours - 8);
                            $monthTotalHours += $totalHours;
                            $monthOvertimeHours += $overtimeHours;
                        @endphp
                        <tr>
                            <td class="py-2 px-4 border-b">{{ Carbon\Carbon::parse($shift->date)->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b">{{ $shift->start_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $shift->end_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $totalHours }}</td>
                            <td class="py-2 px-4 border-b">{{ $overtimeHours }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100">
                    @php
                        $regularPay = $monthTotalHours * $staff->rate;
                        $overtimePay = $monthOvertimeHours * 10;
                        $totalSalary = $regularPay + $overtimePay;
                        
                        $salary = \App\Models\Salary::updateOrCreate(
                            ['staff_id' => $staff->id, 'month' => $month, 'year' => $year],
                            [
                                'total_hours' => $monthTotalHours,
                                'total_overtime_hours' => $monthOvertimeHours,
                                'total_salary' => $totalSalary,
                                'total_public_holiday_hours' => 0,
                            ]
                        );
                    @endphp
                    <tr>
                        <td colspan="3" class="py-2 px-4 border-b font-bold text-right">Month Totals:</td>
                        <td class="py-2 px-4 border-b font-bold">{{ $monthTotalHours }}</td>
                        <td class="py-2 px-4 border-b font-bold">{{ $monthOvertimeHours }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b font-bold text-right">Regular Pay:</td>
                        <td class="py-2 px-4 border-b font-bold">RM {{ number_format($regularPay, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b font-bold text-right">Overtime Pay:</td>
                        <td class="py-2 px-4 border-b font-bold">RM {{ number_format($overtimePay, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b font-bold text-right">Public Holiday Pay:</td>
                        <td class="py-2 px-4 border-b font-bold">RM (To-Be-Implemented)</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b font-bold text-right">Total Salary:</td>
                        <td class="py-2 px-4 border-b font-bold">RM {{ number_format($totalSalary, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
</x-layout>