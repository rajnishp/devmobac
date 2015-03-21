define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var MessagesModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/messages';
        return window.BASE_URL+'/messages/'+ this.id;
      } 
    });

  return MessagesModel;

});
