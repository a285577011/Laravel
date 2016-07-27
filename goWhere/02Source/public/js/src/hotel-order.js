/**
 * Created by zds on 2016/7/7.
 */
(function() {
  $(".j-room-num").change(function() {
    var roomNum = parseInt($(this).val());
    var $lmItems = $(".lodger-msg-items");
    var $lmItem = $(".lodger-msg-item");
    var lmLen;
    lmLen = $lmItem.length;
    if(lmLen > roomNum) {
      for(var i = 0; i < lmLen-roomNum; i++) {
        $lmItem.eq(roomNum + i).remove();
      }
    } else {
      for(var j = 0; j < roomNum-lmLen; j++) {
        $lmItems.append($lmItem.eq(0).clone());
      }
    }
  });

  $(".add-lodger").click(function() {
    var $lmItems = $(".lodger-msg-items");
    var $lmItem = $(".lodger-msg-item");
    var delHTML = '<a class="del-lodger"><i class="iconfont icon-close2"></i></a>';
    $lmItems.append($lmItem.eq(0).clone().append(delHTML));
  });

  $(document).on("click", ".del-lodger", function() {
    $(this).closest(".lodger-msg-item").remove();
  });

  $(".invoice-select").change(function() {
    var _val = $(this).attr("data-type");
    if(_val === 'need') {
      $(".invoice-msg").removeClass("hide");
    } else {
      $(".invoice-msg").addClass("hide");
    }
  });
})();