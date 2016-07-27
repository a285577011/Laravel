/**
 * Created by zds on 2016/5/24.
 */


(function() {

  document.write('<script src="/js/src/owPC.api.js"></script>');
  $.ajaxSetup({
    xhrFields: {withCredentials: true},
    crossDomain: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    statusCode: {
      401: function() {
        alert("登录超时,请重新登入");
      },
      403: function() {
        alert("权限不足");
      },
      404: function() {
        alert("找不到相应资源");
      },
      408: function() {
        alert("请求超时");
      },
      422: function( res ) {
        var alertStr = '';
        for(var key in res.responseJSON){
          alertStr += key + " : " + res.responseJSON[key][0] + "\n";
        }
        alert(alertStr);
      },
      429: function() {
        alert("请求太频繁,休息一下吧");
      },
      500: function() {
        alert("服务器错误");
      }
    }
  });

  var scrollTop;
  window.onscroll = function(){
    scrollTop = $(window).scrollTop();
    if(scrollTop >= 30){
      $(".header-nav").addClass("nav-top");
    }else{
      $(".header-nav").removeClass("nav-top");
    }
  };

  $(".money-type .sub-list li").click(function() {
    var currency = $(this).attr("data-cookie");
    Cookies.set("currency",currency);
    window.location.reload();
  });

  $(".lang-type .sub-list li").click(function() {
    var lang = $(this).attr("data-cookie");
    Cookies.set("lang",lang);
    window.location.reload();
  });

  var $loginPopup = $(".login-popup"),
      loginPopupW = $loginPopup.width(),
      loginPopupH = $loginPopup.height();
  $loginPopup.css("margin-left", -loginPopupW/2);

  $("#goLogin").click(function() {
    var loginCaptcha = $loginPopup.find(".get-captcha");
    $(".full-shade").removeClass("hide");
    $loginPopup.removeClass("hide").animate({
      marginTop: loginPopupH/2 + 'px'
    },500);
    loginCaptcha.attr("src",loginCaptcha.attr("data-src") + Math.random()*10);
  });

  $(".login-close").click(function() {
    $(".full-shade").addClass("hide");
    $loginPopup.addClass("hide");
  });

  $(".get-captcha").click(function() {
    var $this = $(this);
    var _src = $this.attr("src");
    $this.attr("src", _src + parseInt(Math.random()*10));
  });

  /* 表单验证 */
  $(document).on("change", ".need-verify", function(){
    formVerify($(this));
  });

  $("#loginBtn").click(function() {
    var $this = $(this);
    var flag = 1;
    var identity = $this.closest("form").find("input[name='identity']").val();
    var password = $this.closest("form").find("input[name='password']").val();
    var captcha = $this.closest("form").find("input[name='captcha']").val();
    var remember;
    if($(".l-remember .radio").hasClass("cur")) {
      remember = 1;
    } else {
      remember = 0;
    }
    $this.closest("form").find(".need-verify").each(function () {
      var $that = $(this);
      formVerify($that);
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if( flag ) {
      $.post(owAPI.login,
        {
          identity: identity,
          password: password,
          captcha: captcha,
          remember: remember
        },
        function ( res ) {
          if (res.error) {
            layer.msg(res.msg);
            $(".get-captcha").trigger("click");
          } else {
            location.reload();
          }
        }
      )}
  });

/*  $(".radio").click(function() {
    $(this).toggleClass("cur");
  });*/

})();

/* 短信验证码倒计时 */
var getSMS = function($this, setTime) {
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
};

/* 表单验证正则 */
var regs = {
  dataType: {
    "*": /[\w\W]+/,
    "username": /^[a-zA-Z][a-zA-Z0-9_]{3,15}$/,
    "m": /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/,
    "e": /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    "psd": /^[\[\]~`|!@^#$%&*()-_=+{};:\'"?\/><,.a-zA-z0-9\\\\]{6,20}$/,
    "*1-30": /[\w\W]{1,30}/
  }
};

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
