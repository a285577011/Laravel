<form method="post" action="">
    {!! csrf_field() !!}
    permission name: <input type="text" name="name" />
    display name: <input type="text" name="display_name" />
    description: <input type="text" name="description" />
    <input type="submit" value="添加" />
</form>
@if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif