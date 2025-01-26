<x-layout>
    <x-slot:heading>Team Hub</x-slot:heading>
    <x-slot:description>{{ $staff->name }}</x-slot:description>
    
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-green-600 p-6">
            <h2 class="text-2xl font-bold text-white">Member Details</h2>
            <p class="text-blue-100 mt-2">Update {{ $staff->name }}'s information below</p>
        </div>

        <form method="POST" action="/staff/{{ $staff->id }}" class="p-6">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required value="{{ $staff->name }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        @error('name')
                            <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="nickname" class="block text-sm font-medium text-gray-700">Nickname</label>
                        <div class="mt-1">
                            <input id="nickname" name="nickname" type="text" required value="{{ $staff->nickname }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        @error('nickname')
                            <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Employment Type</label>
                    <div class="mt-2 space-y-3">
                        <div class="flex items-center">
                            <input id="et-option-1" type="radio" name="employment_type" value="full_time" class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300" {{ $staff->employment_type === 'full_time' ? 'checked' : '' }}>
                            <label for="et-option-1" class="ml-3 block text-sm font-medium text-gray-700">Full Time</label>
                        </div>
                        <div class="flex items-center">
                            <input id="et-option-2" type="radio" name="employment_type" value="part_time" class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300" {{ $staff->employment_type === 'part_time' ? 'checked' : '' }}>
                            <label for="et-option-2" class="ml-3 block text-sm font-medium text-gray-700">Part Time</label>
                        </div>
                    </div>
                    @error('employment_type')
                        <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <div class="mt-1">
                        <select id="position" name="position" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="bar" {{ $staff->position === 'bar' ? 'selected' : '' }}>Barista</option>
                            <option value="kitchen" {{ $staff->position === 'kitchen' ? 'selected' : '' }}>Kitchen Crew</option>
                            <option value="flexible" {{ $staff->position === 'flexible' ? 'selected' : '' }}>Barista + Kitchen Crew</option>
                        </select>
                    </div>
                    @error('position')
                        <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="rate" class="block text-sm font-medium text-gray-700">Rate (RM/hour)</label>
                    <div class="mt-1">
                        <input id="rate" name="rate" type="text" value="{{ $staff->rate }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <p class="text-gray-500 text-xs pt-1">*Only applicable for Part-Time members</p>
                    @error('rate')
                        <div class="invalid-feedback text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between gap-x-6">
                <button
                    type="submit"
                    form="delete-form"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    onclick="return confirm('Are you sure you want to delete this staff member?');"
                >
                    Delete
                </button>
                <div class="flex items-center gap-x-6">
                    <a href="/staff" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Update</button>
                </div>
            </div>
        </form>
    </div>

    <form method="POST" class="hidden" action="/staff/{{ $staff->id }}" id="delete-form">
        @csrf
        @method('DELETE')
    </form>
</x-layout>