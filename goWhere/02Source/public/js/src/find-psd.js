/**
 * Created by zds on 2016/6/22.
 */
(function() {

  /* 表单验证 */
  $(document).on("blur", "form .form-group input", function(){
    formVerify($(this));
  });

  /* 更新条形验证码 */
  $(".get-captcha").click(function() {
    var $this = $(this);
    var _src = $this.attr("src");
    $this.attr("src", _src + parseInt(Math.random()*10));
  });

  /* 提交 */
  $(".find-psd").click(function() {
    var $this = $(this);
    var flag = 1;
    $this.closest("form").find("input").each(function () {
       var $this = $(this);
      if($this.attr("name") === "_token" || $this.hasClass("no-valid")) {

      } else {
        formVerify($(this));
        if ($(this).hasClass("has-error")) {
          flag = 0;
        }
      }
    });
    if( flag ) {
      $(this).closest("form").submit();
    }
  });


  /* 获取手机验证码 */
  $(".get-phone-code").click(function() {
    var $this = $(this);
    var flag = 1;
    var phone = $("input[name='phone']").val(),
      captcha = $("input[name='captcha']").val();
    $.post(owAPI.getNewPhoneSMS,
      {
        phone: phone,
        captcha: captcha
      },
      function ( res ) {
        if( res.error ) {
          if( res.redirect ) {
            layer.msg(res.msg);
            $(".phone-step2-captcha").trigger("click").siblings("input").val("").focus();
          }
        } else {
          var setTime = res.data.smsInterval;
          getSMS($this,setTime);
        }
      }
    )
  });

  var formVerify = function(obj) {
    var $this = obj;
    var value = $this.val();
    var dataType = $this.attr("datatype");
    var errorMsg = $this.attr("errormsg");
    var nullMsg = $this.attr("nullmsg");

    if ($.trim(value) === "") {
      $this.siblings(".verify-tip").text(nullMsg);
      $this.removeClass("has-success").addClass("has-error");
    } else {
      if (!regs.dataType[dataType].test($.trim(value))) {
        $this.siblings(".verify-tip").text(errorMsg);
        $this.removeClass("has-success").addClass("has-error");
      } else {
        $this.addClass("has-success").removeClass("has-error");
        $this.siblings(".verify-tip").text("");
        if($this.attr("name") === "password_confirmation") {
          var fPsd = $this.closest("form").find("input[name='password']").val();
          var sPsd = $this.val();
          if(fPsd === sPsd) {
            $this.siblings(".verify-tip").text("");
          } else {
            $this.siblings(".verify-tip").text($this.attr("psdWrong"));
          }
        }
      }
    }
  };

})();