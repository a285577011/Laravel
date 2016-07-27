/**
 * Created by zds on 2016/5/31.
 */
(function() {

  $(".pt-order-time").change(function() {
    var $selected = $(".pt-order-time option:selected");
    changePT($selected);
  });



  $(".pt-num .minus").click(function() {
    var $this = $(this);
    var num = parseInt($this.siblings(".num").attr("data-num"));
    if(num === 0) {
      return false;
    } else {
      num -= 1;
    }
    $this.siblings(".num").attr("data-num",num).text(num);

    if($this.siblings(".num").attr("data-type") === "adult") {
      var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
      countPrice(num, childNum);
    } else {
      var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
      countPrice(adultNum, num);
    }
  });

  $(".pt-num .add").click(function() {
    var $this = $(this);
    var num = parseInt($this.siblings(".num").attr("data-num"));
    num += 1;
    $this.siblings(".num").attr("data-num",num).text(num);
    if($this.siblings(".num").attr("data-type") === "adult") {
      var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
      countPrice(num, childNum);
    } else {
      var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
      countPrice(adultNum, num);
    }
  });

  $(document).on("click", ".cal_link", function() {
    var _begin = $(this).attr("data-begin");
    $(".pt-order-time option").each(function() {
      var $this = $(this);
      var _val = $this.val();
      if(_begin === _val) {
        $this.attr("selected",true).siblings("option").attr("selected",false);
        $(".pt-order-time").val($this.val());
        changePT($this);
      }
    })
  });

  var changePT = function(obj) {
    var begin = obj.attr("data-begin");
    var end = obj.attr("data-end");
    var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
    var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
    var ap = obj.attr("data-ap");
    var cp = obj.attr("data-cp");

    $(".pt-begin .time").text(begin);
    $(".pt-end .time").text(end);

    $(".pt-adult").text(ap);
    $(".pt-child").text(cp);
    countPrice(adultNum, childNum);
  };

  var countPrice = function (adultNum, childNum) {
    var $selected = $(".pt-order-time option:selected");
    var _ap = $selected.attr("data-ap");
    var _cp = $selected.attr("data-cp");

    $(".pt-order-price span").text(parseFloat((_ap*adultNum + _cp*childNum).toFixed(2)));
  };


  var $route = $("#route"),
      route_top = $route.offset().top,
      route_bottom = $route.height() + route_top;

  $(document).on("click", ".route-date li", function() {
    var $this = $(this);
    var _id = "#" + $this.attr("data-id");
    $this.addClass("cur").siblings("li").removeClass("cur");
    $("html,body").animate({scrollTop:$(_id).offset().top},500);
  });

  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop();
    if(scrollTop > route_top + 250 && scrollTop < route_bottom - 150) {
      $(".route-date li").each(function() {
        var $this = $(this);
        var _id = "#" + $this.attr("data-id");
        if(scrollTop > $(_id).offset().top -150 && scrollTop < $(_id).offset().top + $(_id).height()) {
          $this.addClass("cur").siblings("li").removeClass("cur");
        }
      });
      $(".route-date").addClass("route-fixed");
      $(".route-date-contain").addClass("ml160");
    } else {
      $(".route-date").removeClass("route-fixed");
      $(".route-date-contain").removeClass("ml160");
    }
  });

})();