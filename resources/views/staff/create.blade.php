<x-layout>
    <x-slot:heading>Add New Staff</x-slot:heading>
    
    <form method="POST" action="/staff">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Add new staff to BBC078 P15</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">complete new staff's details</p>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <x-form-field>
                        <x-form-label for="name">Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="name" id="name" placeholder="Staff's Full Name" required />
                            <x-form-error name='name'></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field class="sm:col-span-4">
                        <x-form-label for="nickname">Nickname</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="nickname" id="nickname" placeholder="Staff's Nickname" required />
                            <x-form-error name='nickname'></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field class="sm:col-span-4">
                        <x-form-label for="employment_type">Employment Type</x-form-label>
                        <div class="mt-2">
                          <fieldset>
                            <div class="flex items-center mb-4">
                              <input id="et-option-1" type="radio" name="employment_type" id= "employment_type" value="full_time" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                              <label for="et-option-1" class="block ms-2  text-sm font-medium text-black-500 dark:text-black-300">
                                Full Time
                              </label>
                            </div>

                            <div class="flex items-center mb-4">
                              <input id="et-option-2" type="radio" name="employment_type" id= "employment_type" value="part_time" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                              <label for="et-option-2" class="block ms-2  text-sm font-medium text-black-500 dark:text-black-300">
                                Part Time
                              </label>
                            </div>

                          </fieldset>
                          <x-form-error name='employment_type'></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field class="sm:col-span-4">
                        <x-form-label for="position">Position</x-form-label>
                        <div class="mt-2">
                        <select id="position" name="position" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5">
                          <option value="bar">Bar</option>
                          <option value="kitchen">Kitchen</option>
                          <option value="flexible">Bar/Kitchen</option>
                        </select>
                          <x-form-error name='position'></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field class="sm:col-span-4">
                        <x-form-label for="rate">Rate (RM/hour)</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="rate" id="rate" placeholder="7.5" />
                            <x-form-error name='rate'></x-form-error>
                        </div>
                    </x-form-field>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="/staff" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-form-button>Save</x-form-button>
            </div>
        </div>
    </form>

</x-layout>