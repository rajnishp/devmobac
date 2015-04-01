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
        return window.BASE_URL+'/contacts';
      }        
     
  });

  return ContactsCollection;

});