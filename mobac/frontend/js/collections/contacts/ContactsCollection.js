define([
  'underscore',
  'backbone',
  'models/contacts/ContactsModel'
], function(_, Backbone, ContactsModel){

  var ContactsCollection = Backbone.Collection.extend({
      
      model: ContactsModel,

      initialize : function(models, options) {
        
        console.log("starting contacts");
      },
      
      url : function() {
        var start = $.readCookie("contacts-start");
        if(start==null){
          start = 0;
          limit = 10;
        }
        else {
          start = start; 
          limit = 3;
        }
        return window.BASE_URL+'/contacts?start='+start+'&limit='+limit;
      }        
     
  });

  return ContactsCollection;

});