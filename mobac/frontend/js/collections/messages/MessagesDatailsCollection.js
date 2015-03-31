define([
  'underscore',
  'backbone',
  'models/messages/MessagesModel'
], function(_, Backbone, MessagesModel){

  var MessagesCollection = Backbone.Collection.extend({
      
      model: MessagesModel,

      initialize : function(models, options) {
        this.id = models.id;
        console.log("starting Collections");
      },
      
      url : function() {
        console.log(this.id);
        return window.BASE_URL+'/message-details/'+this.id;
      }        
     
  });

  return MessagesCollection;

});