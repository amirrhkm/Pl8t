<x-layout>
    <x-slot:heading>{{ $staff->name }}</x-slot:heading>
    <x-slot:description>{{ $date->format('F') }} Shift Details</x-slot:description>

    <div class="overflow-x-auto mb-8 rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-center">Date</th>
                    <th class="py-2 px-4 border-b text-left text-center">Clock In</th>
                    <th class="py-2 px-4 border-b text-left text-center">Clock Out</th>
                    <th class="py-2 px-4 border-b text-left text-center">Regular Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">Regular OT Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">PH Hours</th>
                    <th class="py-2 px-4 border-b text-left text-center">PH OT Hours</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $latestDateInShifts = $monthShifts->max('date');
                    $furthestDate = $latestDateInShifts->greaterThan(now()) ? $latestDateInShifts : now();
                    $firstDateOfMonth = $furthestDate->copy()->startOfMonth();
                    $currentDate = $firstDateOfMonth->copy();
                @endphp

                @while ($currentDate->lte($furthestDate))
                    @php
                        $shift = $monthShifts->firstWhere('date', $currentDate);
                    @endphp

                    @if ($shift)
                        @php
                            $total_hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
                            $parsedDate = \Carbon\Carbon::parse($shift->date);

                            // Manual Ingestion for Supervisor (Saturday)
                            if((int)$shift->staff_id === 7 && $parsedDate->isSaturday()){
                                $otHours = max(0, $total_hours - 4);
                                $hours = $total_hours - $otHours;
                            } else {
                                $otHours = max(0, $total_hours - 8);
                                $hours = $total_hours - $otHours;
                            }

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
                            <td class="py-2 px-4 border-b text-center">{{ $currentDate->format('d/m') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $shift->start_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $shift->end_time->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $reg_hours }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $reg_ot_hours }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $ph_hours }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $ph_ot_hours }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $currentDate->format('d/m') }}</td>
                            <td colspan="6" class="py-2 px-4 border-b text-center bg-gray-800 text-white font-semibold rounded-lg">
                                Off Day
                            </td>
                        </tr>
                    @endif

                    @php
                        $currentDate->addDay();
                    @endphp
                @endwhile
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
               class="bg-gray-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Download Payslip
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>Employee Name:</strong> {{ $staff->name }}</p>
                <p><strong>Month:</strong> {{ $monthShifts->first()->date->format('F Y') }}</p>
                @if($staff->employment_type === 'part_time')
                    <p><strong>Rate:</strong> RM {{ $staff->rate }}</p>
                @endif
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
                @if($staff->employment_type === 'part_time')
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
                @else
                    <tr>
                        <td>Regular Overtime Pay</td>
                        <td class="text-right">{{ number_format($reg_ot_pay, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Public Holiday Overtime Pay</td>
                        <td class="text-right">{{ number_format($ph_ot_pay, 2) }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td>{{ $staff->employment_type === 'part_time' ? 'Total Salary' : 'Total Overtime Pay' }}</td>
                    <td class="text-right">{{ number_format($total_salary, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-layout>