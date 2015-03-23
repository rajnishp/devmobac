// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/messages/MessagesListView',
    'views/callDetails/CallDetailsListView',
    'views/locations/LocationsView'
    
], function ($, _, Backbone,
        MessagesListView,
        CallDetailsListView,
        LocationsView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'edit/:id': 'editPost',
            'call-details': 'call-details',
            'call-details/:phone': 'call-details',
            '#/messages/:number': 'defaultAction',
            'locations': 'locations',
            'locations/:date': 'locations',
            '*actions': 'defaultAction'

        }
    });

    window.BASE_URL = 'http://api.loc.mobac.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function (number) {
            
            var messagesListView = new MessagesListView();
            messagesListView.render({number : number});
        });

        app_router.on('route:locations', function (date) {
            
            var locationsView = new LocationsView();
            locationsView.render({date : date});
        
        });

        app_router.on('route:call-details', function (phone) {
            
            var callDetailsListView = new CallDetailsListView();
            callDetailsListView.render({phone : phone});
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
