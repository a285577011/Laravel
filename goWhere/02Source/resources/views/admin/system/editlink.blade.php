<form method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <p>网站名称：<input type="text" name="title" value="{{$link->title or ''}}"/></p>
    <p>网站链接：<input type="text" name="url" value="{{$link->url or ''}}"/></p>
    <p>
        LOGO：
        @if($link->logo)
        <img width="100" height="50" src="@storageAsset($link->logo)" /><br/>
        @endif
        <input type="radio" name="logoType" value="logo_text" checked onclick="switchFileInput(this);" autocomplete="off"/>填写地址
        <input type="radio" name="logoType" value="logo" onclick="switchFileInput(this);" autocomplete="off"/>上传文件<br/>
        <input type="text" id="logo_text" name="logo_text" value="{{$link->logo}}" />
        <input type="file" id="logo" name="logo" style="display: none;"/>
    </p>
    <p>显示：<input type="radio" value="1" {{$link->valid ? 'checked' : ''}} name="valid"/>显示  <input type="radio" value="0" {{!$link->valid ? 'checked' : ''}} name="valid"/>不显示</p>
    <input type="submit" value="提交" />
</form>
<script type="text/javascript">
    function switchFileInput(obj) {
        var inputs = obj.parentNode.getElementsByTagName('input');
        for(x in inputs) {
            console.log(inputs[x]);
            console.log(obj);
            if (inputs[x].id == obj.value){
                inputs[x].style = '';
            }
            else if(inputs[x].type!='radio'){
                inputs[x].style = 'display:none';
            }
        }
    }
</script>
@if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif