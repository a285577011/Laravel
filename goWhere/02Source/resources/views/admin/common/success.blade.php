

    <div class="" style="padding:300px 100px 0 100px;height: 650px;">

<div class="text-center " style="margin: 0 auto; ">



<div class="alert alert-success with-icon">
        <i class="icon-ok-sign"></i>
        <div class="content">

<p class="font">{{$message}}</p>


</div>

</div>


    <p class="jump">
        页面自动 <a id="href" style="color: green" href="javascript:history.back(-1);">跳转</a> 等待时间： <b id="wait">3</b>。
    </p>


    </div>

    </div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
