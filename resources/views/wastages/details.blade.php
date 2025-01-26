<x-layout>
    <x-slot:heading>
        Wastages
    </x-slot:heading>
    <x-slot:description>
        {{ $month }}-{{ $year }}
    </x-slot:description>

    <div class="p-2 flex justify-center">
        <div class="w-full overflow-x-auto rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider text-center">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider text-center">Item</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider text-center">Quantity/Weight</th>
                        <th class="px-2 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider text-center"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($wastages->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center">
                                <p class="text-gray-500 italic">No wastages recorded for this month.</p>
                            </td>
                        </tr>
                    @else
                        @foreach($wastages as $wastage)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-medium font-medium text-gray-900 text-center">
                                    {{ $wastage->date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium font-medium text-gray-900 text-center">
                                    {{ $wastage->item }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium font-medium text-gray-900 text-center">
                                    @if($wastage->weight)
                                        {{ number_format($wastage->weight, 3) }} kg
                                    @else
                                        {{ $wastage->quantity }} pcs
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-medium font-medium text-gray-900 text-center">
                                    <a href="{{ route('wastages.edit', $wastage) }}" class="text-gray-800 hover:text-green-600 mr-3 inline-flex items-center">
                                        Edit
                                    </a>
                                    <form action="{{ route('wastages.destroy', $wastage) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center" onclick="return confirm('Are you sure you want to delete this wastage?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-2 flex justify-center">
        <a href="{{ route('invoices.index') }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md hover:shadow-lg text-center text-sm">
            Back to Invoices
        </a>
    </div>
</x-layout>
