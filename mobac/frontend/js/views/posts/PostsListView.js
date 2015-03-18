define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/posts/PostsCollection',
  'text!templates/posts/postsListTemplate.html'
], function($, _, Backbone, Datatable, PostsCollection, postsListTemplate){
  
  var PostsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
      that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var posts = new PostsCollection();
      console.log("inside render");
      posts.fetch({
        success: function (posts) {
           //defining teplate
        console.log("inside render success");  
        console.log(posts);
        var template = _.template(postsListTemplate, {posts: posts.models[0].attributes.data.posts});
        $('#post-list-template').html(template); 
        console.log(template);
        that.$el.html(template);
        $('#postsTable').DataTable();
        return that;
          }
      });

    }
   
  });


  
  return PostsListView;

});

