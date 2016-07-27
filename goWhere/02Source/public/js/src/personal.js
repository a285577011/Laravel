/**
 * Created by zds on 2016/6/3.
 */

$(function(){
  var curUrl = location.href;
  var subMenu = $("div.pc-nav li a");
  var len = subMenu.length;
  for (var i = 0; i < len; i++) {
    var link = subMenu.get(i);
    if (link.href && link.href.indexOf(curUrl) !== -1) {
      $(link).parent().addClass('cur').siblings().removeClass('cur');
      $(link).parent().parent().removeClass('hide');
      return;
    }
  }
  var topLevelMenu = $("div.pc-nav .pc-nav-item > a");
  var tpLen = topLevelMenu.length;
  for (var i = 0; i < tpLen; i++) {
    var link = topLevelMenu.get(i);
    if (link.href && link.href.indexOf(curUrl) !== -1) {
      $(link).parent().addClass('cur').siblings().removeClass('cur');
      return;
    }
  }
});

(function() {
  $('.pc-sub-nav').click(function (e) {
    e.stopPropagation();
  });

  $(".pc-nav-item a").click(function() {
    var $this = $(this);
    $this.siblings(".pc-sub-nav").toggleClass("hide");
  });

  $(".pi-modify").click(function() {
    $(".modify-pi-msg").removeClass("hide");
    $(".only-read-pi-msg").addClass("hide");
  });

  $(document).on("click",".radio",function() {
    var $this = $(this);
    var _val = $this.attr("data-val");
    $this.addClass("cur").siblings(".radio").removeClass("cur").siblings("input.hide").val(_val);
  });

  $(".pi-modify-undo").click(function() {
    $(".only-read-pi-msg").removeClass("hide");
    $(".modify-pi-msg").addClass("hide");
  });

  $(".modify-btn").click(function() {
    var $this = $(this);
    var type = $this.attr("data-type"),
        _val = $this.attr("data-val");
    if(type === "changePhone") {
      $this.addClass("hide");
      if(_val == "1") {
        $(".cp-step1").removeClass("hide");
      } else {
        $(".cp-step2").removeClass("hide");
      }
    } else {
      $this.addClass("hide").siblings(".m-modify").removeClass("hide");
    }
  });

  $(".mm-undo").click(function() {
    var $this = $(this);
    $this.closest(".m-modify").addClass("hide").siblings(".modify-btn").removeClass("hide");
  });

  $(".mm-ok").click(function() {

  })
})();