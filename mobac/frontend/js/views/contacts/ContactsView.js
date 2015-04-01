define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'Bootstrap',
  'Bootbox',
  'timeago',
  'collections/contacts/ContactsCollection',
  'text!templates/contacts/contactsTemplate.html',
  'models/contacts/ContactsModel'
  ], function($, _, Backbone, Datatable, Bootstrap, Bootbox, timeago, ContactsCollection, ContactsTemplate, ContactsModel){

    var ContactsView = Backbone.View.extend({
    
     el : $("#page"),
     
     initialize : function() {
      var that = this;
      document.getElementById("locationDate").innerHTML = "";
      document.getElementById("logout").innerHTML = "<img src='imgs/logout.jpeg' /> Logout";
      that.bind("reset", that.clearView);
     },
    render: function (options) {
      var that = this;
      var options = options; 
      var contacts = new ContactsCollection();
      var key = $.readCookie("auth-key");
      contacts.fetch({
        
        beforeSend: function (xhr) {
            xhr.setRequestHeader('AUTH-KEY', key);
        } ,
        success: function (contacts) {  
          contactsData = contacts.models[0].attributes.data.contacts;
          var Details = [];
          _.each(contactsData, function(detail){
            var that = this;
            var oldDate = detail.lastUpdateTime;
            var a = oldDate.split(/\s/); 
            //var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
            var string = $.timeago(a[0]+"T"+a[1]+"Z");//String(date).substring(0, 25);
            Details.push({'name': detail.name, "number" : detail.phone, "time" : string});
          });
          var template = _.template(ContactsTemplate, {Details: Details});
          //$('#PhoneDetails-list-template').html(template); 
          that.$el.html(template);
          //$('#phoneDetailsTable').DataTable();
          return that;
        },
        error: function (contacts, response) {
          var status = response.status;
          
          if(status == "401"){
            Bootbox.alert("Please login first");
            window.app_router.navigate('default', {trigger:true});
          }
          else {
            Bootbox.alert("Please try again");
          }
        }
      });

    }
   
  });
  
  return ContactsView;

});
