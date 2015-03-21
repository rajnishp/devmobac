define([
  'jquery',
  'underscore',
  'backbone',
  'collections/messages/MessagesCollection',
  'text!templates/messages/messagesTemplate.html',
  'text!templates/messages/messageDetailsTemplate.html'
  ], function($, _, Backbone, MessagesCollection, MessagesTemplate, MessageDetailsTemplate){

    var MessagesView = Backbone.View.extend({

     el : $("#page"),
     initialize : function() {
     
      var that = this;
      
      that.bind("reset", that.clearView);
    },

    render: function (options) {
      var that = this;
      var options = options;
      var messages = new MessagesCollection();
      console.log(options);
      messages.fetch({
        success: function (messages) {
          messagesData = messages.models[0].attributes.data.messages;
          if(options.number == "" || options.number == "messages" || options.number == undefined){
              var numbers = [];
              var flag = 0;
              _.each(messagesData, function(phone){
                var that = this;
                for (i = 0; i < numbers.length; i++) { 
                    if (numbers[i].number == phone.fromTo ) {
                      flag = 1;
                      break;
                    }
                }
                if(flag == 0)
                  numbers.push({"number" : phone.fromTo, "name" : phone.time, "count" : 1});
                else
                  numbers[i].count = numbers[i].count + 1;
                flag = 0;

              });

              var template = _.template(MessagesTemplate, {Numbers: numbers});
              $('#messages-list-template').html(template); 
              
              that.$el.html(template);
              $('#messagesTable').DataTable();
            }
          else {
            var Details = [];
            _.each(messagesData, function(detail){
              var that = this;
              if (options.number == detail.fromTo ) {
                Details.push({"id" : detail.id, "fromTo" : detail.fromTo, "messageText" : detail.messageText, "time" : detail.time, "type" : detail.type});
              }
            });
            var template = _.template(MessageDetailsTemplate, {Details: Details});
            $('#MessageDetails-list-template').html(template); 
            
            that.$el.html(template);
            $('#messageDetailsTable').DataTable();

          } 
          return that;
        }
      });

    }
   
  });


  
  return MessagesView;

});
