@section('success')
@if(session()->get('message'))
<div id="alertSucBox" class="alert alert-block alert-success">
    <button data-dismiss="alert" class="close" type="button">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <strong>
        <i class="ace-icon fa fa-check"></i>
    </strong>
    {!!session()->get('message')!!}
</div>
@endif
@show
@if($errors->any())
<div id="alertErrBox" class="alert alert-danger">
    <button data-dismiss="alert" class="close" type="button">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <strong>
        <i class="ace-icon fa fa-times"></i>
    </strong>
    @foreach($errors->all() as $error)
        {!! $error !!}
    @endforeach
</div>
@endif