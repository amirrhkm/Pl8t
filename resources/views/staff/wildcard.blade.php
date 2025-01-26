<x-layout>
    <x-slot:heading>{{ $staff->name }}</x-slot:heading>
    <x-slot:description>Shift Summary</x-slot:description>

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $years = [2024, 2025];
            $months = collect($years)->flatMap(function($year) {
                return collect(range(1, 12))->map(function($month) use ($year) {
                    return \Carbon\Carbon::create($year, $month, 1);
                });
            });
            $previousYear = null;
        @endphp

        @foreach ($months as $date)
            @if ($previousYear !== null && $previousYear !== $date->year)
                <div class="col-span-full h-8"></div>
            @endif
            @php $previousYear = $date->year; @endphp

            @php
                $yearMonth = $date->format('Y-m');
                $data = $monthlyData[$yearMonth] ?? null;
                $totalHours = $data ? ($data['reg_hours'] + $data['reg_ot_hours'] + $data['ph_hours'] + $data['ph_ot_hours']) : 0;
                $totalSalary = $data ? ($data['reg_pay'] + $data['reg_ot_pay'] + $data['ph_pay'] + $data['ph_ot_pay']) : 0;
                $isClickable = $totalHours > 0 || $totalSalary > 0;
            @endphp
            <a href="{{ $isClickable ? route('staff.shift', ['staff' => $staff->id, 'year' => $date->year, 'month' => $date->month]) : '#' }}" 
            class="block p-6 rounded-xl border shadow-lg transition duration-300 ease-in-out {{ $isClickable 
                ? 'bg-gradient-to-br from-white to-gray-100 border-gray-200 hover:shadow-xl hover:-translate-y-1 transform' 
                : 'bg-gray-200 border-gray-300 cursor-not-allowed' }}">
                <div class="text-center">
                    <h5 class="mb-3 text-2xl font-bold tracking-tight {{ $isClickable ? 'text-gray-900' : 'text-gray-500' }}">{{ $date->format('F Y') }}</h5>
                    <div class="space-y-2">
                        <p class="font-medium {{ $isClickable ? 'text-gray-700' : 'text-gray-500' }}">
                            <span class="block text-sm {{ $isClickable ? 'text-gray-500' : 'text-gray-400' }}">Total Hours</span>
                            <span class="text-xl {{ $isClickable ? 'text-gray-800' : 'text-gray-600' }}">{{ number_format($totalHours, 1) }}</span>
                        </p>
                        <p class="font-medium {{ $isClickable ? 'text-gray-700' : 'text-gray-500' }}">
                            <span class="block text-sm {{ $isClickable ? 'text-gray-500' : 'text-gray-400' }}">Salary</span>
                            <span class="text-xl {{ $isClickable ? 'text-green-600' : 'text-gray-600' }}">RM {{ number_format($totalSalary, 2) }}</span>
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-layout>