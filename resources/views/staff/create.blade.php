<x-layout>
    <x-slot:heading>Add New Staff</x-slot:heading>
    
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
            <h2 class="text-2xl font-bold text-white">Add New Staff to BBC078 P15</h2>
            <p class="text-blue-100 mt-2">Complete the new staff's details below</p>
        </div>

        <form method="POST" action="/staff" class="p-6">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <x-form-field>
                        <x-form-label for="name" class="text-gray-700">Full Name</x-form-label>
                        <x-form-input type="text" name="name" id="name" placeholder="Full Name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <x-form-error name='name'></x-form-error>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="nickname" class="text-gray-700">Nickname</x-form-label>
                        <x-form-input type="text" name="nickname" id="nickname" placeholder="Nickname" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <x-form-error name='nickname'></x-form-error>
                    </x-form-field>
                </div>

                <x-form-field>
                    <x-form-label class="text-gray-700">Employment Type</x-form-label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input id="et-option-1" type="radio" name="employment_type" value="full_time" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="et-option-1" class="ml-3 block text-sm font-medium text-gray-700">Full Time</label>
                        </div>
                        <div class="flex items-center">
                            <input id="et-option-2" type="radio" name="employment_type" value="part_time" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="et-option-2" class="ml-3 block text-sm font-medium text-gray-700">Part Time</label>
                        </div>
                    </div>
                    <x-form-error name='employment_type'></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="position" class="text-gray-700">Position</x-form-label>
                    <select id="position" name="position" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="bar">Bar</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="flexible">Bar/Kitchen</option>
                    </select>
                    <x-form-error name='position'></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="rate" class="text-gray-700">Rate (RM/hour)</x-form-label>
                    <x-form-input type="text" name="rate" id="rate" placeholder="7.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    <x-form-error name='rate'></x-form-error>
                </x-form-field>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="/staff" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Cancel</a>
                <x-form-button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</x-form-button>
            </div>
        </form>
    </div>
</x-layout>