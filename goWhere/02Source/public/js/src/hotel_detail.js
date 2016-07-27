/**
 * Created by zds on 2015/12/15.
 */
$(function(){
  $(".hotel-around-li").click(function(){
    var $this = $(this),
        thisText = $(this).find("span").text();
    if($this.hasClass("hotel-around-cur")){
      return false;
    }else {
      if (thisText == "景点") {
         $this.addClass("hotel-around-cur").siblings("li").removeClass("hotel-around-cur");
         $(".spot-result").removeClass("hide").siblings("ul").addClass("hide");
      }else if(thisText == "地铁") {
        $this.addClass("hotel-around-cur").siblings("li").removeClass("hotel-around-cur");
        $(".subway-result").removeClass("hide").siblings("ul").addClass("hide");
      }else if(thisText == "机场") {
        $this.addClass("hotel-around-cur").siblings("li").removeClass("hotel-around-cur");
        $(".airport-result").removeClass("hide").siblings("ul").addClass("hide");
      }else if(thisText == "车站") {
        $this.addClass("hotel-around-cur").siblings("li").removeClass("hotel-around-cur");
        $(".station-result").removeClass("hide").siblings("ul").addClass("hide");
      }
    }
  });

});