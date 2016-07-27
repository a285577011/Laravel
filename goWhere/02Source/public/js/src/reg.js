/**
 * Created by zds on 2016/6/17.
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

  /* 手机注册获取验证码 */
  $(".get-phone-code").click(function() {
    var $this = $(this);
    var phone = $this.closest("form").find("input[name='phone']").val(),
        captcha = $this.closest("form").find("input[name='captcha']").val();
    $.post(owAPI.getNewPhoneSMS,
      {
        phone: phone,
        captcha: captcha
      },
      function ( res ) {
        if( res.error ) {
          if(res.redirect !== "") {
            layer.msg(res.msg);
            $(".get-captcha").trigger("click");
          }
        } else {
          var setTime = res.data.smsInterval;
          $this.addClass("invalid").text("重新发送(" + setTime + ")");
          var interval = setInterval(function() {
            setTime--;
            if(setTime === 0) {
              $this.removeClass("invalid").text("获取验证码");
              clearInterval(interval);
            } else {
              $this.addClass("invalid").text("重新发送(" + setTime + ")");
            }
          },1000);
        }
      }
    )
  });

  /* 手机注册 */
  $(".j-reg-phone").click(function() {
    var $this = $(this);
    var flag = 1;
    $this.closest("form").find("input").each(function () {
      if($(this).attr("name") !== "_token") {
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

  /* 邮箱注册 */
  $(".j-reg-email").click(function() {
    var $this = $(this);
    var $form = $this.closest("form");
    var email = $form.find("input[name='email']").val(),
      username = $form.find("input[name='username']").val(),
      password = $form.find("input[name='password']").val(),
      password_confirmation = $this.closest("form").find("input[name='password_confirmation']").val(),
      captcha = $this.closest("form").find("input[name='captcha']").val();

    var flag = 1;
    $this.closest("form").find("input").each(function () {
      formVerify($(this));
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if( flag ) {
      $.post(owAPI.regEmail,
        {
          email: email,
          username: username,
          password: password,
          password_confirmation: password_confirmation,
          captcha: captcha
        },
        function( res ) {
          if( res.error ) {

          } else {
            $(".new-email").text(email);
            $(".go-email").attr("href",res.data.url);
            $form.addClass("hide").siblings(".reg-email-msg").removeClass("hide");
          }
        }
      )
    }
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