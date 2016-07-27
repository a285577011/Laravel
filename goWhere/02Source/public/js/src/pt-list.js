/**
 * Created by zds on 2016/6/2.
 */
(function() {
  $(document).on("click", ".datePick", function () {
    $(this).datepicker({
      dateFormat:"yy-mm-dd",
      numberOfMonths:2,
      minDate: 0,
      showMonthAfterYear:true,
      showOtherMonths:true
    }).datepicker('show')
  });
})();