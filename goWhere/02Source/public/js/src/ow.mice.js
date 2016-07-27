/**
 * Created by zds on 2016/3/14.
 */
$(function () {

  var w = $(".section-warp")[0].offsetLeft;

  $(".gradual-bg").css("width", w);

  $(window).resize(function () {
    w = $(".section-warp")[0].offsetLeft;

    $(".gradual-bg").css("width", w);
  });

  $("#demand ul li").click(function () {
    var $this = $(this);
    $("#demand input").val($this.attr("data-demand"));
    $this.addClass("cur").siblings("li").removeClass("cur");
  });

  $("#precise-demand ul li").click(function () {
    var $this = $(this);
    var finalDemand = new Array();
    $this.toggleClass("cur");
    $("#precise-demand ul li").each(function () {
      var $that = $(this);
      if ($that.hasClass("cur")) {
        var _val = $that.attr("data-demand");
        finalDemand.push(_val);
      }
    });
    $("#precise-demand input").val(finalDemand);
  });
  $(".preciseAdvisory").click(function () {
    $(".full-shade").removeClass("hide");*/
    $(".precise-advisory").removeClass("hide");
  });

  $(".precise-advisory .ow-close").click(function () {
    $(".full-shade").addClass("hide");*/
    $(".precise-advisory").addClass("hide");
  });


  $(".ow-select").click(function () {
    var $this = $(this);

  });

  $(document).on("click", ".datePick", function () {
    $(this).datepicker({
      dateFormat: "yy-mm-dd",
      numberOfMonths: 2,
      showMonthAfterYear: true,
      showOtherMonths: true
    }).datepicker('show');
  });


  $(".day .plusDay").click(function () {
    var $this = $(this),
      dayVal = parseInt($this.siblings("input").val());
    if (dayVal === "" || dayVal == undefined) {
      return false;
    } else {
      dayVal++;
      $this.siblings("input").val(dayVal);
    }
  });

  $(".day .minusDay").click(function () {
    var $this = $(this),
      dayVal = $this.siblings("input").val();
    if (dayVal == "" || dayVal == null || dayVal === 0) {
    } else {
      dayVal--;
      $this.siblings("input").val(dayVal);
    }
  });

  /*var case1HTML = "",
    case2HTML = "",
    i, casesLen;
  var $fRow = $(".cases .fRow"),
    $sRow = $(".cases .sRow");
  for (i = 0, casesLen = caseData.cases.length; i < 3; i++) {
    case1HTML += '<li>' +
      '<img src="' + caseData.cases[i].caseImg + '">' +
      '<div class="case-text">' +
      '<p class="ct1">' + caseData.cases[i].caseTitle + '</p>' +
      '<p class="ct2">' + caseData.cases[i].caseText +
      '</p>' +
      '<div class="see-details">' +
      '<a href="' + caseData.cases[i].caseUrl + '">查看详情</a>' +
      '</div>' +
      '</div>' +
      '</li>';
  }

  for (i = 3, casesLen = caseData.cases.length; i < casesLen; i++) {
    case2HTML += '<li>' +
      '<img src="' + caseData.cases[i].caseImg + '">' +
      '<div class="case-text">' +
      '<p class="ct1">' + caseData.cases[i].caseTitle + '</p>' +
      '<p class="ct2">' + caseData.cases[i].caseText +
      '</p>' +
      '<div class="see-details">' +
      '<a href="' + caseData.cases[i].caseUrl + '">查看详情</a>' +
      '</div>' +
      '</div>' +
      '</li>';
  }

  $fRow.html(case1HTML);
  $sRow.html(case2HTML);*/


  $(".pre").click(function () {
    var $fRowLi = $fRow.find("li:first"),
      $sRowLi = $sRow.find("li:first");
    var fc = $fRowLi.clone();
    var sc = $sRowLi.clone();
    $sRow.append(fc);
    $fRow.append(sc);
    $fRowLi.remove();
    $sRowLi.remove();
  });

  $(".next").click(function () {
    var $fRowLiL = $fRow.find("li:last"),
      $sRowLiL = $sRow.find("li:last");
    var fc = $fRowLiL.clone();
    var sc = $sRowLiL.clone();
    $fRow.prepend(sc);
    $sRow.prepend(fc);
    $fRowLiL.remove();
    $sRowLiL.remove();
  });
});