define([
  'jquery',
  'underscore',
  'backbone',
  'collections/messages/MessagesCollection',
  'text!templates/messages/messagesTemplate.html'
  ], function($, _, Backbone, MessagesCollection, MessagesTemplate){

    var MessagesView = Backbone.View.extend({

     el : $("#page"),
     initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
      that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var messages = new MessagesCollection();
      console.log("inside render");
      messages.fetch({
        success: function (messages) {
           //defining teplate
        console.log("inside render success");  
        console.log(messages);
        var template = _.template(MessagesTemplate, {messages: messages.models[0].attributes.data.messages});
        $('#messages-list-template').html(template); 
        console.log(template);
        that.$el.html(template);
        $('#messagesTable').DataTable();
        return that;
          }
      });

    }
   
  });


  
  return MessagesView;

});
