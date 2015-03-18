define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var PostModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/posts';
        return window.BASE_URL+'/posts/'+ this.id;
      } 
    });

  return PostModel;

});
