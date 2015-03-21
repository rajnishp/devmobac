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
      console.log("inside render");
      locations.fetch({
        success: function (locations) {
         //defining teplate
          console.log("inside render success");  
          console.log(locations);
          var template = _.template(locationsTemplate, {locations: locations.models[0].attributes.data.locations});
          $('#locations-list-template').html(template); 
          console.log(template);
          console.log(locations.models[0].attributes.data.locations[0].fromTime);
          that.$el.html(template);
          var center = new google.maps.LatLng(locations.models[0].attributes.data.locations[0].latitude, locations.models[0].attributes.data.locations[0].longitude);
          var mapOptions = {
                            center: center,
                            zoom: 16,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                          };
          var loc1 = new google.maps.Marker({
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
                        title : locations.models[0].attributes.data.locations[0].fromTime
                      });
          var map = new google.maps.Map($('#map_canvas')[0], mapOptions);
          loc1.setMap(map);
          var infowindow = new google.maps.InfoWindow({
            content: locations.models[0].attributes.data.locations[0].fromTime
          });
          google.maps.event.addListener(loc1, 'click', function() {
            infowindow.open(map,loc1);
          });

        // $('#locationsTable').createMap();
          return map;
        }
      });
    }
  });
        
  return MapView;
});