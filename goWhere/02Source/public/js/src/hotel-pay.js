/**
 * Created by zds on 2015/12/21.
 */
$(function(){
  //酒店支付成功页面相关切换
  $(".other-relevant-option").click(function(){
    var $this = $(this),
        text = $this.find("p").text();
    if($this.hasClass("other-relevant-option-cur")){
      return false;
    }else{
      if(text == "相关机票"){
        $this.addClass("other-relevant-option-cur").siblings().removeClass("other-relevant-option-cur");
        $(".airline-relevant").removeClass("hide").siblings("ul").addClass("hide");
      }else{
        $this.addClass("other-relevant-option-cur").siblings().removeClass("other-relevant-option-cur");
        $(".tour-relevant").removeClass("hide").siblings("ul").addClass("hide");
      }
    }
  })
});