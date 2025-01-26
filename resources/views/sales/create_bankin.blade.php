<x-layout>
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <x-slot name="heading">Sales</x-slot>
    <x-slot name="description">Add Bank-in Transaction</x-slot>

    <div class="w-1/2 bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 mx-auto">
        <form action="{{ route('sales.storeBankin') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date" type="text" name="date" required value="{{ now()->format('d-m-Y') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bank_name">
                    Bank Name
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_name" type="text" name="bank_name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="time">
                    Time
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="time" type="time" name="time" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                    Amount (RM)
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="amount" type="number" step="0.01" name="amount" required>
            </div>
            <div class="flex items-center justify-end pt-5">
                <a href="{{ route('sales.index') }}" class="text-gray-800 hover:text-green-600 font-medium pr-8">Cancel</a>
                <button class="bg-gray-800 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline" type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('date');
            var datePicker = new Pikaday({
                field: dateInput,
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                onSelect: function(date) {
                    // Format the date as DD-MM-YYYY
                    var day = String(date.getDate()).padStart(2, '0');
                    var month = String(date.getMonth() + 1).padStart(2, '0');
                    var year = date.getFullYear();
                    dateInput.value = day + '-' + month + '-' + year;
                }
            });

            // Prevent manual input
            dateInput.readOnly = true;
        });
    </script>
</x-layout>