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
        return window.BASE_URL+'/messages-summary';
      }        
     
  });

  return MessagesCollection;

});