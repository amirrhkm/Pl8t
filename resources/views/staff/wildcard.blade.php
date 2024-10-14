<x-layout>
    <x-slot:heading>Shift Summary for {{ $staff->name }}</x-slot:heading>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $currentYear = now()->year;
            $months = collect(range(1, 12))->map(function($month) use ($currentYear) {
                return \Carbon\Carbon::create($currentYear, $month, 1);
            });
        @endphp

        @foreach ($months as $date)
            @php
                $yearMonth = $date->format('Y-m');
                $data = $monthlyData[$yearMonth] ?? null;
                $totalHours = $data ? ($data['reg_hours'] + $data['reg_ot_hours'] + $data['ph_hours'] + $data['ph_ot_hours']) : 0;
                $totalSalary = $data ? ($data['reg_pay'] + $data['reg_ot_pay'] + $data['ph_pay'] + $data['ph_ot_pay']) : 0;
            @endphp
            <a href="{{ route('staff.shift', ['staff' => $staff->id, 'year' => $date->year, 'month' => $date->month]) }}" 
               class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $date->format('F Y') }}</h5>
                <p class="font-normal text-gray-700">Total Hours: {{ number_format($totalHours, 1) }}</p>
                <p class="font-normal text-gray-700">Salary: RM {{ number_format($totalSalary, 2) }}</p>
            </a>
        @endforeach
    </div>
</x-layout>