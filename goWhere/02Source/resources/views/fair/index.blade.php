@foreach ($services as $service)
<ul>
    {{$service->name}}
    @foreach ($service->subService as $subService)
    <li>{{$subService->name}}</li>
    @endforeach
</ul>
@endforeach
