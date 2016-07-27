@foreach ($searchType['timeSlots'] as $timeSlot)
<ul>
    {{$timeSlot->format('Y-m-d')}}
</ul>
@endforeach
