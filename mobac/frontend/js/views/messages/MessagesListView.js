define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'Bootstrap',
  'Bootbox',
  'timeago',
  'collections/messages/MessagesCollection',
  'text!templates/messages/messagesTemplate.html',
  'text!templates/messages/messageDetailsTemplate.html',
  'models/messages/MessagesModel'
  ], function($, _, Backbone, Datatable, Bootstrap, Bootbox, timeago, MessagesCollection, MessagesTemplate, MessageDetailsTemplate, MessagesModel){

    var MessagesView = Backbone.View.extend({

     el : $("#page"),
     events: {
      'click #delmessage': 'deletemessage',
      'click #sendmessage': 'sendmessage'
     },
     initialize : function() {
      document.getElementById("logout").innerHTML = '<a href="#/logout">Log Out </a>';
      var that = this;
      that.bind("reset", that.clearView);
    },
    sendmessage : function(options){
      var text = $("#messagetext").val();
      $("#messagetext").val("");
      console.log(text);
    },
    deletemessage:function( options){
      Bootbox.confirm("Do u really want to delete this message?", function(result) {
        if(result){
          var key = $.readCookie("auth-key");
          var that = this;
          console.log(options);
          var rowId = options.target.attributes[1].value;
          
          var message = new MessagesModel({id: rowId});
          
          message.destroy({
            beforeSend: function (xhr) {
                xhr.setRequestHeader('AUTH-KEY', key);
            },
            success: function () {
              
              delete that.message;
              
              delete message;
              Bootbox.alert("Deleted Successfully");
              //Backbone.history.loadUrl();
              window.app_router.navigate('messages', {trigger:true}); 
            },
            error: function (response) {
              Bootbox.alert("Please try again");
            }
          });
        }
      });
    },
       
    render: function (options) {
      var that = this;
      var options = options;
      var messages = new MessagesCollection();
      var key = $.readCookie("auth-key"); 
      messages.fetch({
     
        beforeSend: function (xhr) {
            xhr.setRequestHeader('AUTH-KEY', key);
        },
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
                  var a = oldDate.split(/\s/); 
                  //var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
                  var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
                  if(phone.fromTo != "")
                    numbers.push({"number" : phone.fromTo, "text" : phone.messageText, "name" : string, "count" : 1});
                }
                else
                  numbers[i].count = numbers[i].count + 1;
                flag = 0;
              });
              if(numbers == ""){
                Bootbox.alert("Sorry No Data Available");
              }
              var template = _.template(MessagesTemplate, {Numbers: numbers});
              $('#messages-list-template').html(template); 
              
              that.$el.html(template);
              //$('#messagesTable').DataTable();
            }
          else {
            var Details = [];
            _.each(messagesData, function(detail){
              var that = this;
              if (options.number == detail.fromTo ) {
                var oldDate = detail.time;
                //var a = oldDate.split(/-|\s|:/); 
                var a = oldDate.split(/\s/); 
                //var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
                var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
                if(detail.fromTo != "") 
                  Details.push({"id" : detail.id, "fromTo" : detail.fromTo, "messageText" : detail.messageText, "time" : string, "type" : detail.type});
              }
            });
            if(Details == ""){
                Bootbox.alert("Sorry No Data Available");
             }
            var template = _.template(MessageDetailsTemplate, {Details: Details});
            $('#messageDetails-list-template').html(template); 
            
            that.$el.html(template);
            //$('#messageDetailsTable').DataTable();

          }
          $("#tab1").addClass("active");
          $("#tab2").removeClass("active");
          $("#tab3").removeClass("active");
          $("#locationDate").html(""); 
          return that;
        },
        error: function (messages, response) {
          var status = response.status;
          console.log(response);
          if(status == "401"){
            Bootbox.alert("Please login first");
            document.getElementById("logout").innerHTML = "";
            window.app_router.navigate('default', {trigger:true});
          }
          else {
            Bootbox.alert("Please try again");
          }
        }
      });

    }
   
  });

  return MessagesView;

});
