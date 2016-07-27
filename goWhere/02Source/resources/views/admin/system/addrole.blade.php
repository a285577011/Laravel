<form method="post" action="">
    {!! csrf_field() !!}
    name: <input type="text" name="name" value="{{$role->name or ''}}"/>
    display name: <input type="text" name="display_name" value="{{$role->display_name or ''}}"/>
    description: <input type="text" name="description" value="{{$role->description or ''}}"/>
    <input type="submit" value="提交" />
</form>
@if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif