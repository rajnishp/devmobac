define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var CallDetailsModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/call-details';
        return window.BASE_URL+'/call-details/'+ this.id;
      } 
    });

  return CallDetailsModel;

});
