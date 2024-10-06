<x-layout>
    <x-slot:heading>Staff details</x-slot:heading>
    
    <h2 class="font-bold text-lg">{{ $staff->name }} ({{ $staff->nickname }})</h2>
    <p>Employment Type: 
        @if($staff->employment_type === 'full_time')
            Full time
        @elseif($staff->employment_type === 'part_time')
            Part time
        @else
            {{ $staff->employment_type }}
        @endif
    </p>
    <p>Position: 
        @if($staff->position === 'bar')
            Bar
        @elseif($staff->position === 'kitchen')
            Kitchen
        @elseif($staff->position === "flexible")
            Bar/Kitchen
        @endif
    </p>
    <p>Rate: RM {{ $staff->rate }}0 per hour</p>

    <p class="mt-10">
        <x-button href="/staff/{{ $staff->id }}/edit">Edit</x-button>
    </p>  
      
</x-layout>