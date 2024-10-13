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
            $month_reg_hours = 0;
            $month_reg_ot_hours = 0;
            $month_ph_hours = 0;
            $month_ph_ot_hours = 0;
        @endphp

        <h2 class="text-xl font-bold mb-4">{{ $date->format('F Y') }}</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Date</th>
                        <th class="py-2 px-4 border-b text-left">Start Time</th>
                        <th class="py-2 px-4 border-b text-left">End Time</th>
                        <th class="py-2 px-4 border-b text-left">Regular Hours</th>
                        <th class="py-2 px-4 border-b text-left">Regular OT Hours</th>
                        <th class="py-2 px-4 border-b text-left">PH Hours</th>
                        <th class="py-2 px-4 border-b text-left">PH OT Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthShifts as $shift)
                        @php
                            $hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
                            $otHours = max(0, $hours - 8);

                            $reg_hours = 0;
                            $reg_ot_hours = 0;
                            $ph_hours = 0;
                            $ph_ot_hours = 0;

                            if ($shift->is_public_holiday) {
                                $ph_hours = $hours;
                                $ph_ot_hours = $otHours;
                                $month_ph_hours += $ph_hours;
                                $month_ph_ot_hours += $ph_ot_hours;
                            } else {
                                $reg_hours = $hours;
                                $reg_ot_hours = $otHours;
                                $month_reg_hours += $reg_hours;
                                $month_reg_ot_hours += $reg_ot_hours;
                            }
                        @endphp
                        <tr>
                            <td class="py-2 px-4 border-b">{{ Carbon\Carbon::parse($shift->date)->format('d/m') }}</td>
                            <td class="py-2 px-4 border-b">{{ $shift->start_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $shift->end_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $reg_hours }}</td>
                            <td class="py-2 px-4 border-b">{{ $reg_ot_hours }}</td>
                            <td class="py-2 px-4 border-b">{{ $ph_hours }}</td>
                            <td class="py-2 px-4 border-b">{{ $ph_ot_hours }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100">
                @php
                    $reg_pay = $month_reg_hours * $staff->rate;
                    $reg_ot_pay = $month_reg_ot_hours * 10;
                    $ph_pay = $month_ph_hours * $staff->rate * 2;
                    $ph_ot_pay = $month_ph_ot_hours * 10 * 2;
                    
                    $total_salary = $reg_pay + $reg_ot_pay + $ph_pay + $ph_ot_pay;
                    
                    $salary = \App\Models\Salary::updateOrCreate(
                        ['staff_id' => $staff->id, 'month' => $month, 'year' => $year],
                        [
                            'total_reg_hours' => $month_reg_hours,
                            'total_reg_ot_hours' => $month_reg_ot_hours,
                            'total_ph_hours' => $month_ph_hours,
                            'total_ph_ot_hours' => $month_ph_ot_hours,
                            'total_salary' => $total_salary,
                        ]
                    );
                @endphp
                <tr>
                    <td colspan="3" class="py-2 px-4 border-b font-bold text-right"></td>
                    <td class="py-2 px-4 border-b font-bold">{{ $month_reg_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold">{{ $month_reg_ot_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold">{{ $month_ph_hours }}</td>
                    <td class="py-2 px-4 border-b font-bold">{{ $month_ph_ot_hours }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="py-2 px-4 text-right">Regular Pay:</td>
                    <td class="py-2 px-4">RM {{ number_format($reg_pay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="py-2 px-4 text-right">Regular Overtime Pay:</td>
                    <td class="py-2 px-4">RM {{ number_format($reg_ot_pay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="py-2 px-4 text-right">Public Holiday Pay:</td>
                    <td class="py-2 px-4">RM {{ number_format($ph_pay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="py-2 px-4 text-right">Public Holiday Overtime Pay:</td>
                    <td class="py-2 px-4">RM {{ number_format($ph_ot_pay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="py-2 px-4 border-b font-bold text-right">Total Salary:</td>
                    <td class="py-2 px-4 border-b font-bold">RM {{ number_format($total_salary, 2) }}</td>
                </tr>
            </tfoot>
            </table>
        </div>
    @endforeach
</x-layout>