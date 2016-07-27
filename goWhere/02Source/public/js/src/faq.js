/**
 * Created by zds on 2016/6/28.
 */
/**
 * Created by zds on 2016/6/28.
 */
(function() {
  $(".faq-type li").click(function() {
    var $this = $(this);
    $this.addClass("active").siblings("li").removeClass("active").find(".sub-faq-type").addClass("hide");
    $this.find(".sub-faq-type").removeClass("hide");
  })
})();