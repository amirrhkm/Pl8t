<x-layout>
    <x-slot:heading>
        Inventory
    </x-slot:heading>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">DO Invoices Overview</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">Total Stock Orders</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $totalInvoices }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-green-600">Delivery Received</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $receivedInvoices }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-orange-600">Delivery Pending</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $pendingInvoices }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold mb-2 text-red-600">Delivery Overdue</h3>
                <p class="text-6xl font-bold text-gray-800">{{ $overdueInvoices }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-indigo-800">Total Spent in Stock Orders</h3>
                    <p class="text-4xl font-bold text-gray-800">RM {{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-indigo-800">Total Wastages in {{ now()->monthName }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('wastages.create') }}" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('wastages.details', ['year' => now()->year, 'month' => now()->month]) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <ul class="space-y-2 min-h-[120px]"> <!-- Added min-height -->
                        @forelse($wastages as $item => $totals)
                            <li class="flex items-center justify-between">
                                <span class="text-gray-800">{{ $item }}</span>
                                <span class="text-gray-800">
                                    @if(isset($totals['total_weight']))
                                        @if($totals['total_weight'] > 0)    
                                            {{ number_format($totals['total_weight'], 3) }} kg
                                        @endif
                                    @endif
                                    @if(isset($totals['total_quantity']))
                                        @if($totals['total_quantity'] > 0)
                                            {{ $totals['total_quantity'] }} pcs
                                        @endif
                                    @endif
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-500 italic">No wastage recorded for this month.</li>
                        @endforelse
                        @for ($i = count($wastages); $i < 4; $i++)
                            <li class="flex items-center justify-between">
                                <span class="text-gray-300"></span>
                                <span class="text-gray-300"></span>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Delivery On-Time Rates</h3>
                <ul class="space-y-2">
                @inject('invoiceController', 'App\Http\Controllers\InvoiceController')
                    @foreach($deliveryRates as $type => $rate)
                        <li class="flex items-center justify-between">
                            <span class="text-gray-800">{{ $invoiceController->formatType($type) }}</span>
                            <span class="text-indigo-600 font-medium">{{ $rate }}%</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="mb-6">
            <form method="GET" action="{{ route('invoices.index') }}" class="flex items-center justify-between">
                <div class="flex space-x-4">
                <div class="relative">
                    <select name="month" class="block appearance-none w-full bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition duration-200">
                        <option value="" class="text-gray-500 italic">All Months</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
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
                    <div class="relative">
                        <select name="type" class="block appearance-none w-full bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition duration-200">
                            <option value="" class="text-gray-500 italic">All Delivery</option>
                            <option value="vtc" {{ request('type') == 'vtc' ? 'selected' : '' }}>VTC</option>
                            <option value="ambient" {{ request('type') == 'ambient' ? 'selected' : '' }}>Ambient</option>
                            <option value="fuji_loaf" {{ request('type') == 'fuji_loaf' ? 'selected' : '' }}>Fuji Loaf</option>
                            <option value="frozen" {{ request('type') == 'frozen' ? 'selected' : '' }}>Frozen</option>
                            <option value="mcqwin" {{ request('type') == 'mcqwin' ? 'selected' : '' }}>MCQWIN</option>
                            <option value="soda_express" {{ request('type') == 'soda_express' ? 'selected' : '' }}>Soda Express</option>
                            <option value="small_utilities" {{ request('type') == 'small_utilities' ? 'selected' : '' }}>Small Utilities</option>
                            <option value="mc2_water_filter" {{ request('type') == 'mc2_water_filter' ? 'selected' : '' }}>MC2 Water Filter</option>
                            <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5H7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <select name="status" class="block appearance-none w-full bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition duration-200">
                            <option value="" class="text-gray-500 italic">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="received_late" {{ request('status') == 'received_late' ? 'selected' : '' }}>Received Late</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5H7z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">Apply Filter</button>
                </div>
                <a href="{{ route('invoices.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
                    Create New Invoice
                </a>
            </form>
        </div>
        <!-- End of Filter Section -->

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">DO ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Submit Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Receive Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $invoice->do_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $invoice->submit_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $invoice->receive_date ? $invoice->receive_date->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">RM {{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $invoice->formattedType() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->status === 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $invoice->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $invoice->status === 'received' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $invoice->status === 'received_late' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $invoice->status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                            </span>
                                @if($invoice->remarks)
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Remark
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center">
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No deliveries yet for {{ now()->format('F Y') }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
