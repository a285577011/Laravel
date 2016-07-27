/**
 * Created by zds on 2016/3/8.
 * 吉程轮播插件
 *
 */

;
(function ($) {
  //定义owSlide的构造函数
  var owSlide = function (ele, opt) {
    this.$element = ele;
    this.defaults = {
      speed:5000
    };
    this.options = $.extend({}, this.defaults, opt);
  };
  //定义owSlide的方法
  owSlide.prototype = {
    owSlideInit: owSlideInit
  };

  function owSlideInit() {
    var opt = this.options,
        $ele = this.$element.find("li");
    beginSlide(opt,$ele);
  }

  function beginSlide(opt,$ele) {
    $ele.eq(0).css("opacity",1);
    setInterval(function(){
      for(var i = 0; i < $ele.length; i++){
        $ele.eq(i).animate({
          opacity:1
        },opt.speed).siblings("li").animate({
          opacity:0
        },opt.speed)
      }
    },1)
  }


  //在插件中使用owSlide对象
  $.fn.owSlide = function (options) {
    //创建owSlide的实体
    var owSlideView = new owSlide(this, options);
    //调用其方法
    return owSlideView.owSlideInit();
  }
})(jQuery);