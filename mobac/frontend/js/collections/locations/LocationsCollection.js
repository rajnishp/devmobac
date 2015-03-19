define([
  'underscore',
  'backbone',
  'models/location/LocationModel'
], function(_, Backbone, LocationModel){

  var LocationsCollection = Backbone.Collection.extend({
      
      model: LocationModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/locations';
      }        
     
  });

  return LocationsCollection;

});
