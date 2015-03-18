define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var LocationModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/locations';
        return window.BASE_URL+'/locations/'+ this.id;
      } 
    });

  return LocationModel;

});
