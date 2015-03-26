// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/messages/MessagesListView',
    'views/callDetails/CallDetailsListView',
    'views/locations/LocationsView',
    'views/modal/modalView',
    'views/login/loginView'
    
], function ($, _, Backbone,
        MessagesListView,
        CallDetailsListView,
        LocationsView,
        ModalView,
        LoginView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'edit/:id': 'editPost',
            'call-details': 'call-details',
            'call-details/:phone': 'call-details',
            'call-details/:phone/delete': 'confirm',
            'messages/:number': 'messages',
            'messages/:number/delete': 'confirm',
            'messages': 'messages',
            'locations': 'locations',
            'logout': 'confirm',
            'locations/:date': 'locations',
            '*actions': 'defaultAction',
            'login': 'login'

        }
    });

    window.BASE_URL = 'http://api.loc.mobac.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function () {
            var key = $.readCookie("auth-key");
            if(key != null){
                window.app_router.navigate('#/messages', {trigger:true});
            }
            var loginView = new LoginView();
            loginView.render();
        });

        app_router.on('route:messages', function (number) {
            
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

        app_router.on('route:login', function () {
            var key = $.readCookie("auth-key");
            if(key != null){
                window.app_router.navigate('#/messages', {trigger:true});
            }
            var loginView = new LoginView();
            loginView.render();
        });

        app_router.on('route:confirm', function () {
            var modalView = new ModalView();
            modalView.render();
            //$.createCookie("auth-key", "", -1);
            //window.app_router.navigate('default', {trigger:true});
        });

        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
