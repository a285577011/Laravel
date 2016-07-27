/**
 * Created by zds on 2016/6/15.
 */
(function() {

  $(document).on("blur", ".form-group input", function(){
    formVerify($(this));
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

  /* 修改头像 */
  $(".change-avatar").click(function() {
    $(this).siblings(".pa-file").trigger("click");
  });
  $(".pa-file").change(function(){
    var fileImg = $(".pa-img");
    var explorer = navigator.userAgent;
    var imgSrc = $(this)[0].value;
    if (explorer.indexOf('MSIE') >= 0) {
      if (!/\.(jpg|jpeg|png|gif|JPG|PNG|JPEG)$/.test(imgSrc)) {
        imgSrc = "";
        fileImg.attr("src","/img/default.png");
        return false;
      }else{
        fileImg.attr("src",imgSrc);
      }
    }else{
      if (!/\.(jpg|jpeg|png|gif|JPG|PNG|JPEG)$/.test(imgSrc)) {
        imgSrc = "";
        fileImg.attr("src","/img/default.png");
        return false;
      }else{
        var file = $(this)[0].files[0];
        var url = URL.createObjectURL(file);
        fileImg.attr("src",url);
      }
    }
  });


/* 修改头像等信息 */

  $(".pi-modify-ok").click(function() {
    $(this).closest("form").submit();
  });


/* 修改密码 */
  $(".j-change-psd").click(function() {
    var $this = $(this);
    var flag = 1;
    var old_password = $("input[name='oldPsd']").val(),
      password = $("input[name='password']").val(),
      password_confirmation = $("input[name='password_confirmation']").val();

    $this.closest("form").find("input").each(function () {
      formVerify($(this));
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if(flag) {
      $.post(owAPI.changePsd,
        {
          old_password:old_password,
          password:password,
          password_confirmation:password_confirmation
        },
        function ( res ) {
          if( res.error ) {
            layer.msg(res.msg);
          } else {
            var set_status = res.data.status,
              psd_level = res.data.text;
            if(set_status) {
              $this.closest(".m-modify").siblings(".set-status").find(".c-success").removeClass("hide").siblings("i").addClass("hide");
              $(".psd-level").text(psd_level);
            } else {
              $this.closest(".m-modify").siblings(".set-status").find(".c-fail").removeClass("hide").siblings("i").addClass("hide");
            }
            $this.closest(".m-modify").addClass("hide").siblings(".modify-btn").removeClass("hide");
          }
        }
      )
    }
  });

  /* 修改邮箱 */
  $(".j-change-email").click(function() {
    var $this = $(this);
    var flag = 1;
    var email = $("input[name='newEmail']").val(),
      old_password = $("input[name='emailPsd']").val();

    $this.closest("form").find("input").each(function () {
      formVerify($(this));
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if(flag) {
      $.post(owAPI.changeEmail,
        {
          email:email,
          old_password:old_password
        },
        function ( res ) {
          if( res.error ) {
            $this.closest(".m-modify").siblings(".set-status").find(".c-fail").removeClass("hide").siblings("i").addClass("hide");
            layer.msg(res.msg);
          } else {
            var set_status = res.data.status,
                cur_email = res.data.email,
                email_text = res.data.text;
            if(set_status) {
              $this.closest(".m-modify").siblings(".set-status").find(".c-success").removeClass("hide").siblings("i").addClass("hide");
            } else {
              $this.closest(".m-modify").siblings(".set-status").find(".c-fail").removeClass("hide").siblings("i").addClass("hide");
            }
            $(".cur-email").text(cur_email);
            $(".email-text").text(email_text);
            $this.closest(".m-modify").addClass("hide").siblings(".modify-btn").removeClass("hide");
          }
        }
      )
    }
  });

  /* 获取旧手机验证码 */
  $(".phone-verify1").click(function() {
    var $this = $(this);
    var user = $this.attr("data-val");
    if($this.hasClass("invalid")) {
      return false;
    } else{
      $.post(owAPI.getOldPhoneSMS,
        {
          user:user
        },
        function ( res ) {
          var setTime = res.data.smsInterval;
          getSMS($this,setTime);
        }
      )
    }
  });

  /* 获取新手机验证码 */
  $(".phone-verify2").click(function() {
    var $this = $(this);
    var flag = 1;
    var phone = $("input[name='newPhone']").val(),
      captcha = $("input[name='newPhoneCaptcha']").val();
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

  /* 修改手机1 */
  $(".j-change-phone1").click(function() {
    var $this = $(this);
    var flag = 1;
    var smsCaptcha = $("input[name='psc1']").val();

    $this.closest("form").find("input").each(function () {
      formVerify($(this));
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if(flag) {
      $.post(owAPI.changeOldPhone,
        {
          smsCaptcha:smsCaptcha
        },
        function ( res ) {
          if( res.error ) {
            $this.closest(".m-modify").siblings(".set-status").find(".c-fail").removeClass("hide").siblings("i").addClass("hide");
          } else {
            $this.closest(".m-modify").addClass("hide").siblings(".cp-step2").removeClass("hide");
          }
        }
      )
    }
  });

  $(".phone-step2-captcha").click(function() {
    var $this = $(this);
    var _src = $this.attr("src");
    $this.attr("src", _src + parseInt(Math.random()*10));
  });


  /* 修改手机2 */
  $(".j-change-phone2").click(function() {
    var $this = $(this);
    var flag = 1;
    var phone = $("input[name='newPhone']").val(),
        smsCaptcha = $("input[name='psc2']").val();

    $this.closest("form").find("input").each(function () {
      formVerify($(this));
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if(flag) {
      $.post(owAPI.changeNewPhone,
        {
          phone: phone,
          smsCaptcha:smsCaptcha
        },
        function ( res ) {
          if( res.error ) {
            layer.msg(res.msg);
            if( res.redirect ) {
              setTimeout(function() {
                window.location.href = res.redirect;
              },2000);
            }
          } else {
            var set_status = res.data.status,
              newPhone = res.data.phone;
            if(set_status) {
              $this.closest(".m-modify").siblings(".set-status").find(".c-success").removeClass("hide").siblings("i").addClass("hide");
            } else {
              $this.closest(".m-modify").siblings(".set-status").find(".c-fail").removeClass("hide").siblings("i").addClass("hide");
            }
            $(".cur-phone").text(newPhone);
            $this.closest(".m-modify").addClass("hide").siblings(".modify-btn").attr("data-val",1).removeClass("hide");
          }
        }
      )
    }
  });

})();