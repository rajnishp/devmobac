define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'google_maps',
  'collections/locations/LocationsCollection',
  'text!templates/locations/locationsListTemplate.html'
], function($, _, Backbone, Datatable, GoogleMaps, LocationsCollection, locationsListTemplate){
  
  var LocationsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
      that.bind("reset", that.clearView);
      
    },

    render: function () {
      var that = this;
      
      var locations = new LocationsCollection();
      console.log("inside render locations");
      locations.fetch({
        success: function (locations) {
           //defining teplate
        console.log("inside render success");  
        console.log(locations);
        var template = _.template(locationsListTemplate, {locations: locations.models[0].attributes.data.locations});
        //$('#location-list-template').html(template);
        var temp = google.maps.event.addDomListener(that.el, 'load', function () {
var myCenter=new google.maps.LatLng(12.90789,77.693426);
var user1Loc=new google.maps.LatLng(12.90589,77.691426);
var user2Loc=new google.maps.LatLng(12.90689,77.695426);
var user3Loc=new google.maps.LatLng(12.90289,77.694426);
var mapProp = {
  center:myCenter,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var billBoardM = new google.maps.InfoWindow({
  content:"I am bill Board 1"
  });

var userM = new google.maps.Marker({
  content:"I am customer a"
  });

var marker=new google.maps.Marker({
  position:myCenter,
  icon:'blank_billboard_T.png'
  });


var user1=new google.maps.Marker({
  position:user1Loc,
  content:"I am customer 1"
  });
var user2=new google.maps.Marker({
  position:user2Loc,
  color:"#000",
  content:"I am customer 2"
  });
var user3=new google.maps.Marker({
  position:user3Loc,
  icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale:7,
      strokeColor:"red",
    strokeOpacity:0.6,
    strokeWeight:9,
    fillColor:"green",
    fillOpacity:0.4
    },
  content:"I am customer 3"

  });
var myCity = new google.maps.Circle({
  center:myCenter,
  radius:200,
  strokeColor:"#00004F",
  strokeOpacity:0.6,
  strokeWeight:2,
  fillColor:"#00004F",
  fillOpacity:0.4
  });


user1.setMap(map);
user2.setMap(map);
user3.setMap(map);
marker.setMap(map);
billBoardM.open(map,marker);
userM.open(map,user1);
userM.open(map,user2);
userM.open(map,user3);
});
        console.log(temp);
        console.log(template);
        that.$el.html(template);
        $('#locationsTable').DataTable();
        return that;
          }
      });

    },

mapsInitialize  :  function () {
var myCenter=new google.maps.LatLng(12.90789,77.693426);
var user1Loc=new google.maps.LatLng(12.90589,77.691426);
var user2Loc=new google.maps.LatLng(12.90689,77.695426);
var user3Loc=new google.maps.LatLng(12.90289,77.694426);
var mapProp = {
  center:myCenter,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var billBoardM = new google.maps.InfoWindow({
  content:"I am bill Board 1"
  });

var userM = new google.maps.Marker({
  content:"I am customer a"
  });

var marker=new google.maps.Marker({
  position:myCenter,
  icon:'blank_billboard_T.png'
  });


var user1=new google.maps.Marker({
  position:user1Loc,
  content:"I am customer 1"
  });
var user2=new google.maps.Marker({
  position:user2Loc,
  color:"#000",
  content:"I am customer 2"
  });
var user3=new google.maps.Marker({
  position:user3Loc,
  icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale:7,
      strokeColor:"red",
    strokeOpacity:0.6,
    strokeWeight:9,
    fillColor:"green",
    fillOpacity:0.4
    },
  content:"I am customer 3"

  });
var myCity = new google.maps.Circle({
  center:myCenter,
  radius:200,
  strokeColor:"#00004F",
  strokeOpacity:0.6,
  strokeWeight:2,
  fillColor:"#00004F",
  fillOpacity:0.4
  });


user1.setMap(map);
user2.setMap(map);
user3.setMap(map);
marker.setMap(map);
billBoardM.open(map,marker);
userM.open(map,user1);
userM.open(map,user2);
userM.open(map,user3);
}


   
  });
  
  return LocationsListView;

});