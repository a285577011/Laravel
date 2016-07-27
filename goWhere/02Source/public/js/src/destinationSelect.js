/**
 * Created by zds on 2015/12/28.
 */
$(function(){
  var destinationData = {
    "data":[{
      "destinationType":"热门",
      "destinationClass":"hot-place",
      "destinations":{
        "destination":["新加坡","普吉岛","曼谷","首尔","东京","清迈","大阪","巴厘岛","济州岛","芭提雅","吉隆坡","京都"
          ,"哥打京那巴鲁","苏梅岛","冲绳","巴黎","甲米","伦敦","纽约","悉尼","洛杉矶","暹粒","墨尔本","札幌"]
      }
    },{
      "destinationType": "亚洲",
      "destinationClass":"asia-place",
      "destinations": {
        "destination": ["新加坡", "普吉岛", "曼谷", "首尔", "东京", "清迈", "大阪", "巴厘岛", "济州岛", "芭提雅", "吉隆坡",
          "京都", "哥打京那巴鲁", "苏梅岛", "冲绳", "甲米", "暹粒", "札幌"]
      }
    },{
      "destinationType": "欧洲",
      "destinationClass":"europe-place",
      "destinations": {
        "destination": ["巴黎", "伦敦", "莫斯科", "米兰", "法兰克福", "罗马", "慕尼黑", "巴塞罗那", "佛罗伦萨", "柏林", "马德里",
          "维也纳", "阿姆斯特丹", "威尼斯", "圣彼得堡", "布拉格", "尼斯", "苏黎世"]
      }
    },{
      "destinationType": "美洲",
      "destinationClass":"america-place",
      "destinations": {
        "destination": ["纽约", "洛杉矶", "拉斯维加斯", "旧金山", "欧胡岛/火奴鲁鲁", "塞班", "温哥华", "多伦多", "芝加哥",
          "华盛顿", "波士顿", "西雅图", "奥兰多", "关岛", "圣迭戈", "迈阿密", "圣保罗", "大岛"]
      }
    },{
      "destinationType": "大洋洲",
      "destinationClass":"oceania-place",
      "destinations": {
        "destination": ["悉尼", "墨尔本", "奥克兰", "黄金海岸", "凯恩斯", "布里斯班", "皇后镇", "柏斯", "阿德莱德", "基督城",
          "维提岛", "罗托鲁瓦", "堪培拉", "特卡波湖", "霍巴特", "坎贝尔港", "科罗尔", "惠灵顿"]
      }
    },{
      "destinationType": "非洲",
      "destinationClass":"africa-place",
      "destinations": {
        "destination": ["毛里求斯", "开罗", "马埃岛", "约翰内斯堡", "内罗毕", "开普敦", "普拉兰", "达累斯萨拉姆", "卡萨布兰卡",
          "亚的斯亚贝巴", "德班", "塞舌尔拉迪戈岛", "桑给巴尔", "卢克索", "普拉兰岛", "突尼斯", "卢萨卡", "亚历山大"]
      }
    },{
      "destinationType": "海岛",
      "destinationClass":"island-place",
      "destinations": {
        "destination": ["普吉岛", "巴厘岛", "济州岛", "马尔代夫", "冲绳", "苏梅岛", "皮皮岛", "欧胡岛/火奴鲁鲁", "长滩岛",
          "兰卡威", "毛里求斯", "塞班岛", "民丹岛", "关岛", "象岛", "热浪岛", "龟岛", "丽贝岛"]
      }
    }]
  };

  var destinationHtml = "",
      htmlTwo = "",
      htmlOne = "",
      destinationDataLen = destinationData.data.length;


  for(i = 0,len = destinationDataLen; i < len; i++) {
    if (i == 0) {
      htmlOne += '<li class="zh-place-li zh-place-li-cur fl">' + destinationData.data[i].destinationType + '</li>'
    } else {
      htmlOne += '<li class="zh-place-li fl">' + destinationData.data[i].destinationType + '</li>'
    }
  }
  for(i = 0,len = destinationDataLen; i < len; i++){
    var htmlTwoInner = "";
    for(j = 0, destinationLen = destinationData.data[i].destinations.destination.length; j < destinationLen;j++){
      htmlTwoInner += '<li class="place-li" title="' + destinationData.data[i].destinations.destination[j] + '">'
        + destinationData.data[i].destinations.destination[j] + '</li>'
    }
    if( i == 0) {
      htmlTwo += '<ul class="' + destinationData.data[i].destinationClass + ' place-ul clear">' + htmlTwoInner + '</ul>';
    } else {
      htmlTwo += '<ul class="' + destinationData.data[i].destinationClass + ' place-ul clear hide">' + htmlTwoInner + '</ul>';
    }
  }

  destinationHtml += '<div class="place-select hide">' +
                        '<div class="fl place-select-tips">请选择地点</div>' +
                        '<div class="close"><i class="iconfont icon-close"></i></div>' +
                        '<div class="clear"></div>' +
                        '<div class="zh-place-select-option">' +
                          '<ul class="zh-place-ul clear">' + htmlOne +
                          '</ul>' +
                        '</div>' +
                        '<div class="zh-place-select-option-main">' + htmlTwo +
                        '</div>' +
                        /*'<p class="place-select-tips2">更多城市可直接输入搜索</p>' +*/
                      '</div>';

  //目的地下拉框选择
  $(document).on("click",".destination-select",function(){
    var $this = $(this);
    var thisState = parseInt($this.attr("data-state"));

    if(thisState) {
      $this.attr("data-state",0).after(destinationHtml).closest("div").css("position","relative");
    }

    $(".destination-select").each(function(){
      var $newThis = $(this);
      if($newThis.is($this)){
        $this.siblings(".place-select").removeClass("hide").attr("data-show","true");
      }else{
        $newThis.siblings(".place-select").addClass("hide");
      }
    });

  });

  $(document).on("input propertychange",".destination-select",function() {
    var $this = $(this);
    $this.siblings(".place-select").addClass("hide").siblings(".specific-select").removeClass("hide");
  });

  $(document).on("click",".close",function () {
    $(this).closest(".place-select").addClass("hide");
  });

  $(document).on("click",".zh-place-li",function () {
    var $this = $(this),
        $continentsList = $this.closest(".zh-place-select-option").siblings(".zh-place-select-option-main");
    var txt = $this.text();
    if ($this.hasClass("zh-place-li-cur")) {
      return false;
    } else {
      $this.addClass("zh-place-li-cur").siblings("li").removeClass("zh-place-li-cur");
      if (txt == "热门") {
        $continentsList.find(".hot-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "亚洲") {
        $continentsList.find(".asia-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "欧洲") {
        $continentsList.find(".europe-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "美洲") {
        $continentsList.find(".america-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "大洋洲") {
        $continentsList.find(".oceania-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "非洲") {
        $continentsList.find(".africa-place").removeClass("hide").siblings("ul").addClass("hide");
      } else if (txt == "海岛") {
        $continentsList.find(".island-place").removeClass("hide").siblings("ul").addClass("hide");
      }
    }
  });

  $(document).on("click",".place-li",function(){
    var $this = $(this),
        place = $this.text();
    $this.closest(".place-select").siblings(".destination-select").val(place);
    $(".place-select").addClass("hide");
  });

});




