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
        var start = $.readCookie("callDetails-start");
        if(start==null){
          start = 0;
          limit = 10;
        }
        else {
          start = start; 
          limit = 3;
        }
        return window.BASE_URL+'/callDetails-summary/start='+start+'&limit='+limit;
      }        
     
  });

  return CallDetailsCollection;

});