define([
  'underscore',
  'backbone',
  'models/callDetails/CallDetailsModel'
], function(_, Backbone, CallDetailsModel){

  var CallDetailsCollection = Backbone.Collection.extend({
      
      model: CallDetailsModel,

      initialize : function(models, options) {
        this.id = models.id ;
        console.log("starting CallDetails");
      },
      
      url : function() {
        return window.BASE_URL+'/callDetail-details/'+this.id;
      }        
     
  });

  return CallDetailsCollection;

});