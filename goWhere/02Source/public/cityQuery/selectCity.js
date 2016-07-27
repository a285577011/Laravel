/**
 * Created by zds on 2016/6/29.
 */
$(function() {
  var labelFromcity = new Array();
  labelFromcity ['热门城市'] = new Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40);
  labelFromcity ['A-F'] = new Array(0,3,4,5,6,28,29);
  labelFromcity ['G-J'] = new Array(1,7,8,9,30,31,32,33,37,40);
  labelFromcity ['K-N'] = new Array(10,11,12,34,35,38);
  labelFromcity ['P-W'] = new Array(13,14,15,16,17,18,22,24,25,36);
  labelFromcity ['X-Z'] = new Array(2,19,20,21,26,27,39);
  labelFromcity ['国际城市'] = new Array(41,42,43,44,45,46,47,48,49);
  var hotList = new Array(14,15,16,17,18,19);

    $("#selectCity").querycity({'data':citysFlight,'tabs':labelFromcity,'hotList':hotList});

});