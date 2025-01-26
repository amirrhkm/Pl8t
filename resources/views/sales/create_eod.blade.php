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

    <x-slot name="heading">Sales</x-slot>
    <x-slot name="description">Add Daily EOD Sales</x-slot>

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
        <form action="{{ route('sales.storeEod') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date
                </label>
                <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date" type="text" name="date" required value="{{ now()->format('d-m-Y') }}">
            </div>
            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="debit">
                        Debit
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="debit" type="number" step="0.01" name="debit">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="visa">
                        Visa
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="visa" type="number" step="0.01" name="visa">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="master">
                        Master
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="master" type="number" step="0.01" name="master">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cash">
                        Cash
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cash" type="number" step="0.01" name="cash" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ewallet">
                        E-Wallet
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ewallet" type="number" step="0.01" name="ewallet" required>
                </div>
            </div>
            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foodpanda">
                        Foodpanda
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="foodpanda" type="number" step="0.01" name="foodpanda">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="grabfood">
                        Grabfood
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="grabfood" type="number" step="0.01" name="grabfood">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="shopeefood">
                        Shopeefood
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="shopeefood" type="number" step="0.01" name="shopeefood">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="prepaid">
                        Prepaid
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="prepaid" type="number" step="0.01" name="prepaid">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="voucher">
                        Voucher
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="voucher" type="number" step="0.01" name="voucher">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="total_sales">
                        Total Sales
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total_sales" type="number" step="0.01" name="total_sales" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cash_difference">
                        Cash Difference
                    </label>
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cash_difference" type="number" step="0.01" name="cash_difference" placeholder="E.g. -0.50" required>
                </div>
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Expenses
            </label>
            <div id="expenses-container">
                <div class="expense-item grid grid-cols-2 gap-4 mb-2">
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="expenses_1" placeholder="Expense 1">
                    <div class="flex">
                        <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" name="amount_1" placeholder="Amount 1">
                    </div>
                </div>
            </div>
            <button type="button" id="add-expense" class="mt-2 bg-gray-800 hover:bg-green-600 text-xs text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                +
            </button>
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

            const addExpenseButton = document.getElementById('add-expense');
            const expensesContainer = document.getElementById('expenses-container');
            let expenseCount = 1;

            function updateExpenseNumbers() {
                const expenseItems = expensesContainer.querySelectorAll('.expense-item');
                expenseItems.forEach((item, index) => {
                    const expenseInput = item.querySelector('input[type="text"]');
                    const amountInput = item.querySelector('input[type="number"]');
                    const newIndex = index + 1;
                
                    expenseInput.name = `expenses_${newIndex}`;
                    expenseInput.placeholder = `Expense ${newIndex}`;
                    amountInput.name = `amount_${newIndex}`;
                    amountInput.placeholder = `Amount ${newIndex}`;
                });
                expenseCount = expenseItems.length;
            }

            function updateRemoveButtons() {
                const removeButtons = expensesContainer.querySelectorAll('.remove-expense');
                removeButtons.forEach(button => {
                    button.disabled = expensesContainer.children.length === 1;
                });
            }

            addExpenseButton.addEventListener('click', function() {
                expenseCount++;
                const expenseDiv = document.createElement('div');
                expenseDiv.classList.add('expense-item', 'grid', 'grid-cols-2', 'gap-4', 'mb-2');
                expenseDiv.innerHTML = `
                    <input class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="expenses_${expenseCount}" placeholder="Expense ${expenseCount}">
                    <div class="flex">
                        <input class="shadow appearance-none border rounded-l-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" name="amount_${expenseCount}" placeholder="Amount ${expenseCount}">
                        <button type="button" class="remove-expense bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-r-lg focus:outline-none focus:shadow-outline">
                            -
                        </button>
                    </div>
                `;
                expensesContainer.appendChild(expenseDiv);
                updateRemoveButtons();
            });

            expensesContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-expense')) {
                    e.target.closest('.expense-item').remove();
                    updateExpenseNumbers();
                    updateRemoveButtons();
                }
            });

            updateRemoveButtons();
        });
    </script>
</x-layout>