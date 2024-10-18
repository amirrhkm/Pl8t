<x-layout>
    <x-slot:heading>Team Hub</x-slot:heading>
    
    <div class="bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-xl shadow-lg max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-indigo-800">Staff Overview</h2>
            <a href="{{ route('staff.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                Create New Staff
            </a>
        </div>

        <div class="space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Full-Time Members</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">Name</th>
                                <th class="py-2 px-4 text-center">Nickname</th>
                                <th class="py-2 px-4 text-center">Position</th>
                                <th class="py-2 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs->where('employment_type', 'full_time') as $member)
                                @if ($member->name !== "admin")
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $member->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $member->nickname }}</td>
                                    <td class="py-2 px-4 text-center">{{ $member->formattedPosition() }}</td>
                                    <td class="py-2 px-4">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('staff.wildcard', $member->id) }}" class="text-green-600 hover:text-green-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('staff.edit', $member->id) }}" class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-800">Part-Time Members</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">Name</th>
                                <th class="py-2 px-4 text-center">Nickname</th>
                                <th class="py-2 px-4 text-center">Position</th>
                                <th class="py-2 px-4 text-center">Rate (RM)</th>
                                <th class="py-2 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs->where('employment_type', 'part_time') as $member)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $member->name }}</td>
                                <td class="py-2 px-4 text-center">{{ $member->nickname }}</td>
                                <td class="py-2 px-4 text-center">{{ $member->formattedPosition() }}</td>
                                <td class="py-2 px-4 text-center">{{ $member->rate }}</td>
                                <td class="py-2 px-4">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('staff.wildcard', $member->id) }}" class="text-green-600 hover:text-green-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('staff.edit', $member->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>