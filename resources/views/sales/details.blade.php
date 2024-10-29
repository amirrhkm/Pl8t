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

        <!-- EOD Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">EOD Record</h3>
            </div>
            @if($eodRecords->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($eodRecords as $eod)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($eod->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        RM {{ number_format($eod->amount_to_bank_in, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('sales.destroyEod', $eod) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">No EOD records found for this date.</p>
            @endif
        </div>

        <!-- Bank-in Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Bank-in Record</h3>
            </div>
            @if($bankinRecords->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bankinRecords as $bankin)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($bankin->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        RM {{ number_format($bankin->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('sales.destroyBankin', $bankin) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">No bank-in records found for this date.</p>
            @endif
        </div>

        <!-- Expense Records -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Expense Record</h3>
            </div>
            @if($expenseRecords->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($expenseRecords as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($expense->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $expense->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        RM {{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('sales.destroyExpense', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">No expense records found for this date.</p>
            @endif
        </div>

        <!-- Earning Records -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Earning Record</h3>
            </div>
            @if($earningRecords->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($earningRecords as $earning)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($earning->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $earning->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        RM {{ number_format($earning->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('sales.destroyEarning', $earning) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">No earning records found for this date.</p>
            @endif
        </div>
    </div>
</x-layout>