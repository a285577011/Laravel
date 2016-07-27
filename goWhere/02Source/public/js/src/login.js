/**
 * Created by zds on 2016/6/27.
 */
(function() {
  $("#login").click(function() {
    var $this = $(this);
    var $form = $this.closest("form");
    var flag = 1;
    $form.find(".need-verify").each(function () {
      var $this = $(this);
      formVerify($this);
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
    if( flag ) {
      $this.closest("form").submit();
    }
  })
})();