define([
  'underscore',
  'backbone',
  'models/post/PostModel'
], function(_, Backbone, PostModel){

  var PostsCollection = Backbone.Collection.extend({
      
      model: PostModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/posts';
      }        
     
  });

  return PostsCollection;

});
