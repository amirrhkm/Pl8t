<x-layout>
    <style>
        /* Remove spinner for WebKit browsers (Chrome, Safari) */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Remove spinner for Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <x-slot name="heading">Inventory</x-slot>
    <x-slot name="description">DO Invoice #{{ $invoice->do_id }}</x-slot>

    <div class="w-1/2 bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 mx-auto ">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('invoices.update', $invoice) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="do_id">
                    Delivery Order ID
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="do_id" type="number" name="do_id" value="{{ $invoice->do_id }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                    Delivery Type
                </label>
                <select class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                    <option value="">Select Delivery Type</option>
                    @foreach(['ambient', 'frozen', 'fuji_loaf', 'vtc', 'mcqwin', 'small_utilities', 'soda_express', 'mc2_water_filter', 'other'] as $type)
                        <option value="{{ $type }}" {{ $invoice->type === $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="submit_date">
                        Submit Date
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="submit_date" type="text" name="submit_date" value="{{ $invoice->submit_date->format('d-m-Y') }}" required>
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="receive_date">
                        Receive Date
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="receive_date" type="text" name="receive_date" value="{{ $invoice->receive_date ? $invoice->receive_date->format('d-m-Y') : '' }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="total_amount">
                    Amount (RM)
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total_amount" type="number" step="0.01" name="total_amount" value="{{ $invoice->total_amount }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="remarks">
                    Remarks
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="remarks" type="text" name="remarks" value="{{ $invoice->remarks }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['pending', 'received', 'overdue', 'received_late', 'cancelled'] as $status)
                        <button type="button" 
                            class="status-button {{ $invoice->status === $status ? 'ring-2 ring-opacity-50' : '' }} 
                                {{ $status === 'pending' ? 'bg-yellow-400 hover:bg-yellow-500 text-gray-800' : 
                                ($status === 'received' ? 'bg-green-400 hover:bg-green-500 text-white' : 
                                ($status === 'cancelled' ? 'bg-gray-400 hover:bg-gray-500 text-white' : 
                                    'bg-red-400 hover:bg-red-500 text-white')) }} 
                                font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out shadow-sm" 
                            data-status="{{ $status }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="status" id="status" value="{{ $invoice->status }}" required>
            </div>
            <div class="flex justify-between">
                <button type="button" class="text-red-600 hover:text-red-800" onclick="if(confirm('Are you sure you want to delete this DO Invoice?')) document.getElementById('delete-form').submit();">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline" type="submit">
                    Update Invoice
                </button>
            </div>
        </form>
        <form id="delete-form" action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var submitDatePicker = new Pikaday({
                field: document.getElementById('submit_date'),
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                container: document.getElementById('submit_date').parentNode
            });

            var receiveDatePicker = new Pikaday({
                field: document.getElementById('receive_date'),
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                container: document.getElementById('receive_date').parentNode
            });

            const statusButtons = document.querySelectorAll('.status-button');
            const statusInput = document.getElementById('status');

            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    statusButtons.forEach(btn => btn.classList.remove('ring-2', 'ring-opacity-50'));
                    this.classList.add('ring-2', 'ring-opacity-50');
                    statusInput.value = this.getAttribute('data-status');
                });
            });
        });
    </script>
</x-layout>