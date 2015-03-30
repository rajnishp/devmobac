define([
  'jquery',
  'underscore',
  'backbone',
  'Bootstrap',
  'Bootbox',
  'google_maps',
  'collections/locations/LocationsCollection',
  'text!templates/locations/locationsTemplate.html'
], function($, _, Backbone, Bootstrap, Bootbox, GoogleMaps, LocationsCollection, locationsTemplate){
  
 var MapView = Backbone.View.extend({

    el : $("#page"),
    initialize : function() {
      document.getElementById("logout").innerHTML = "<img src='imgs/logout.jpeg' /> Logout";
      var that = this;
    },

    render: function (options) {
      var that = this;
      var locations = new LocationsCollection();
      
      var key = $.readCookie("auth-key");
      locations.fetch({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('AUTH-KEY', key);
        },
        success: function (locations) {
          Date.prototype.yyyymmdd = function() {
           var yyyy = this.getFullYear().toString();
           var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
           var dd  = this.getDate().toString();
           return yyyy +'-'+ (mm[1]?mm:"0"+mm[0]) +'-'+ (dd[1]?dd:"0"+dd[0]); // padding
          };
          var today = new Date().yyyymmdd();
          var template = _.template(locationsTemplate, {locations: locations.models[0].attributes.data.locations});
          $('#locations-list-template').html(template); 
          that.$el.html(template);
          locationData = locations.models[0].attributes.data.locations ;
          $("#locationDate").html("");
          if(options.date == undefined){
            
            var center = new google.maps.LatLng(locationData[0].latitude, locationData[0].longitude);
            var mapOptions = {
                              center: center,
                              zoom: 12,
                              mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
            var loc = new google.maps.Marker({
                          position:center,
                          icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale:10,
                            strokeColor:"red",
                            strokeOpacity:0.6,
                            strokeWeight:9,
                            fillColor:"green",
                            fillOpacity:0.4
                          },
                          title : locationData[0].fromTime
                        });
            var map = new google.maps.Map($('#map_canvas')[0], mapOptions);
            loc.setMap(map);
            
            for (i = 0; i < (locationData.length-1); i++) {
              
              var date = locationData[i].fromTime.split(' ')[0];
              if(today == date){
                var newcenter = new google.maps.LatLng(locationData[i].latitude, locationData[i].longitude);
              
                var newloc = new google.maps.Marker({
                            position:newcenter,
                            icon: {
                              path: google.maps.SymbolPath.CIRCLE,
                              scale:10,
                              strokeColor:"red",
                              strokeOpacity:0.6,
                              strokeWeight:9,
                              fillColor:"green",
                              fillOpacity:0.4
                            },
                            title : locationData[i].fromTime
                          });
               
                newloc.setMap(map);
              }
              if(center == "" || center == undefined || center == null){
                Bootbox.alert("No locations available");
              }
                      
              var infowindow = new google.maps.InfoWindow({
                content: locations.models[0].attributes.data.locations[0].fromTime
              });
              google.maps.event.addListener(loc, 'click', function() {
                infowindow.open(map,loc);
              });
            }
          }
          else {
            var mylocation = [];
            for (i = 0; i < (locationData.length); i++) {
              var date = locationData[i].fromTime.split(' ')[0];
              if(options.date == date){
                if(locationData[i].latitude == 0.000000 && locationData[i].longitude == 0.000000){
                  break;
                  Bootbox.alert("No locations available for this date"); 
                }
                else {     
                  var mylocation = new google.maps.LatLng(locationData[i].latitude, locationData[i].longitude);
                  var mapOptions = {
                                    center: mylocation,
                                    zoom: 12,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                  };
                  var loc = new google.maps.Marker({
                                position:center,
                                icon: {
                                  path: google.maps.SymbolPath.CIRCLE,
                                  scale:10,
                                  strokeColor:"red",
                                  strokeOpacity:0.6,
                                  strokeWeight:9,
                                  fillColor:"green",
                                  fillOpacity:0.4
                                },
                                title : locationData[i].fromTime
                              });
                  var map = new google.maps.Map($('#map_canvas')[0], mapOptions);
                  loc.setMap(map);
                  var infowindow = new google.maps.InfoWindow({
                    content: locations.models[0].attributes.data.locations[0].fromTime
                  });
                  google.maps.event.addListener(loc, 'click', function() {
                    infowindow.open(map,loc);
                  });
                  break;
                }
              }
            }
            for (i = 0; i < (locationData.length); i++) {
              var date = locationData[i].fromTime.split(' ')[0];
              if(options.date == date){
                var newcenter = new google.maps.LatLng(locationData[i].latitude, locationData[i].longitude);
              
                var newloc = new google.maps.Marker({
                            position:newcenter,
                            icon: {
                              path: google.maps.SymbolPath.CIRCLE,
                              scale:10,
                              strokeColor:"red",
                              strokeOpacity:0.6,
                              strokeWeight:9,
                              fillColor:"green",
                              fillOpacity:0.4
                            },
                            title : locationData[i].fromTime
                          });
               
                newloc.setMap(map);
              }
            }
          }
          Date.prototype.ddmmyyyy = function() {
           var yyyy = this.getFullYear().toString();
           var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
           var dd  = this.getDate().toString();
           return (dd[1]?dd:"0"+dd[0]) +'-'+ (mm[1]?mm:"0"+mm[0]) +'-'+ yyyy; // padding
          };
          for(i=0; i<7; i++){
            var newDate = new Date();
            var dd = newDate.getDate();
            var day = new Date(newDate.setDate(dd - i));
            var date = day.yyyymmdd();
            if(date == today){
              var view = 'Today';
            }
            else {
              var view = day.ddmmyyyy();
            }
            $("#locationDate").append('<a href="#/locations/'+date+'" >'+view+'</a><br/>');
          }

          if(mylocation == ""){
            Bootbox.alert("No locations available for this date");
          }
          return map;
        },
        error: function (locations, response) {
          var status = response.status;
          if(status == "401"){
            Bootbox.alert("Please login first");
            window.app_router.navigate('default', {trigger:true});
          }
          else {
            Bootbox.alert("Please try again");
          }
        }
      });
    }
  });
        
  return MapView;
});