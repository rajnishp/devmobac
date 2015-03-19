define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/locations/LocationsCollection',
  'text!templates/locations/locationsListTemplate.html'
], function($, _, Backbone, Datatable, LocationsCollection, locationsListTemplate){
  
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
        $('#location-list-template').html(template); 
        console.log(template);
        that.$el.html(template);
        $('#locationsTable').DataTable();
        return that;
          }
      });

    }
   
  });
  
  return LocationsListView;

});

