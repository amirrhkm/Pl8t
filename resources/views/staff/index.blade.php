<x-layout>
    <x-slot:heading>Staff List</x-slot:heading>
    
    <h2 class="text-xl font-bold mb-4 text-white">Full-Time Staff</h2>
    <div class="overflow-x-auto mb-8 rounded-lg shadow">
        <table class="min-w-full bg-white rounded-lg">
            <thead class="bg-gray-100 rounded-t-lg">
                <tr>
                    <th class="py-2 px-4 border-b text-left rounded-tl-lg">Name</th>
                    <th class="py-2 px-4 border-b text-left">Nickname</th>
                    <th class="py-2 px-4 border-b text-left">Position</th>
                    <th class="py-2 px-4 border-b text-left rounded-tr-lg"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs->where('employment_type', 'full_time') as $member)
                    @if ($member->name !== "admin")
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->nickname }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->formattedPosition() }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('staff.wildcard', $member->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    View Shifts
                                </a>
                                <a href="{{ route('staff.edit', $member->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('staff.destroy', $member->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        Delete
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

    <h2 class="text-xl font-bold mb-4 text-white">Part-Time Staff</h2>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white rounded-lg">
            <thead class="bg-gray-100 rounded-t-lg">
                <tr>
                    <th class="py-2 px-4 border-b text-left rounded-tl-lg">Name</th>
                    <th class="py-2 px-4 border-b text-left">Nickname</th>
                    <th class="py-2 px-4 border-b text-left">Position</th>
                    <th class="py-2 px-4 border-b text-left">Rate (RM)</th>
                    <th class="py-2 px-4 border-b text-left rounded-tr-lg"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs->where('employment_type', 'part_time') as $member)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->nickname }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->formattedPosition() }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->rate }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('staff.wildcard', $member->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    View Shifts
                                </a>
                                <a href="{{ route('staff.edit', $member->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('staff.destroy', $member->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center">
        <a href="{{ route('staff.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Create New Staff
        </a>
    </div>
</x-layout>