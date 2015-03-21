define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'google_maps',
  
  'collections/locations/LocationsCollection',
  'text!templates/locations/locationsListTemplate.html'
], function($, _, Backbone, Datatable, GoogleMaps,  LocationsCollection, locationsListTemplate){
var MapView = Backbone.View.extend({
museums : [
  {
    title: "Walker Art Center",
    lat: 44.9796635,
    lng: -93.2748776,
    type: 'museum'
  },
  {
    title: "Science Museum of Minnesota",
    lat: 44.9429618,
    lng: -93.0981016,
    type: 'museum'
  },
  {
    title: "The Museum of Russian Art",
    lat: 44.9036337,
    lng: -93.2755413,
    type: 'museum'
  }
],

bars : [
  {
    title: "Park Tavern",
    lat: 44.9413272,
    lng: -93.3705791,
    type: 'bar'
  },
  {
    title: "Chatterbox Pub",
    lat: 44.9393882,
    lng: -93.2391039,
    type: 'bar'
  },
  {
    title: "Acadia Cafe",
    lat: 44.9709853,
    lng: -93.2470717,
    type: 'bar'
  }
],


Location : Backbone.GoogleMaps.Location.extend({
  idAttribute: 'title',
  defaults: {
    lat: 12.90789,
    lng: 77.693426
  }
}),

LocationCollection : Backbone.GoogleMaps.LocationCollection.extend({
  model: this.Location
}),

InfoWindow : Backbone.GoogleMaps.InfoWindow.extend({
  template: '#infoWindow-template',

  events: {
    'mouseenter h2': 'logTest'
  },

  logTest: function() {
    console.log('test in InfoWindow');
  }
}),

init : function() {
  this.createMap();

  this.places = new this.LocationCollection();

  // Render Markers
  var markerCollectionView = new this.MarkerCollectionView({
    collection: this.places,
    map: this.map
  });
  markerCollectionView.render();

  // Render ListView
  var listView = new this.ListView({
    collection: this.places
  });
  listView.render();
},

createMap : function() {
  var mapOptions = {
    center: new google.maps.LatLng(12.90789, 77.693426),
    zoom: 16,
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale:7,
      strokeColor:"red",
    strokeOpacity:0.6,
    strokeWeight:9,
    fillColor:"green",
    fillOpacity:0.4
    },
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  // Instantiate map
  this.map = new google.maps.Map($('#map_canvas')[0], mapOptions);
},

});
  
  return MapView;
});