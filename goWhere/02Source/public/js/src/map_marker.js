/**
 * Created by zds on 2015/12/14.
 */
function initialize() {
  var mapProp = {
    center: new google.maps.LatLng(51.508742, -0.120850),
    zoom: 6,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
  var markersArr = [];
  var infowindowArr = [];
  var markers = {
    "latLng": [
      {
        "num": "0",
        "lat": "52.008742",
        "lng": "-0.120850",
        "marker_blue": "../images/map_marker/map_blue_01.png",
        "marker_cur": "../images/map_marker/map_orange_01.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      },
      {
        "num": "1",
        "lat": "51.508642",
        "lng": "-0.120750",
        "marker_blue": "../images/map_marker/map_blue_02.png",
        "marker_cur": "../images/map_marker/map_orange_02.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      },
      {
        "num": "2",
        "lat": "51.008542",
        "lng": "-0.120650",
        "marker_blue": "../images/map_marker/map_blue_03.png",
        "marker_cur": "../images/map_marker/map_orange_03.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      }
    ]
  };

  for (i = 0, len = markers.latLng.length; i < len; i++) {
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(markers.latLng[i].lat, markers.latLng[i].lng),
      icon: markers.latLng[i].marker_blue,
      num: markers.latLng[i].num
    });
    marker.setMap(map);
    var contentString = '<div id="map-tips" class="map-tips clear">' +
      '<img src="' + markers.latLng[i].hotel_img + '">' +
      '<p><span>' + markers.latLng[i].hotel_name +'</span></p>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content:contentString
    });

    infowindowArr.push(infowindow);
    markersArr.push(marker);
    marker.addListener("mouseover", function () {
      var num = $(this)[0].num;
      $(this)[0].setIcon(markers.latLng[num].marker_cur);
      infowindowArr[num].open(map,markersArr[num]);
    });
    marker.addListener("mouseout", function () {
      var num = $(this)[0].num;
      $(this)[0].setIcon(markers.latLng[num].marker_blue);
      infowindowArr[num].close(map,markersArr[num]);
    });
  }

  $(".hotel-search-sort-result-li").mouseenter(function () {
    var num = $(this).data("num");
    var center = new google.maps.LatLng(markers.latLng[num].lat, markers.latLng[num].lng);
    map.setCenter(center);
    markersArr[num].setIcon(markers.latLng[num].marker_cur);

  }).mouseleave(function(){
    var num = $(this).data("num");
    markersArr[num].setIcon(markers.latLng[num].marker_blue);
  });
}
google.maps.event.addDomListener(window, 'load', initialize);