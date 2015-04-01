define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ContactsModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/contacts';
        return window.BASE_URL+'/contacts/'+ this.id;
      } 
    });

  return ContactsModel;

});
