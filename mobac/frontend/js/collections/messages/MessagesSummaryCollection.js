define([
  'underscore',
  'backbone',
  'models/messages/MessagesModel'
], function(_, Backbone, MessagesModel){

  var MessagesCollection = Backbone.Collection.extend({
      
      model: MessagesModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        var start = $.readCookie("messages-start");
        if(start==null){
          start = 0;
          limit = 10;
        }
        else {
          start = start; 
          limit = 10;
        }
        return window.BASE_URL+'/messages-summary?start='+start+'&limit='+limit;
      }        
     
  });

  return MessagesCollection;

});