define([
  'jquery',
  'underscore',
  'backbone',
  'models/post/PostModel',
  'text!templates/posts/postEditTemplate.html'
  ], function($, _, Backbone, PostModel, postEditTemplate){

    var PostEditView = Backbone.View.extend({

     el : $("#page"),
     events: {
      'submit .edit-post-form': 'savePost',
      'click #delpost': 'deletePost'
    },

    initialize : function() {

      var that = this;
      console.log("i am in PostEditView");
      that.bind("reset", that.clearView);
    },

    savePost: function (ev) {
      var that = this;
      console.log("savePost");
      console.log(this);
      var postDetails = {};
        //console.log(ev.currentTarget);
      postDetails.root = $(ev.currentTarget).serializeObject1();

      if(this.post != null)
        var post = new PostModel({id: this.post.id});
      else
        var post = new PostModel({id: null});
      
      console.log(postDetails);
      
      post.save(postDetails,{

        success: function (post) {
          console.log(post.toJSON);
          alert(" added successfuly");
          that.bind("reset", that.clearView);
          //that.render({id: null});

          delete post;
          delete this.post;
          window.app_router.navigate('posts', {trigger:true});
          
        },
        error: function (postDetails,response) {

          console.log(JSON.parse(response.responseText));
          alert(JSON.parse(response.responseText).internal_status.message );



        }

      });
      return false;
    },
      deletePost: function (ev) {
        var that = this;
        
        this.post.destroy({
          success: function () {
            console.log('destroyed');
            
            delete that.post;
            
            delete post;
            
            window.app_router.navigate('posts', {trigger:true});
            //router.navigate('', {trigger:true});
          }
        })
      },

      render: function (options) {

        var that = this;
        if(options.id) {

          that.post = new PostModel({id: options.id});
          that.post.fetch({
            success: function (post) {

              console.log(post.attributes.data.posts);

              var template = _.template(postEditTemplate, {post: post.attributes.data.posts[0]});
              //#edit-organization-template
              $('#edit-post-template').html(template);
              that.$el.html(template);
              return that;
            }
          })
        } else {
          var template = _.template(postEditTemplate, {post: null});
          $('#edit-post-template').html(template);
          that.$el.html(template);
          return that;
        }
      }

    });

return PostEditView;

});
