/**
 * Created by zds on 2016/5/30.
 */

;(function($) {

  var  i, j, yy, mm, openbound;
  var data;
  var zh_from = '';
  var zh_to = '';
  var curday, today = new Date();

  //定义packageTourCalendar的构造函数
  var packageTourCalendar = function(ele, opt) {
    this.$element = ele;
    this.defaults = {
      showMaxMonth: 6,
      data: loadData()
    };
    this.options = $.extend({}, this.defaults, opt);
  };
  //定义packageTourCalendar的方法
  packageTourCalendar.prototype = {
    calendarInit: drawCalendar
  };

  function drawCalendar(){
    var opt = this.options;
    drawCalendarWarp(opt);
    initCalendarData(opt);
  }

  function drawCalendarWarp(){
    //初始化机票日历表格
    var ptCalWarp = "",
      htmlStr = "";
    for (i = 0; i < 6; i++) {
      htmlStr += '<tr class="day">';
      for (j = 1; j <= 7; j++) {
        if(j == 1 || j == 7){
          htmlStr += '<td id="b' + (i * 7 + j) + '" class="weekend">' +
            '</td>';
        }else{
          htmlStr += '<td id="b' + (i * 7 + j) + '">' +
            '</td>';
        }
      }
      htmlStr += '</tr>';
    }
    ptCalWarp +=
      '<div class="cal-c">' +
        '<a class="cal-pre">' +
          '<i class="iconfont icon-left"></i>' +
        '</a>' +
        '<span class="cal-month"></span>' +
        '<a class="cal-next">' +
          '<i class="iconfont icon-right"></i>' +
        '</a>' +
      '</div>' +
      '<table class="pt-cal-warp">' +
        '<tr class="weekday">' +
        '<th>日</th>' +
        '<th>一</th>' +
        '<th>二</th>' +
        '<th>三</th>' +
        '<th>四</th>' +
        '<th>五</th>' +
        '<th>六</th>' +
        '</tr>' + htmlStr +
      '</table>';

    $(".pt-calendar").html(ptCalWarp);

  }

  //ajax获取data
  function loadData() {
    var sys_d = {
      "startDate": "2016-03-01",
      "2016-05-22": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-05-28": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-05-29": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-06-05": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-06-13": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-06-22": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      },
      "2016-07-13": {
        "state": "0",
        "surplus": "余票8张",
        "price": "￥8869起"
      }
    };
    return sys_d;
  }

  function initCalendarData(opt) {
    var sysData = opt.data;
    curday = new Date();
    data = sysData;
    var tmpy = curday.getFullYear();
    var tmpm = curday.getMonth();
    showmm = tmpm + 1;
    ajaxhq(tmpy, showmm, opt, "1");
  }

  function ajaxhq(y, m, opt, type) {
    cury = y;
    curm = m;
    if (m == 13) {
      curm = 1;
      cury = y + 1;
    }
    startdate = cury + (curm > 9 ? "-" + curm : "-0" + curm) + "-" + "01";
    if (type == null) {
      data = opt.data;
    }

    if (10 != startdate.length) {
      var t_date_str = startdate.split('-');
      var f_date_str = [];
      if (3 == t_date_str.length) {
        for (var i = 0, len = t_date_str.length; i < len; i++) {
          if (2 == t_date_str[i].length || 4 == t_date_str[i].length) {
            f_date_str.push(t_date_str[i]);
          } else if (1 == t_date_str[i].length) {
            f_date_str.push('0' + t_date_str[i]);
          }

        }
      }
      startdate = f_date_str.join('-');
    }

    zh_from = y;
    zh_to = m;
    drawCalendarData(y, m - 1, "b", data,opt);
  }

  function drawCalendarData(y, m, id, hqjson,opt, startdate) {

    var month = opt.showMaxMonth - 1;
    if (y > today.getFullYear()
      || (y == today.getFullYear() && m >= today.getMonth() + 1)) {
      $(".cal-pre").off("click").on("click",function(){ajaxhq(yy,mm,opt)}).addClass("clickAble");
    } else {
      $(".cal-pre").off("click").removeClass("clickAble");
    }
    if ((y == today.getFullYear() && m >= today.getMonth() + month)
      || (y > today.getFullYear() && ((Math.abs(today.getMonth() + 1 - m) % 12) <= month))) {
      $(".cal-next").off("click").removeClass("clickAble");
    } else {
      $(".cal-next").off("click").on("click",function(){ajaxhq(yy,mm+2,opt)}).addClass("clickAble");
    }

    var showx = new Date(y, m, 1);
    var showy = showx.getFullYear();
    var showmm = showx.getMonth() + 1;
    if (showmm == 0) {
      showmm = 12;
      showy = new Date(y - 1, m, 1).getFullYear();
    }
    $(".cal-month").text(showy + "年" + (showmm > 9 ? showmm : "0" + showmm) + "月");

    if (startdate != null) {
      var dateArr = startdate.split('-');
      startdate = new Date(parseInt(dateArr[0], 10), parseInt(dateArr[1] - 1,
        10), parseInt(dateArr[2] - 1), 10);
    } else {
      startdate = today;
    }
    var cdate;
    if (today.getTime() < startdate.getTime()) {
      cdate = startdate;
    } else {
      cdate = today;
    }
    var x = new Date(y, m, 1);
    var lowest = 100000;
    var lowobj = new Array();
    var mv = x.getDay();
    var d = x.getDate();
    yy = x.getFullYear();
    mm = x.getMonth();

    for (var i = 1; i <= mv; i++) {
      de = document.getElementById(id + i);
      de.innerHTML = "";
      de.bgColor = "";
    }
    showm = mm + 1;
    showprice = "";
    priceHtml = "";
    febclass = "";
    while (x.getMonth() == mm) {
      de = document.getElementById(id + (d + mv));
      showFulldate = yy + "-" + (showm > 9 ? showm : "0" + showm) + "-"
        + (d > 9 ? d : "0" + d);
      showdate = (d > 9 ? d : "0" + d);
      priceHtml = '';
      surplusHtml = '';
      if (hqjson) {
        if (hqjson[showFulldate]) {
          if (hqjson[showFulldate]["price"]) {
            var showPrice = hqjson[showFulldate]["price"];
            if (lowobj[showPrice]) {
              lowobj[showPrice].push(id + (d + mv));
            }
            else {
              lowobj[showPrice] = [id + (d + mv)];
            }

            priceHtml += showPrice;
          }
          if (hqjson[showFulldate]["surplus"]) {
            var showSurplus = hqjson[showFulldate]["surplus"];
            if (lowobj[showSurplus]) {
              lowobj[showSurplus].push(id + (d + mv));
            }
            else {
              lowobj[showSurplus] = [id + (d + mv)];
            }
            surplusHtml += showSurplus;
          }
        }
      }

      if (x.getFullYear() == today.getFullYear()
        && x.getMonth() == today.getMonth()
        && x.getDate() == today.getDate()) {
        if (surplusHtml) {
          de.innerHTML = '<a class="cal_link" style="display:block;height:100%" data-begin="' + showFulldate + '">' +
            '<span class="date" style="color: #3baae3">' + "今天" + '</span>' +
            '<span class="surplus">' + surplusHtml + '</span>' +
            '<span class="cal-price">' + priceHtml + '</span></a>';
        } else {
          de.innerHTML = '<span class="date" style="color: #3baae3">' + "今天" + '</span>';
        }
      } else if (x.getTime() < cdate.getTime()) {
          de.innerHTML = '<span class="date">' + showdate + '</span>';
      } else {
        if (surplusHtml) {
          de.innerHTML = '<a class="cal_link" style="display:block;height:100%" data-begin="' + showFulldate + '">' +
            '<span class="date">' + showdate + '</span>' +
            '<span class="surplus">' + surplusHtml + '</span>' +
            '<span class="cal-price"> ' + priceHtml + '</span></a>';
        } else {
          de.innerHTML = '<span class="date">' + showdate + '</span>';
        }
      }
      x.setDate(++d);
    }
    while (d + mv <= 42) {
      de = document.getElementById(id + (d + mv));
      de.innerHTML = "<span class='Noprice'>&nbsp;</span>";
      d++;
    }
  }
  $.fn.ptCal = function(options) {

    var ptCalendar = new packageTourCalendar(this, options);

    return ptCalendar.calendarInit();
  }
})(jQuery);