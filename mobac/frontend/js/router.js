// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/messages/MessagesListView',
    'views/posts/PostEditView',
    'views/locations/MapView',
    'models/location/Map'
    
], function ($, _, Backbone,
        MessagesListView,
        PostEditView,
        MapView,
        Map
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            
            'edit/:id': 'editPost',
            'new': 'editPost',
            'locations': 'locations',
            // Default
            '*actions': 'defaultAction'

        }
    });

    window.BASE_URL = 'http://api.loc.mobac.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function () {
            console.log("defaultAction");
            var messagesListView = new MessagesListView();
            messagesListView.render();
        });

        app_router.on('route:locations', function () {
            var mapView = new MapView();
            mapView.init();
            // We have no matching route, lets display the home page
            /*console.log("locationView");
            var locationsListView = new LocationsListView();
            locationsListView.render();*/
         /*   var map = new Map({zoom: 8, maxZoom: 18, minZoom: 8});
            map.initMap({coords: {latitude: -34.397, longitude: 150.644}});
            var mapView = new MapView({model: map});
            mapView.render();*/
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
