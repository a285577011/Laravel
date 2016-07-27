/**
 * Created by zds on 2016/6/1.
 */
(function() {

  $(".pt-order-time").change(function() {
    var $selected = $(".pt-order-time option:selected");
    var begin = $selected.attr("data-begin");
    var end = $selected.attr("data-end");
    var ap = $selected.attr("data-ap");
    var cp = $selected.attr("data-cp");
    var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
    var childNum = parseInt($(".num[data-type='child']").attr("data-num"));

    $(".pt-begin .time").text(begin);
    $(".pt-end .time").text(end);

    $(".j-ap").text(ap);
    $(".j-cp").text(cp);
    countPrice(adultNum, childNum);
  });

  $(".pt-num .minus").click(function() {
    var $this = $(this);
    var num = parseInt($this.siblings(".num").attr("data-num"));
    if(num === 0) {
      return false;
    } else {
      num -= 1;
    }
    $this.siblings(".num").attr("data-num",num).text(num).siblings("input").val(num);
    if($this.siblings(".num").attr("data-type") === "adult") {
      var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
      $(".j-adult-num").text(num);
      $(".j-total-num").text(num + childNum);
      countPrice(num, childNum);
      $(".adultPassengerMsg-warp").find(".adultPassengerMsg:last-child").remove();
    } else {
      var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
      $(".j-child-num").text(num);
      $(".j-total-num").text(num + adultNum);
      countPrice(adultNum, num);
      $(".childPassengerMsg-warp").find(".childPassengerMsg:last-child").remove();
    }
  });

  $(".pt-num .add").click(function() {
    var $this = $(this);
    var num = parseInt($this.siblings(".num").attr("data-num"));
    var _adultHtml = $(".adultPassengerMsg.hide").clone();
    var _childHtml = $(".childPassengerMsg.hide").clone();
    num += 1;
    $this.siblings(".num").attr("data-num",num).text(num).siblings("input").val(num);
    if($this.siblings(".num").attr("data-type") === "adult") {
      var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
      $(".j-adult-num").text(num);
      $(".j-total-num").text(num + childNum);
      countPrice(num, childNum);
      $(".adultPassengerMsg-warp").append(_adultHtml).find(".adultPassengerMsg").removeClass("hide");
    } else {
      var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
      $(".j-child-num").text(num);
      $(".j-total-num").text(num + adultNum);
      countPrice(adultNum, num);
      $(".childPassengerMsg-warp").append(_childHtml).find(".childPassengerMsg").removeClass("hide");
    }
  });

  $(document).on("click",".insurance-msg .checkbox",function() {
    var fVal = [];
    var $this = $(this);
    var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
    var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
    $this.toggleClass("cur");
    $(".insurance-msg .checkbox").each(function() {
      var $this = $(this);
      var _val = $this.attr("data-val");
      if($this.hasClass("cur")) {
        fVal.push(_val);
        $(".pvi-insurance").each(function(){
          var $this = $(this);
          if($this.attr("data-type") === _val) {
            $this.removeClass("hide");
          }
        })
      } else {
        $(".pvi-insurance").each(function(){
          var $this = $(this);
          if($this.attr("data-type") === _val) {
            $this.addClass("hide");
          }
        })
      }
    });
    $this.closest(".insurance-msg").siblings(".hide").val(fVal);
    countPrice(adultNum, childNum);
  });

  var countPrice = function (adultNum, childNum) {
    var $selected = $(".pt-order-time option:selected");
    var _ap = $selected.attr("data-ap");
    var _cp = $selected.attr("data-cp");
    var insurancePrice = 0;
    $(".insurance-msg .checkbox").each(function() {
      var $this = $(this);
      var _price = parseFloat($this.attr("data-price"));
      if($this.hasClass("cur")) {
        insurancePrice += _price;
      }
    });
    $(".j-total-price").text(parseFloat((_ap*adultNum + _cp*childNum + insurancePrice*(adultNum + childNum)).toFixed(2)));
  };

  $(document).on("click",".radio",function() {
    var $this = $(this);
    var _val = $this.attr("data-val");
    var _type = $this.attr("data-type");
    $this.addClass("cur").closest(".radio-warp").siblings(".radio-warp").find(".radio").removeClass("cur");
      $this.closest(".radio-warp").siblings(".hide").val(_val);
    if(_type === "need-invoice") {
      $(".invoice").removeClass("hide");
    } else if (_type === "noNeed-invoice") {
      $(".invoice").addClass("hide");
    }
  });

  $(".other-relevant-option").click(function(){
    var $this = $(this),
      _val = $this.attr("data-val");
    if($this.hasClass("other-relevant-option-cur")){
      return false;
    }else{
      if(_val === "hotel"){
        $this.addClass("other-relevant-option-cur").siblings().removeClass("other-relevant-option-cur");
        $(".hotel-relevant").removeClass("hide").siblings("ul").addClass("hide");
      }else if(_val === "tour") {
        $this.addClass("other-relevant-option-cur").siblings().removeClass("other-relevant-option-cur");
        $(".tour-relevant").removeClass("hide").siblings("ul").addClass("hide");
      }
    }
  })
})();