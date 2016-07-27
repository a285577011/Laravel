/**
 * Created by zds on 2015/12/10.
 */
$(function(){

  nstSlider();

  $(".min-price").change(function(){
    var minPrice = parseInt($(".min-price").val()),
        maxPrice = parseInt($(".max-price").val());
    if(minPrice > maxPrice){
      minPrice=0;
      $(".min-price").val(0);
    }
    readerPriceBar(minPrice,maxPrice);
    nstSlider();
  });

  $(".max-price").change(function(){
    var minPrice = parseInt($(".min-price").val()),
        maxPrice = parseInt($(".max-price").val());
    if(minPrice > maxPrice){
      $(".max-price").val(1650);
      maxPrice=1650;
    }
    readerPriceBar(minPrice,maxPrice);
    nstSlider();
  });

  //选择星级
  $(".condition-star-item i").click(function(){
    $(this).addClass("hide").siblings("i").removeClass("hide");
  });


  //房型价格时间选择
  $("#dateStart").datepicker({
    defaultDate: "+1w",
    dateFormat: "yy-mm-dd",
    minDate: 0,
    numberOfMonths: 2,
    showMonthAfterYear: true,
    showOtherMonths: true,
    onClose: function (selectedDate) {
      $("#dateEnd").datepicker("option", "minDate", selectedDate);
    }
  });

  $("#dateEnd").datepicker({
    defaultDate: "+1w",
    dateFormat: "yy-mm-dd",
    minDate: 0,
    numberOfMonths: 2,
    showMonthAfterYear: true,
    showOtherMonths: true,
    onClose: function (selectedDate) {
      $("#dateStart").datepicker("option", "maxDate", selectedDate);
    }
  });

  $(".j-select-child").change(function() {
    var cNum = parseInt($(this).val());
    var $pop = $(".childs-age-pop");
    var $zzc = $(".full-shade");
    var $cais = $(".childs-age-warp");
    var $cai = $(".childs-age-item");
    var caiLen;
    if(cNum === 0) {
      $pop.addClass("hide");
      $zzc.addClass("hide");
    } else {
      caiLen = $cai.length;
      if(caiLen > cNum) {
        for(var i = 0; i < caiLen-cNum; i++) {
          $cai.eq(cNum + i).remove();
        }
      } else {
        for(var j = 0; j < cNum-caiLen; j++) {
          $cais.append($cai.eq(0).clone());
        }
      }
      $zzc.removeClass("hide");
      $pop.removeClass("hide");
    }
  });

  $(".ca-ok").click(function() {
    var caArr = new Array();
    $(".childs-age-pop").addClass("hide");
    $(".full-shade").addClass("hide");
    $(".childs-age-item").each(function() {
      caArr.push($(this).val());
    });
    $(".child-ages-array").val(caArr);
  });

  $(".del-hotel-history").click(function(){
    $(this).closest(".hotel-search-result-history-li").remove();
  });

});

var nstSlider = function(){
  $('.nstSlider').nstSlider({
    "crossable_handles": false,
    "left_grip_selector": ".leftGrip",
    "right_grip_selector": ".rightGrip",
    "value_bar_selector": ".bar",
    "value_changed_callback": function(cause, leftValue, rightValue) {
      $(this).parent().find('.leftLabel').text("￥"+leftValue);
      $(".min-price").val(leftValue);
      $(this).parent().find('.rightLabel').text("￥"+ rightValue);
      $(".max-price").val(rightValue);
    }
  });
};

var readerPriceBar = function(minPrice,maxPrice){
  var priceBarTpl = $("#nstSlider-bar-tpl").html();
  var html = juicer(priceBarTpl,{minPrice:minPrice,maxPrice:maxPrice});
  $(".nstSlider-bar").html(html);
};