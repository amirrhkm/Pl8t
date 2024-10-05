<x-layout>
    <x-slot:heading>Staff List</x-slot:heading>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Nickname</th>
                    <th class="py-2 px-4 border-b text-left">Employment Type</th>
                    <th class="py-2 px-4 border-b text-left">Position</th>
                    <th class="py-2 px-4 border-b text-left">Rate (RM)</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $member)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->nickname }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->formattedEmploymentType() }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->formattedPosition() }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->rate }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex space-x-2">
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
</x-layout>
