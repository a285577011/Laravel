/**
 * Created by zds on 2015/12/8.
 */
$(function () {

  var w = $(".banner-search")[0].offsetLeft;

  $(".banner-grad").css("width", w);

  $(window).resize(function () {
    w = $(".banner-search")[0].offsetLeft;

    $(".banner-grad").css("width", w);
  });

  /* 酒店首页banner表单时间选择 */
  $("#hFrom").datepicker({
    defaultDate: "+1w",
    dateFormat: "yy-mm-dd",
    minDate: 0,
    numberOfMonths: 2,
    showMonthAfterYear: true,
    showOtherMonths: true,
    onClose: function (selectedDate) {
      $("#hTo").datepicker("option", "minDate", selectedDate);
    }
  });

  $("#hTo").datepicker({
    defaultDate: "+1w",
    dateFormat: "yy-mm-dd",
    minDate: 0,
    numberOfMonths: 2,
    showMonthAfterYear: true,
    showOtherMonths: true,
    onClose: function (selectedDate) {
      $("#hFrom").datepicker("option", "maxDate", selectedDate);
    }
  });

  //酒店首页banner表单选择儿童
  $("#childSelect").change(function() {
    var num = parseInt($(this).val());
    var $cAges = $(".child-ages");
    var $cais = $(".child-age-items");
    var $cai = $(".child-age-item");
    var caiLen;
    if(num !== 0) {
      $cAges.removeClass("hide");
      caiLen = $cai.length;
      if(caiLen > num) {
        for(var i = 0; i < caiLen-num; i++) {
          $cai.eq(num + i).remove();
        }
      } else {
        for(var j = 0; j < num-caiLen; j++) {
          $cais.append($cai.eq(0).clone());
        }
      }
    } else {
      $cAges.addClass("hide");
    }
  });

  /* 酒店首页banner表单提交验证 */
  $(".hotel-search").click(function() {
    var $this = $(this);
    var flag = 1;
    var caArr = new Array();
    $(".child-age-item").each(function() {
      caArr.push($(this).val());
    });
    $(".child-ages-array").val(caArr);
    $this.closest("form").find(".need-verify").each(function () {
      var $that = $(this);
      formVerify($that);
      if ($that.hasClass("has-error")) {
        flag = 0;
      }
    });
    if( flag ) {
      $this.closest("from").submit();
    }
  });

  //特价酒店鼠标移入效果
  $(".special-hotel-main-item2-img").mouseenter(function () {
    $(this).find(".special-hotel-main-item2-zzc").stop().animate({
      bottom: 0
    }, 300)
  }).mouseleave(function () {
    $(this).find(".special-hotel-main-item2-zzc").stop().animate({
      bottom: "-25px"
    }, 300)
  });

});