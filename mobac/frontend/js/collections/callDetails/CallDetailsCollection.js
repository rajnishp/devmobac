define([
  'underscore',
  'backbone',
  'models/callDetails/CallDetailsModel'
], function(_, Backbone, CallDetailsModel){

  var CallDetailsCollection = Backbone.Collection.extend({
      
      model: CallDetailsModel,

      initialize : function(models, options) {

        console.log("starting CallDetails");
      },
      
      url : function() {
        return window.BASE_URL+'/callDetails';
      }        
     
  });

  return CallDetailsCollection;

});