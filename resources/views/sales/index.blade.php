<x-layout>
    <x-slot:heading>
        Sales Dashboard
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Sales Overview</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">Total Sales</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['total_sales'], 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-red-600">Total Expenses</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['total_expenses'], 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-green-600">Credit Card Sales</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['credit_card_sales'], 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-yellow-600">E-Wallet Sales</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['ewallet_sales'], 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-blue-600">Delivery Sales</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['delivery_sales'], 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-blue-600">Total Bank-in</h3>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($monthlyStats['total_bankin'], 2, '.', ',') }}</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-10 transition duration-300 ease-in-out hover:shadow-xl w-full mx-auto text-center">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Quick Actions</h3>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('sales.createEod') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                    Add EOD
                </a>
                <a href="{{ route('sales.createBankin') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                    Add Bank-in
                </a>
                <a href="{{ route('sales.createExpense') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                    Add Expense
                </a>
                <a href="{{ route('sales.createEarning') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                    Add Earning
                </a>
            </div>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Sales History Table -->
        @if ($salesDaily->isNotEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 mb-10 transition duration-300 ease-in-out hover:shadow-xl w-full mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Sales Cash Flow</h3>
                    
                    <!-- Add Filter Form -->
                    <form method="GET" action="{{ route('sales.index') }}" class="flex space-x-4">
                        <div class="relative">
                            <select name="month" class="block appearance-none w-full bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition duration-200">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ (request('month', date('n')) == $month) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5H7z"></path>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                            Apply Filter
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-fixed bg-white rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="w-[12%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Date</th>
                                <th class="w-[12%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">EOD</th>
                                <th class="w-[12%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Bank-in</th>
                                <th class="w-[12%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Expense</th>
                                <th class="w-[12%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Earning</th>
                                <th class="w-[15%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Daily Cash Flow</th>
                                <th class="w-[15%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Cumulative Cash Stream</th>
                                <th class="w-[10%] py-2 px-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesDaily as $daily)
                                @php 
                                    $date = \Carbon\Carbon::parse($daily->date)->format('d-m-Y');
                                    $allZero = $daily->total_eod == 0 && 
                                               $daily->total_bankin == 0 && 
                                               $daily->total_expenses == 0 && 
                                               $daily->total_earning == 0 && 
                                               $daily->total_balance == 0;
                                @endphp
                                
                                @if(!$allZero)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b text-sm text-center">{{ $date }}</td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if($daily->total_eod != 0)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($daily->total_eod, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if($daily->total_bankin != 0)
                                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($daily->total_bankin, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if($daily->total_expenses != 0)
                                                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($daily->total_expenses, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if($daily->total_earning != 0)
                                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($daily->total_earning, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if($daily->total_balance != 0)
                                                @php $dailyCashFlow = $daily->total_balance; @endphp
                                                <span class="inline-block {{ $dailyCashFlow >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($dailyCashFlow, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            @if(isset($dailyCashStreams[$daily->date]))
                                                <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    RM {{ number_format($dailyCashStreams[$daily->date], 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm text-center">
                                            <a href="{{ route('sales.details', ['date' => $daily->date]) }}" 
                                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1 rounded transition duration-300 ease-in-out">
                                               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>
