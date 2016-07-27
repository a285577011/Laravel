/**
 * Created by zds on 2016/6/3.
 */
(function() {

  $("#contactTime .checkbox-warp").click(function() {
    var fVal = [];
    var $this = $(this);
    $this.toggleClass("cur");

    $("#contactTime .checkbox-warp").each(function() {
      var $this = $(this);
      var _val = $this.attr("data-val");
      if($this.hasClass("cur")) {
        fVal.push(_val);
      }
    });
    $this.siblings(".hide-input").val(fVal);
  });

  $("#repast .checkbox-warp").click(function() {
    var fVal = [];
    var $this = $(this);
    $this.toggleClass("cur");

    $("#repast .checkbox-warp").each(function() {
      var $this = $(this);
      var _val = $this.attr("data-val");
      if($this.hasClass("cur")) {
        fVal.push(_val);
      }
    });
    $this.siblings(".hide-input").val(fVal);
  });

  $(".radio-warp").click(function() {
    var $this = $(this);
    var _val = $this.attr("data-val");
    $this.addClass("cur").siblings(".radio-warp").removeClass("cur").siblings(".hide-input").val(_val);
  });

  $(".datepicker").datepicker({
    dateFormat:"yy-mm-dd",
    numberOfMonths:2,
    minDate: 0,
    showMonthAfterYear:true,
    showOtherMonths:true
  });

  $(".customize-btn").click(function() {
    var flag = 1;
    var $this = $(this);
    $this.closest("form").find(".need-verify").each(function() {
      formVerify($(this));
      if($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if(flag) {
      $this.closest("form").submit();
    }
  });
})();