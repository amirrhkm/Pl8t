<x-layout>
    <x-slot:heading>Staff List</x-slot:heading>
    
    <h2 class="text-xl font-bold mb-4">Full-Time Staff</h2>
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Nickname</th>
                    <th class="py-2 px-4 border-b text-left">Position</th>
                    <th class="py-2 px-4 border-b text-left"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs->where('employment_type', 'full_time') as $member)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->nickname }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->formattedPosition() }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex justify-end space-x-2">
                              
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

    <h2 class="text-xl font-bold mb-4">Part-Time Staff</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Nickname</th>
                    <th class="py-2 px-4 border-b text-left">Position</th>
                    <th class="py-2 px-4 border-b text-left">Rate (RM)</th>
                    <th class="py-2 px-4 border-b text-left"></th>
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
