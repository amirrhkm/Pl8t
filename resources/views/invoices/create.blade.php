<x-layout>
    <x-slot name="heading">Create New Invoice</x-slot>
    <x-slot name="description">Enter the details for the new invoice</x-slot>

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
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="do_id">
                    Delivery Order ID
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="do_id" type="number" name="do_id" required>
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="submit_date">
                        Submit Date
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="submit_date" type="text" name="submit_date" required>
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="receive_date">
                        Receive Date
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="receive_date" type="text" name="receive_date">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="total_amount">
                    Amount (RM)
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total_amount" type="number" step="0.01" name="total_amount" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                    Delivery Type
                </label>
                <select class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                    <option value="">Select Delivery Type</option>
                    <option value="ambient">Ambient</option>
                    <option value="frozen">Frozen</option>
                    <option value="fuji_loaf">Fuji Loaf</option>
                    <option value="vtc">VTC</option>
                    <option value="mcqwin">MCQWIN</option>
                    <option value="small_utilities">Small Utilities</option>
                    <option value="soda_express">Soda Express</option>
                    <option value="mc2_water_filter">MC2 Water Filter</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="remarks">
                    Remarks
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="remarks" type="text" name="remarks">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <div class="flex space-x-2">
                    <button type="button" class="status-button bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg focus:outline-none" data-status="pending">Pending</button>
                    <button type="button" class="status-button bg-green-500 text-white font-bold py-2 px-4 rounded-lg focus:outline-none" data-status="received">Received</button>
                    <button type="button" class="status-button bg-red-500 text-white font-bold py-2 px-4 rounded-lg focus:outline-none" data-status="overdue">Overdue</button>
                </div>
                <input type="hidden" name="status" id="status" required>
            </div>
            <div class="flex justify-end">
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline" type="submit">
                    Create Invoice
                </button>
            </div>
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
