<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - {{ $staff->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Payslip for {{ $staff->name }}</h1>
    <p><strong>Payslip ID:</strong> BBC078-P15-{{ $staff->id }}-{{ $year }}-{{ $month }}</p>
    <p><strong>Month:</strong> {{ $date->format('F Y') }}</p>
    <p><strong>Position:</strong> {{ ucfirst($staff->position) }}</p>
    <p><strong>Employment Type:</strong> {{ ucfirst(str_replace('_', ' ', $staff->employment_type)) }}</p>
    @if($staff->employment_type === 'part_time')
        <p><strong>Base Rate:</strong> RM {{ number_format($staff->rate, 2) }} per hour</p>
    @endif

    @php
        $ot_rate = $staff->employment_type === 'part_time' ? 10 : 11;
    @endphp
    <h2>Hours Contribution</h2>
    <table>
        <tr>
            <th>Type</th>
            <th>Hours</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Regular Hours</td>
            <td>{{ number_format($month_reg_hours, 2) }}</td>
            <td>RM {{ number_format($staff->rate, 2) }}</td>
            <td>RM {{ number_format($reg_pay, 2) }}</td>
        </tr>
        <tr>
            <td>Regular Overtime</td>
            <td>{{ number_format($month_reg_ot_hours, 2) }}</td>
            <td>RM {{ number_format($ot_rate, 2) }}</td>
            <td>RM {{ number_format($reg_ot_pay, 2) }}</td>
        </tr>
        <tr>
            <td>Public Holiday</td>
            <td>{{ number_format($month_ph_hours, 2) }}</td>
            <td>RM {{ number_format($staff->rate * 2, 2) }}</td>
            <td>RM {{ number_format($ph_pay, 2) }}</td>
        </tr>
        <tr>
            <td>Public Holiday Overtime</td>
            <td>{{ number_format($month_ph_ot_hours, 2) }}</td>
            <td>RM {{ number_format($ot_rate * 2, 2) }}</td>
            <td>RM {{ number_format($ph_ot_pay, 2) }}</td>
        </tr>
    </table>

    <h2>Earnings Summary</h2>
    <table>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        @if($staff->employment_type === 'part_time')
        <tr>
            <td>Regular Pay</td>
            <td>RM {{ number_format($reg_pay, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td>Regular Overtime Pay</td>
            <td>RM {{ number_format($reg_ot_pay, 2) }}</td>
        </tr>
        @if($staff->employment_type === 'part_time')
        <tr>
            <td>Public Holiday Pay</td>
            <td>RM {{ number_format($ph_pay, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td>Public Holiday Overtime Pay</td>
            <td>RM {{ number_format($ph_ot_pay, 2) }}</td>
        </tr>
        <tr class="total">
            <td>Total Earnings</td>
            <td>RM {{ number_format($total_salary, 2) }}</td>
        </tr>
    </table>

    <div style="page-break-before: always;"></div>
    
    <h2>Shift Details</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Break Duration</th>
            <th>Total Hours</th>
            <th>Public Holiday</th>
        </tr>
        @foreach($monthShifts as $shift)
        <tr>
            <td>{{ $shift->date->format('Y-m-d') }}</td>
            <td>{{ $shift->start_time->format('H:i') }}</td>
            <td>{{ $shift->end_time->format('H:i') }}</td>
            <td>{{ $shift->break_duration }} hour(s)</td>
            <td>{{ $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration }}</td>
            <td>{{ $shift->is_public_holiday ? 'Yes' : 'No' }}</td>
        </tr>
        @endforeach
    </table>

    <p>This is a computer-generated document. No signature is required.</p>
</body>
</html>