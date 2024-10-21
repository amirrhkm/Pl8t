<x-layout>
    <x-slot name="heading">Create New Invoice</x-slot>
    <x-slot name="description">Enter the details for the new invoice</x-slot>

    <div class="w-1/2 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mx-auto">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="do_id">
                    Delivery Order ID
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="do_id" type="number" name="do_id" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="submit_date">
                    Submit Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="submit_date" type="text" name="submit_date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="receive_date">
                    Receive Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="receive_date" type="text" name="receive_date">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="total_amount">
                    Total Amount
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total_amount" type="number" step="0.01" name="total_amount" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                    Delivery Type
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                    <option value="">Select Delivery Type</option>
                    <option value="fuji_bun">Fuji Bun</option>
                    <option value="fuji_loaf">Fuji Loaf</option>
                    <option value="vtc">VTC</option>
                    <option value="daq">DAQ</option>
                    <option value="agl">AGL</option>
                    <option value="soda_express">Soda Express</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="pending">Pending</option>
                    <option value="received">Received</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
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
        });
    </script>
</x-layout>