define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'google_maps',
  'collections/locations/LocationsCollection',
  'text!templates/locations/locationsTemplate.html'
], function($, _, Backbone, Datatable, GoogleMaps, LocationsCollection, locationsTemplate){
  
 var MapView = Backbone.View.extend({

    el : $("#page"),
    initialize : function() {
      var that = this;
    },

    render: function () {
      var that = this;
      var locations = new LocationsCollection();
      
      locations.fetch({
        success: function (locations) {
         
          var template = _.template(locationsTemplate, {locations: locations.models[0].attributes.data.locations});
          $('#locations-list-template').html(template); 
          that.$el.html(template);
          locationData = locations.models[0].attributes.data.locations ;
          var center = new google.maps.LatLng(locationData[locationData.length-1].latitude, locationData[locationData.length-1].longitude);
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
                        title : locationData[locationData.length-1].fromTime
                      });
          var map = new google.maps.Map($('#map_canvas')[0], mapOptions);
          loc.setMap(map);
          for (i = 0; i < locationData.length-1; i++) {
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
          var infowindow = new google.maps.InfoWindow({
            content: locations.models[0].attributes.data.locations[0].fromTime
          });
          google.maps.event.addListener(loc, 'click', function() {
            infowindow.open(map,loc);
          });
          return map;
        }
      });
    }
  });
        
  return MapView;
});