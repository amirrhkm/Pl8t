<x-layout>
    <x-slot:heading>Outlet Summary Report</x-slot:heading>
    <x-slot:description>{{ now()->format('F Y') }}</x-slot:description>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Earnings Report -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Earnings</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600">Total Earnings:</p>
                        <p class="text-6xl font-bold text-green-600">RM {{ number_format($data['totalEarnings']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['totalEarnings']['percentageDiff'] > 0 ? 'text-green-500' : ($data['totalEarnings']['percentageDiff'] < 0 ? 'text-red-500' : 'text-gray-500') }}">
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
                    <h4 class="text-lg font-semibold text-indigo-700 mt-6 mb-2">Breakdown</h4>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Banked-in Sales cash:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['salesBankins']['current'], 2) }}
                                <!-- <span class="text-sm {{ $data['salesBankins']['percentageDiff'] > 0 ? 'text-green-500' : ($data['salesBankins']['percentageDiff'] < 0 ? 'text-red-500' : 'text-gray-500') }}">
                                    ({{ $data['salesBankins']['percentageDiff'] > 0 ? '+' : '' }}{{ number_format($data['salesBankins']['percentageDiff'], 2) }}%)
                                </span> -->
                                <span class="text-xs text-blue-700 ml-1">({{ number_format($data['earningsDistribution']['salesBankins'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Other Earnings:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['otherEarnings']['current'], 2) }}
                                <!-- <span class="text-sm {{ $data['otherEarnings']['percentageDiff'] > 0 ? 'text-green-500' : ($data['otherEarnings']['percentageDiff'] < 0 ? 'text-red-500' : 'text-gray-500') }}">
                                    ({{ $data['otherEarnings']['percentageDiff'] > 0 ? '+' : '' }}{{ number_format($data['otherEarnings']['percentageDiff'], 2) }}%)
                                </span> -->
                                <span class="text-xs text-blue-700 ml-1">({{ number_format($data['earningsDistribution']['otherEarnings'], 1) }}%)</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Expenses Report -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Expenses</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600">Total Expenses:</p>
                        <p class="text-6xl font-bold text-red-600">RM {{ number_format($data['totalExpenses']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['totalExpenses']['percentageDiff'] > 0 ? 'text-red-500' : ($data['totalExpenses']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
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
                    <h4 class="text-lg font-semibold text-indigo-700 mt-6 mb-2">Breakdown</h4>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Expenses recorded on Sales' cash:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['salesExpenses']['current'], 2) }}
                                <!-- <span class="text-sm {{ $data['salesExpenses']['percentageDiff'] > 0 ? 'text-red-500' : ($data['salesExpenses']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
                                    ({{ $data['salesExpenses']['percentageDiff'] > 0 ? '+' : '' }}{{ number_format($data['salesExpenses']['percentageDiff'], 2) }}%)
                                </span> -->
                                <span class="text-xs text-blue-700 ml-1">({{ number_format($data['expensesDistribution']['salesExpenses'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Expenses recorded on EODs:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['eodExpenses']['current'], 2) }}
                                <!-- <span class="text-sm {{ $data['eodExpenses']['percentageDiff'] > 0 ? 'text-red-500' : ($data['eodExpenses']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
                                    ({{ $data['eodExpenses']['percentageDiff'] > 0 ? '+' : '' }}{{ number_format($data['eodExpenses']['percentageDiff'], 2) }}%)
                                </span> -->
                                <span class="text-xs text-blue-700 ml-1">({{ number_format($data['expensesDistribution']['eodExpenses'], 1) }}%)</span>
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Expenses recorded on Stocks:</span>
                            <span class="font-semibold">
                                RM {{ number_format($data['invoicesTotal']['current'], 2) }}
                                <!-- <span class="text-sm {{ $data['invoicesTotal']['percentageDiff'] > 0 ? 'text-red-500' : ($data['invoicesTotal']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
                                    ({{ $data['invoicesTotal']['percentageDiff'] > 0 ? '+' : '' }}{{ number_format($data['invoicesTotal']['percentageDiff'], 2) }}%)
                                </span> -->
                                <span class="text-xs text-blue-700 ml-1">({{ number_format($data['expensesDistribution']['invoicesTotal'], 1) }}%)</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Part-Time Staff and Wastage Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Part-Time Staff Summary</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600">Total Hours:</p>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($data['partTimeHours']['current'], 2) }} hours</p>
                        <p class="text-sm {{ $data['partTimeHours']['percentageDiff'] > 0 ? 'text-red-500' : ($data['partTimeHours']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
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
                        <p class="text-gray-600">Total Salary:</p>
                        <p class="text-3xl font-bold text-gray-800">RM {{ number_format($data['partTimeSalary']['current'], 2) }}</p>
                        <p class="text-sm {{ $data['partTimeSalary']['percentageDiff'] > 0 ? 'text-red-500' : ($data['partTimeSalary']['percentageDiff'] < 0 ? 'text-green-500' : 'text-gray-500') }}">
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
                <div class="mt-6">
                    <a href="{{ route('reports.part-time-details') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                        View Part-Time Details
                    </a>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Wastage Summary</h3>
                @if($wastages->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach($wastages as $item => $totals)
                            <li class="flex justify-between items-center">
                                <span class="text-gray-600">{{ $item }}:</span>
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
                    <p class="text-gray-600">No wastage recorded for this month.</p>
                @endif
            </div>
        </div>
    </div>
</x-layout>