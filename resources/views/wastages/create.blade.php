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
    <x-slot name="description">Create New Wastage Record</x-slot>

    <div class="w-1/2 bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('wastages.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date" type="text" name="date" value="{{ now()->format('d-m-Y') }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="item">
                    Item
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="item" type="text" name="item" required>
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                        Quantity (pcs)
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="quantity" type="number" name="quantity">
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">
                        Weight (kg)
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="weight" type="number" step="0.001" name="weight">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                    Reason
                </label>
                <textarea class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="reason" name="reason" rows="3"></textarea>
            </div>
            <div class="flex justify-end">
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline" type="submit">
                    Create Wastage Record
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var datePicker = new Pikaday({
                field: document.getElementById('date'),
                format: 'DD-MM-YYYY',
                yearRange: [2000, 2030],
                showTime: false,
                autoClose: false,
                container: document.getElementById('date').parentNode
            });
        });
    </script>
</x-layout>