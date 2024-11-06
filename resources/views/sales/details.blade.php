<x-layout>
    <x-slot:heading>
        Sales Details for {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('sales.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Daily Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2 text-blue-600">Total EOD</h3>
                <p class="text-3xl font-bold text-gray-800">RM {{ number_format($dailySummary->total_eod ?? 0, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2 text-green-600">Total Bank-in</h3>
                <p class="text-3xl font-bold text-gray-800">RM {{ number_format($dailySummary->total_bankin ?? 0, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2 text-red-600">Total Expenses</h3>
                <p class="text-3xl font-bold text-gray-800">RM {{ number_format($dailySummary->total_expenses ?? 0, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-2 text-yellow-600">Total Earnings</h3>
                <p class="text-3xl font-bold text-gray-800">RM {{ number_format($dailySummary->total_earning ?? 0, 2) }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Common styles -->
        <style>
            .header-cell { width: 25%; }
            .content-cell { width: 75%; }
        </style>

        <!-- EOD Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">EOD Record</h3>
            @if($eodRecords->isNotEmpty())
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Main EOD Table -->
                    <div>
                        <h4 class="text-md font-medium text-gray-600 mb-3">Main Summary</h4>
                        <table class="min-w-full">
                            @foreach($eodRecords as $eod)
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Cash</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->cash, 2) }}</td>
                                </tr>
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">E-Wallet</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->ewallet, 2) }}</td>
                                </tr>
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Expenses</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">
                                        RM {{ number_format($eod->expenses->amount_1 + $eod->expenses->amount_2 + $eod->expenses->amount_3 + 
                                            $eod->expenses->amount_4 + $eod->expenses->amount_5 + $eod->expenses->amount_6 + 
                                            $eod->expenses->amount_7 + $eod->expenses->amount_8, 2) }}
                                    </td>
                                </tr>
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Cash Difference</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->cash_difference, 2) }}</td>
                                </tr>
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Amount</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->amount_to_bank_in, 2) }}</td>
                                </tr>
                                <tr class="border-t">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Actions</th>
                                    <td class="px-6 py-3 text-sm text-gray-500 content-cell">
                                        <form action="{{ route('sales.destroyEod', $eod) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <!-- Credit Card Sales Table -->
                    <div>
                        <h4 class="text-md font-medium text-gray-600 mb-3">Credit Card Sales</h4>
                        <table class="min-w-full">
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Debit</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->debit ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Master</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->master ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Visa</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->visa ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Total Cards</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell font-semibold">
                                    RM {{ number_format(($eod->debit ?? 0) + ($eod->master ?? 0) + ($eod->visa ?? 0), 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Delivery Sales Table -->
                    <div>
                        <h4 class="text-md font-medium text-gray-600 mb-3">Delivery Sales</h4>
                        <table class="min-w-full">
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Foodpanda</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->foodpanda ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Grabfood</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->grabfood ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Shopeefood</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->shopeefood ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Total Delivery</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell font-semibold">
                                    RM {{ number_format(($eod->foodpanda ?? 0) + ($eod->grabfood ?? 0) + ($eod->shopeefood ?? 0), 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Misc/Extra Sales Table -->
                    <div>
                        <h4 class="text-md font-medium text-gray-600 mb-3">Extras</h4>
                        <table class="min-w-full">
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Prepaid</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->prepaid ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Voucher</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($eod->voucher ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-t">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell font-semibold">Day Sales</th>
                                <td class="px-6 py-3 text-sm text-gray-500 content-cell font-semibold">RM {{ number_format($eod->total_sales ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm">No EOD records found for this date.</p>
            @endif
        </div>

        <!-- Bank-in Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Bank-in Record</h3>
            @if($bankinRecords->isNotEmpty())
                <table class="min-w-full">
                    @foreach($bankinRecords as $bankin)
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Time</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">{{ \Carbon\Carbon::parse($bankin->time)->format('H:i:s') }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Bank</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">{{ $bankin->bank_name }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Amount</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($bankin->amount, 2) }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Actions</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">
                                <form action="{{ route('sales.destroyBankin', $bankin) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="border-t border-b"><td colspan="2" class="py-2"></td></tr> <!-- Spacer between records -->
                    @endforeach
                </table>
            @else
                <p class="text-gray-500 text-sm">No bank-in records found for this date.</p>
            @endif
        </div>

        <!-- Expense Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Expense Record</h3>
            @if($expenseRecords->isNotEmpty())
                <table class="min-w-full">
                    @foreach($expenseRecords as $expense)
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Expense</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">{{ $expense->description }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Amount</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($expense->amount, 2) }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Actions</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">
                                <form action="{{ route('sales.destroyExpense', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="border-t border-b"><td colspan="2" class="py-2"></td></tr> <!-- Spacer between records -->
                    @endforeach
                </table>
            @else
                <p class="text-gray-500 text-sm">No expense records found for this date.</p>
            @endif
        </div>

        <!-- Earning Records -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Earning Record</h3>
            @if($earningRecords->isNotEmpty())
                <table class="min-w-full">
                    @foreach($earningRecords as $earning)
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Earning</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">{{ $earning->description }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Amount</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">RM {{ number_format($earning->amount, 2) }}</td>
                        </tr>
                        <tr class="border-t">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50 header-cell">Actions</th>
                            <td class="px-6 py-3 text-sm text-gray-500 content-cell">
                                <form action="{{ route('sales.destroyEarning', $earning) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="border-t border-b"><td colspan="2" class="py-2"></td></tr> <!-- Spacer between records -->
                    @endforeach
                </table>
            @else
                <p class="text-gray-500 text-sm">No earning records found for this date.</p>
            @endif
        </div>
    </div>
</x-layout>