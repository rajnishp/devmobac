define([
  'jquery',
  'underscore',
  'backbone',
  'collections/messages/MessagesCollection',
  'text!templates/messages/messagesTemplate.html',
  'text!templates/messages/messageDetailsTemplate.html',
  'models/messages/MessagesModel'
  ], function($, _, Backbone, MessagesCollection, MessagesTemplate, MessageDetailsTemplate, MessagesModel){

    var MessagesView = Backbone.View.extend({

     el : $("#page"),
     events: {
      'click #delmessage': 'deletemessage'
     },
     initialize : function() {
     
      var that = this;
      
      that.bind("reset", that.clearView);
    },
    deletemessage: function (options) {
      var that = this;
      
      var rowId = options.target.attributes[1].value;
      
      var message = new MessagesModel({id: rowId});
      
      message.destroy({
        success: function () {
          
          delete that.message;
          
          delete message;
          window.app_router.navigate('messages', {trigger:true}); 
        }
      });
    },
    render: function (options) {
      var that = this;
      var options = options;
      var messages = new MessagesCollection();
      
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
                if(flag == 0){
                  var oldDate = phone.time;
                  var a = oldDate.split(/-|\s|:/); 
                  var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
                  numbers.push({"number" : phone.fromTo, "name" : date, "count" : 1});
                }
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
                var oldDate = detail.time;
                var a = oldDate.split(/-|\s|:/); 
                var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]); 
                
                Details.push({"id" : detail.id, "fromTo" : detail.fromTo, "messageText" : detail.messageText, "time" : date, "type" : detail.type});
              }
            });
            var template = _.template(MessageDetailsTemplate, {Details: Details});
            $('#messageDetails-list-template').html(template); 
            
            that.$el.html(template);
            $('#messageDetailsTable').DataTable();

          }
          $("#locationDate").html(""); 
          return that;
        }
      });

    }
   
  });


  
  return MessagesView;

});
