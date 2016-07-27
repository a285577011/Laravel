/**
 * Created by zds on 2016/5/27.
 */

/* 验证规则 */

(function() {

  var regs = {
    dataType: {
      "*": /[\w\W]+/,
      "m": /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/,
      "e": /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
    }
  };

  $(".verify-btn").click(function () {
    var flag = 1;
    $(".verify-btn").closest("form").find("input").each(function () {
      var $this = $(this);
      var value = $this.val();
      var dataType = $this.attr("datatype");
      var errorMsg = $this.attr("errormsg");
      var nullMsg = $this.attr("nullmsg");
      if ($.trim(value) === "") {
        $this.siblings(".verify-pop").text(nullMsg);
        $this.closest(".oss-group").removeClass("has-success").addClass("has-error");
      } else {
        if (!regs.dataType[dataType].test($.trim(value))) {
          $this.siblings(".verify-pop").text(errorMsg);
          $this.closest(".oss-group").removeClass("has-success").addClass("has-error");
        } else {
          $this.closest(".form-group").addClass("has-success").removeClass("has-error");
          $this.siblings(".oss-group").text(" ");
        }
      }
    });

    $("#mediaSign").find(".oss-group").each(function () {
      if ($(this).hasClass("has-error")) {
        flag = 0;
      }
    });
  });
  $(document).on("blur", ".oss-group input", function () {
    var $this = $(this);
    var value = $this.val();
    var dataType = $this.attr("datatype");
    var errorMsg = $this.attr("errormsg");
    var nullMsg = $this.attr("nullmsg");

    if ($.trim(value) === "") {
      if($this.siblings(".verify-pop").length !== 0) {
        $this.siblings(".verify-pop").find(".verify-tip").text(nullMsg);
      } else {
        $this.after(
            '<div class="verify-pop">' +
            '<span class="verify-tip">' + nullMsg + '</span>' +
            '</div>'
        );
      }
      $this.closest(".oss-group").removeClass("has-success").addClass("has-error");
    } else {
      if (!regs.dataType[dataType].test($.trim(value))) {
        if($this.siblings(".verify-pop").length !== 0) {
          $this.siblings(".verify-pop").find(".verify-tip").text(errorMsg);
        } else {
          $this.after(
              '<div class="verify-pop">' +
              '<span class="verify-tip">' + errorMsg + '</span>' +
              '</div>'
          );
        }
        $this.closest(".oss-group").removeClass("has-success").addClass("has-error");
      } else {
        $this.closest(".oss-group").addClass("has-success").removeClass("has-error");
        $this.siblings(".verify-pop").remove();
      }
    }
  });

})();

