<x-layout>
    <x-slot:heading>Shift Details for {{ $staff->name }}</x-slot:heading>

    <div class="overflow-x-auto mb-8 rounded-lg shadow">
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
                        } else {
                            $reg_hours = $hours;
                            $reg_ot_hours = $otHours;
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
                <tr>
                    <td colspan="3" class="py-2 px-4 border-b font-bold text-right">Total:</td>
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
</x-layout>