/**
 * Created by zds on 2016/6/7.
 */
(function() {

  $(".ooc-begin").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $(".ooc-end").datepicker( "option", "minDate", selectedDate );
    }
  });

  $(".ooc-end").datepicker({
    defaultDate: "+1w",
    dateFormat:"yy-mm-dd",
    minDate: 0,
    numberOfMonths:2,
    showMonthAfterYear:true,
    showOtherMonths:true,
    onClose: function( selectedDate ) {
      $(".ooc-begin").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $(".all-type-order a").click(function() {
    var $this = $(this);
    var _val = $this.attr("data-val");
    $.post(orderSubmitUrl,
      {
        "status_cfc": _val
      },
      function( res ) {
        if(res.error) {
          alert(res.msg);
        } else {
          $("#ooCondition").attr({
            "data-type":res.data.condition.type,
            "data-start":res.data.condition.date_start,
            "data-end":res.data.condition.date_end,
            "data-status":res.data.condition.status_cfc
          });
          $this.addClass("cur").siblings("a").removeClass("cur");
          $(".my-order-result-warp").html(res.data.view);
        }

      }
    );
  });

  $(".ooc-query").click(function() {
    var type = 0;
    if($("#oocType").val()) {
      type = parseInt($("#oocType").val());
    }
    var date_start = $(".ooc-begin").val(),
        date_end = $(".ooc-end").val(),
        status_cfc = $(".all-type-order .cur").attr("data-val");

    $.post(orderSubmitUrl,
      {
        "type": type,
        "date_start": date_start,
        "date_end": date_end,
        "status_cfc": status_cfc
      },
      function( res ) {
        if(res.error) {
          alert(res.msg);
        } else {
          $("#ooCondition").attr({
            "data-type":res.data.condition.type,
            "data-start":res.data.condition.date_start,
            "data-end":res.data.condition.date_end,
            "data-status":res.data.condition.status_cfc
          });
          $(".my-order-result-warp").html(res.data.view);
        }
      }
    );
  });

  $(document).on("click", ".pagination a", function(e) {
    e.preventDefault();
    var page = $(this).attr("href").match(/\?page=(\d+)/)[1];
    var $ooCondition = $("#ooCondition");
    var date_start = $ooCondition.attr("data-start"),
        date_end = $ooCondition.attr("data-end"),
        status_cfc = $ooCondition.attr("data-status"),
        type = $ooCondition.attr("data-type");
    $.post(orderSubmitUrl,
      {
        "type": type,
        "date_start": date_start,
        "date_end": date_end,
        "status_cfc": status_cfc,
        "page": page
      },
      function( res ) {
        if(res.error) {
          alert(res.msg);
        } else {
          $("#ooCondition").attr({
            "data-type":res.data.condition.type,
            "data-start":res.data.condition.date_start,
            "data-end":res.data.condition.date_end,
            "data-status":res.data.condition.status_cfc
          });
          $(".my-order-result-warp").html(res.data.view);
        }
      }
    );
  });

  $(".ooc-time-range a").click(function() {
    var $this = $(this);
    var period = $this.attr("data-val");

    var type = 0;
    if($("#oocType").val()) {
      type = parseInt($("#oocType").val());
    }
    var status_cfc = $(".all-type-order .cur").attr("data-val");

    $.post(orderSubmitUrl,
      {
        "type": type,
        "status_cfc": status_cfc,
        "period": period
      },
      function( res ) {
        if(res.error) {
          alert(res.msg);
        } else {
          $("#ooCondition").attr({
            "data-type":res.data.condition.type,
            "data-start":res.data.condition.date_start,
            "data-end":res.data.condition.date_end,
            "data-status":res.data.condition.status_cfc
          });
          $(".ooc-begin").val(res.data.condition.date_start);
          $(".ooc-end").val(res.data.condition.date_end);
          $(".my-order-result-warp").html(res.data.view);
        }
      }
    );
  });

  $(document).on("click",".cancel-order",function() {
    var $this = $(this);
    var _orderID = $this.attr("data-val");
    layer.msg('你确定取消订单吗？', {
      time: 0
      ,btn: ['确定', '考虑一下']
      ,yes: function(index){
        layer.close(index);
        $.post(owAPI.cancelOrder,{
          ordersn: _orderID
        },
        function(res) {
          if(res.error) {
            layer.msg(res.msg);
          } else {
            var $ooCondition = $("#ooCondition");
            var date_start = $ooCondition.attr("data-start"),
              date_end = $ooCondition.attr("data-end"),
              status_cfc = $ooCondition.attr("data-status"),
              type = $ooCondition.attr("data-type");
            $.post(orderSubmitUrl,
              {
                "type": type,
                "date_start": date_start,
                "date_end": date_end,
                "status_cfc": status_cfc
              },
              function( res ) {
                if(res.error) {
                  alert(res.msg);
                } else {
                  $("#ooCondition").attr({
                    "data-type":res.data.condition.type,
                    "data-start":res.data.condition.date_start,
                    "data-end":res.data.condition.date_end,
                    "data-status":res.data.condition.status_cfc
                  });
                  $(".my-order-result-warp").html(res.data.view);
                }
              }
            );
          }
        })
      }
    });

  })
})();