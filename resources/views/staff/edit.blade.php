<x-layout>
    <x-slot:heading>
        Edit Staff: {{ $staff->name }}
    </x-slot:heading>

    <form method="POST" action="/staff/{{ $staff->id }}">
        @csrf
        @method('PATCH')

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <x-form-field>
                        <x-form-label for="name">Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input  type="text" name="name" id="name" value="{{ $staff->name }}" required />
                            <x-form-error name='name'></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="name">Nickname</x-form-label>
                        <div class="mt-2">
                            <x-form-input  type="text" name="nickname" id="nickname" value="{{ $staff->nickname }}" required />
                            <x-form-error name='name'></x-form-error>
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
                          <select id="position" name="position" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <x-form-input type="text" name="rate" value="{{ $staff->rate }}" id="rate" placeholder="7.5" />
                            <x-form-error name='rate'></x-form-error>
                        </div>
                    </x-form-field>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between gap-x-6">
                <div class="flex items-center">
                    <button
                        type="submit"
                        form="delete-form"
                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Delete
                    </button>
                </div>

                <div class="flex items-center gap-x-6">
                    <a href="/staff" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <div>
                        <x-form-button>Update</x-form-button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" class="hidden" action="/staff/{{ $staff->id }}" id="delete-form">
        @csrf
        @method('DELETE')
    </form>

</x-layout>