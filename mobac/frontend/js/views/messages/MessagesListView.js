define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'Bootstrap',
  'Bootbox',
  'timeago',
  'collections/messages/MessagesSummaryCollection',
  'collections/messages/MessagesDatailsCollection',
  'text!templates/messages/messagesTemplate.html',
  'text!templates/messages/messageDetailsTemplate.html',
  'models/messages/MessagesModel'
  ], function($, _, Backbone, Datatable, Bootstrap, Bootbox, timeago, MessagesSummaryCollection, MessagesDatailsCollection, MessagesTemplate, MessageDetailsTemplate, MessagesModel){

    var MessagesView = Backbone.View.extend({

    el : $("#page"),
    events: {
      'click #delmessage': 'deletemessage',
      'click #sendmessage': 'sendmessage'
    },
    initialize : function() {
      _.bindAll(this, 'detect_scroll');
      // bind to window
      $(window).scroll(this.detect_scroll);
      document.getElementById("locationDate").innerHTML = "";
      document.getElementById("logout").innerHTML = "<img src='imgs/logout.jpeg' /> Logout";
      var that = this;
      that.bind("reset", that.clearView);
      /*this.undelegateEvents();
      $(this.el).empty();*/
    },
    detect_scroll: function() {
      if ($(window).scrollTop() == ($(document).height() - window.innerHeight)) {
        var key = $.readCookie("auth-key");
        var messages = new MessagesSummaryCollection(); 
        messages.fetch({
          beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          },
          success: function (messages) {
            var length = $.readCookie("messages-start");
            var newvalue = parseInt(parseInt(length)+10);
            $.createCookie("messages-start", newvalue, 1);
            var newmessages = "";
            messagesData = messages.models[0].attributes.data.messages;
            _.each(messagesData, function(message){
              var oldDate = message.time;
              var a = oldDate.split(/\s/); 
              var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
              var text = message.messageText;
              var data = text.substring(0, 30);
              newmessages += "<li class='media'>" +
                             "<div class='media-body'>" +
                              "<div class='media'>" ;
              if(message.name == null) {
                newmessages = newmessages += "<a  href='#/messages/"+message.fromTo+"'style='font-size:24px;'>"+message.fromTo+"</a>" ;
              } 
              else {
                newmessages = newmessages += "<a  href='#/messages/"+message.fromTo+"'style='font-size:24px;'>"+message.name+"</a>" ;
              } 
              newmessages = newmessages += "<span class='pull-right' style='color:green;'>";
              if(message.count > 1){ 
                newmessages = newmessages += "("+message.count+")" ;
              } 
              newmessages = newmessages += "</span><br/>" + 
                                              data + 
                                          "<span class='pull-right'>"+ 
                                          string + 
                                          "</span></div><hr/></div></li>" ;
            });
            $("#newmessages").append(newmessages);
          }
        });
      }
    },
    sendmessage : function(options){
      var text = $("#messagetext").val();
      $("#messagetext").val("");
      /*console.log(text);*/
    },
    deletemessage:function( options){
      Bootbox.confirm("Do u really want to delete this message?", function(result) {
        if(result){
          var key = $.readCookie("auth-key");
          var that = this;
          
          var rowId = options.target.attributes.value.value;
          
          var message = new MessagesModel({id: rowId});
          
          message.destroy({
            beforeSend: function (xhr) {
                xhr.setRequestHeader('AUTH-KEY', key);
            },
            success: function () {
              
              delete that.message;
              
              delete message;
              Bootbox.alert("Deleted Successfully");
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
      document.getElementById("locationDate").innerHTML = "";
      document.getElementById("logout").innerHTML = "<img src='imgs/logout.jpeg' /> Logout";
      var that = this;
      var options = options;
      var key = $.readCookie("auth-key");
      if(options.number == "" || options.number == "messages" || options.number == undefined){
        var messages = new MessagesSummaryCollection(); 
        messages.fetch({
          beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          },
          success: function (messages) {
            messagesData = messages.models[0].attributes.data.messages;
            var value = messagesData.length;
            $.createCookie("messages-start", value, 1);
            
            /*var aaa = messagesData.sort(function comp(a, b) {
              var oldDate = a.time;
              var a = oldDate.split(/\s/);
              var old = b.time;
              var b = old.split(/\s/);
              return  new Date(b[0]).getTime() - new Date(a[0]).getTime() ;
            });
            console.log(aaa);*/
            var numbers = [];
            _.each(messagesData, function(phone){
              var oldDate = phone.time;
              var a = oldDate.split(/\s/); 
              var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
              numbers.push({"number" : phone.fromTo, "text" : phone.messageText, "name" : phone.name, "time" : string, "count" : phone.count});
            });
            if(numbers == ""){
              that.$el.html("<h3> Sorry No Data Available </h3>");
            }
            var template = _.template(MessagesTemplate, {Numbers: numbers});
            //$('#messages-list-template').html(template); 
            that.$el.html(template);
            return that;
          },
          error: function (messages, response) {
            var status = response.status;
            
            if(status == "401"){
              Bootbox.alert("Please login first");
              window.app_router.navigate('default', {trigger:true});
            }
            else {
              that.$el.html("<h3> Sorry No Data Available </h3>");
            }
          }
        });
      }
      else {
        var mid = options.number ;
        var numbers = [];
        var messages = new MessagesDatailsCollection({id: mid}); 
        messages.fetch({
          beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          },
          success: function (messages) {
            messagesData = messages.models[0].attributes.data.messages;
            _.each(messagesData, function(phone){
              var oldDate = phone.time;
              var a = oldDate.split(/\s/); 
              var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
              numbers.push({"id" : phone.id, "number" : phone.fromTo, "text" : phone.messageText, "time" : string, "type" : phone.type});
            });
            if(numbers == ""){
              that.$el.html("<h3> Sorry No Data Available </h3>");
            }
            var template = _.template(MessageDetailsTemplate, {Numbers: numbers});
            //$('#messages-list-template').html(template); 
            that.$el.html(template);
            return that;
          },
          error: function (messages, response) {
            var status = response.status;
            if(status == "401"){
              Bootbox.alert("Please login first");
              window.app_router.navigate('default', {trigger:true});
            }
            else {
              that.$el.html("<h3> Sorry No Data Available </h3>");
            }
          }
        });
      }    
    }
  });
  return MessagesView;
});
