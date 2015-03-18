// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/posts/PostsListView',
    'views/posts/PostEditView',
    
], function ($, _, Backbone,
        PostsListView,
        PostEditView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            
            'edit/:id': 'editPost',
            'new': 'editPost',
            // Default
            '*actions': 'defaultAction'

        }
    });

    window.BASE_URL = 'http://api.loc.dpower4.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function (actions) {

            // We have no matching route, lets display the home page
            console.log("defaultAction");
            var postsListView = new PostsListView();
            postsListView.render();
        });

        var postEditView = new PostEditView();
        app_router.on('route:editPost', function (id) {

            // We have no matching route, lets display the home page
            console.log("edit PostEditView");

            postEditView.render({id: id});
        });


        // Unlike the above, we don't call render on this view as it will handle
        // the render call internally after it loads data. Further more we load it
        // outside of an on-route function to have it loaded no matter which page is
        // loaded initially.
        //var footerView = new FooterView();

        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
