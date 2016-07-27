/**
 * Created by zds on 2016/3/7.
 */
$(function(){
  var cw = $(window).height()-30;
  $(".ow-slide").css("height",cw);

  $(window).resize(function () {
    cw = $(window).height()-30;
    $(".ow-slide").css("height",cw);
  });

  var imgData = [
    {
      src:"../images/ow-index-slide01.jpg"
    },
    {
      src:"../images/slide01.jpg"
    },
    {
      src:"../images/slide02.jpg"
    },
    {
      src:"../images/slide03.jpg"
    },
    {
      src:"../images/slide04.jpg"
    }
  ];

  var imgLen = imgData.length;
  var slideHtml = "";
  for(var i = 0; i < imgLen; i++){
    slideHtml += '<li style="background:url(' + imgData[i].src + ') center center no-repeat scroll"></li>'
  }
  $(".ow-slide-ul").append(slideHtml);

  $(".j-options li").click(function() {
    var $this = $(this);
    var thisText = $this.attr("data-text");
    var thisVal = $this.attr("data-val");
    $this.closest(".j-options").addClass("hide").siblings("input").val(thisText);
    $this.closest(".j-options").siblings(".form-hide").val(thisVal);
  });

  $("input").click(function() {
    $(".j-options").addClass("hide");
    $(this).siblings(".j-options").removeClass("hide");
  });

  $(".ed-option-item li").click(function(){
    var $this = $(this),
      bookType = $this.attr("data-book");
    if($this.hasClass("cur")){
      return false;
    }else{
      $this.addClass("cur").siblings().removeClass("cur");
      if(bookType === "hotel"){
        $(".ow-hotel-form").removeClass("hide").siblings(".air-forms").addClass("hide");
      }else{
        $(".air-forms").removeClass("hide").siblings(".ow-hotel-form").addClass("hide");
      }
    }
  });

  $(".air-forms-ul li").click(function(){
    var $this = $(this),
      airWayType = $this.attr("data-airType");
    if($this.hasClass("cur")){
      return false;
    }else{
      $this.addClass("cur").siblings().removeClass("cur");
      if(airWayType === "oneWay"){
        $(".ow-oneLine-air-form").removeClass("hide").siblings("form").addClass("hide");
      }else if(airWayType === "roundWay"){
        $(".ow-roundLine-air-form").removeClass("hide").siblings("form").addClass("hide");
      }else{
        $(".air-more-trip-form").removeClass("hide").siblings("form").addClass("hide");
      }
    }
  });

  $(".oss-btn").click(function() {
    var $this = $(this);
    var $form = $this.closest("form");
    var area = parseInt($form.find("input[name='area']").val());
    var people_num = $form.find("input[name='people_num']").val();
    var budget = $form.find("input[name='budget']").val();
    var type = $form.find("input[name='type']").val();
    var name = $form.find("input[name='name']").val();
    var phone = $form.find("input[name='phone']").val();
    var email = $form.find("input[name='email']").val();
    var qq_wechat = $form.find("input[name='qq_wechat']").val();
    var departure_date = $form.find("input[name='departure_date']").val();
    var duration = $form.find("input[name='duration']").val();

    $.post(owAPI.oneStepService,
      {
        area: area,
        type: type,
        people_num: people_num,
        budget: budget,
        name: name,
        phone: phone,
        email: email,
        qq_wechat: qq_wechat,
        departure_date: departure_date,
        duration: duration
      },
      function (res) {
        if(res.status) {
          alert(res.info)
        } else {
          alert(res.info)
        }
      }
    )
  });

  $(".ct-content ul li").mouseenter(function() {
    $(this).stop().animate({
      marginTop: '-20px'
    },500)
  }).mouseleave(function() {
    $(this).stop().animate({
      marginTop: '0'
    },500)
  });

  $(document).on("click", ".datePick", function () {
    $(this).datepicker({
      dateFormat:"yy-mm-dd",
      numberOfMonths:2,
      minDate: 0,
      showMonthAfterYear:true,
      showOtherMonths:true
    }).datepicker('show')
  });

  $("#hFrom").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    minDate: 0,
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $("#hTo").datepicker( "option", "minDate", selectedDate );
    }
  });

  $("#hTo").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    minDate: 0,
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $("#hFrom").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $("#roundFrom").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    minDate: 0,
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $("#roundTo").datepicker( "option", "minDate", selectedDate );
    }
  });

  $("#roundTo").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    minDate: 0,
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $("#roundFrom").datepicker( "option", "maxDate", selectedDate );
    }
  });

  var newPlaneLine =
    '<div class="more-trip-group clear">' +
      '<div class="part mr">' +
        '<span>出发</span>' +
        '<input class="destination-select" data-state="1">' +
      '</div>' +
      '<div class="part mr">' +
        '<span>到达</span>' +
        '<input class="destination-select" data-state="1">' +
      '</div>' +
      '<div class="part">' +
        '<span>日期</span>' +
        '<input class="datePick">' +
      '</div>' +
      '<div class="del-trip">' +
        '<i class="iconfont icon-close"></i>' +
      '</div>' +
    '</div>';

  $(".add-more").click(function() {
    if($(".more-trip-group").length > 7) {
      alert("不能添加更多行程");
      return false;
    } else {
      $(this).before(newPlaneLine);
    }
  });

  $(document).on("click",".del-trip",function() {
    $(this).closest(".more-trip-group").remove();
  });

  $(".case-slide").slick();

});