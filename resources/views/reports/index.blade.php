<x-layout>
    <x-slot:heading>Outlet Summary Report</x-slot:heading>
    <x-slot:description>{{ now()->format('F Y') }}</x-slot:description>

    <div class="bg-gray-900 text-white p-8 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Earnings Report -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-2xl font-semibold mb-4 text-green-400 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>Earnings
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-400">Total Earnings:</p>
                        <p class="text-5xl font-bold text-green-500">RM {{ number_format($data['totalEarnings']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['totalEarnings']['percentageDiff'] > 0 ? 'text-green-400' : ($data['totalEarnings']['percentageDiff'] < 0 ? 'text-red-400' : 'text-gray-400') }}">
                            @if($data['totalEarnings']['percentageDiff'] > 0)
                                Increased by {{ number_format(abs($data['totalEarnings']['percentageDiff']), 2) }}%
                            @elseif($data['totalEarnings']['percentageDiff'] < 0)
                                Decreased by {{ number_format(abs($data['totalEarnings']['percentageDiff']), 2) }}%
                            @else
                                No change
                            @endif
                            compared to last month
                        </p>
                    </div>
                    <h4 class="text-lg font-semibold text-green-300 mt-6 mb-2">Breakdown</h4>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span class="text-gray-400">Banked-in Sales cash:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['salesBankins']['current'], 2) }}
                                <span class="text-xs text-green-300 ml-1">({{ number_format($data['earningsDistribution']['salesBankins'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400">Other Earnings:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['otherEarnings']['current'], 2) }}
                                <span class="text-xs text-green-300 ml-1">({{ number_format($data['earningsDistribution']['otherEarnings'], 1) }}%)</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Expenses Report -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-2xl font-semibold mb-4 text-red-400 flex items-center">
                    <i class="fas fa-receipt mr-2"></i>Expenses
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-400">Total Expenses:</p>
                        <p class="text-5xl font-bold text-red-500">RM {{ number_format($data['totalExpenses']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['totalExpenses']['percentageDiff'] > 0 ? 'text-red-400' : ($data['totalExpenses']['percentageDiff'] < 0 ? 'text-green-400' : 'text-gray-400') }}">
                            @if($data['totalExpenses']['percentageDiff'] > 0)
                                Increased by {{ number_format(abs($data['totalExpenses']['percentageDiff']), 2) }}%
                            @elseif($data['totalExpenses']['percentageDiff'] < 0)
                                Decreased by {{ number_format(abs($data['totalExpenses']['percentageDiff']), 2) }}%
                            @else
                                No change
                            @endif
                            compared to last month
                        </p>
                    </div>
                    <h4 class="text-lg font-semibold text-red-300 mt-6 mb-2">Breakdown</h4>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span class="text-gray-400">Expenses recorded on Sales' cash:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['salesExpenses']['current'], 2) }}
                                <span class="text-xs text-red-300 ml-1">({{ number_format($data['expensesDistribution']['salesExpenses'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400">Expenses recorded on EODs:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['eodExpenses']['current'], 2) }}
                                <span class="text-xs text-red-300 ml-1">({{ number_format($data['expensesDistribution']['eodExpenses'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400">Expenses recorded on Stocks:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['invoicesTotal']['current'], 2) }}
                                <span class="text-xs text-red-300 ml-1">({{ number_format($data['expensesDistribution']['invoicesTotal'], 1) }}%)</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Part-Time Staff and Wastage Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-2xl font-semibold mb-4 text-blue-400 flex items-center">
                    <i class="fas fa-user-clock mr-2"></i>Part-Time Staff Summary
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-400">Total Hours:</p>
                        <p class="text-4xl font-bold text-gray-200">{{ number_format($data['partTimeHours']['current'], 2) }} hours</p>
                        <p class="text-sm {{ $data['partTimeHours']['percentageDiff'] > 0 ? 'text-red-400' : ($data['partTimeHours']['percentageDiff'] < 0 ? 'text-green-400' : 'text-gray-400') }}">
                            @if($data['partTimeHours']['percentageDiff'] > 0)
                                Increased by {{ number_format(abs($data['partTimeHours']['percentageDiff']), 2) }}%
                            @elseif($data['partTimeHours']['percentageDiff'] < 0)
                                Decreased by {{ number_format(abs($data['partTimeHours']['percentageDiff']), 2) }}%
                            @else
                                No change
                            @endif
                            compared to last month
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Salary:</p>
                        <p class="text-4xl font-bold text-gray-200">RM {{ number_format($data['partTimeSalary']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['partTimeSalary']['percentageDiff'] > 0 ? 'text-red-400' : ($data['partTimeSalary']['percentageDiff'] < 0 ? 'text-green-400' : 'text-gray-400') }}">
                            @if($data['partTimeSalary']['percentageDiff'] > 0)
                                Increased by {{ number_format(abs($data['partTimeSalary']['percentageDiff']), 2) }}%
                            @elseif($data['partTimeSalary']['percentageDiff'] < 0)
                                Decreased by {{ number_format(abs($data['partTimeSalary']['percentageDiff']), 2) }}%
                            @else
                                No change
                            @endif
                            compared to last month
                        </p>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="{{ route('reports.part-time-details') }}" class="inline-block bg-blue-600 text-white px-5 py-3 rounded-md hover:bg-blue-700 transition duration-300">
                        View Part-Time Details
                    </a>
                </div>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-2xl font-semibold mb-4 text-yellow-400 flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i>Wastage Summary
                </h3>
                @if($wastages->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach($wastages as $item => $totals)
                            <li class="flex justify-between items-center">
                                <span class="text-gray-400">{{ $item }}:</span>
                                <span class="font-semibold">
                                    @if(isset($totals['total_weight']))
                                        @if($totals['total_weight'] > 0)
                                            {{ number_format($totals['total_weight'], 3) }} kg
                                        @endif
                                    @endif
                                    @if(isset($totals['total_quantity']))
                                        @if($totals['total_quantity'] > 0)
                                            {{ number_format($totals['total_quantity']) }} pcs
                                        @endif
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">No wastage recorded for this month.</p>
                @endif
            </div>
        </div>
    </div>
</x-layout>
