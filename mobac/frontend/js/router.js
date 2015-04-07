// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'Bootstrap',
    'Bootbox',
    'views/messages/MessagesListView',
    'views/callDetails/CallDetailsListView',
    'views/locations/LocationsView',
    'views/contacts/ContactsView',
    'views/login/loginView'
    
], function ($, _, Backbone, Bootstrap, Bootbox,
        MessagesListView,
        CallDetailsListView,
        LocationsView,
        ContactsView,
        LoginView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'edit/:id': 'editPost',
            'call-details': 'call-details',
            'call-details/:phone': 'call-details',
            'messages/:number': 'messages',
            'messages': 'messages',
            'locations': 'locations',
            'contacts': 'contacts',
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
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            var key = $.readCookie("auth-key");
            if(key != null){
                window.app_router.navigate('#/call-details', {trigger:true});
            }
            var loginView = new LoginView();
            loginView.render();
        });
        var messagesListView = new MessagesListView();
        app_router.on('route:messages', function (number) {
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            messagesListView.render({number : number});
        });

        app_router.on('route:locations', function (date) {
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            var locationsView = new LocationsView();
            locationsView.render({date : date});
        
        });
        var callDetailsListView = new CallDetailsListView();
        app_router.on('route:call-details', function (phone) {
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            callDetailsListView.render({phone : phone});
        });

        app_router.on('route:contacts', function () {
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            var contactsView = new ContactsView();
            contactsView.render();
        });

        app_router.on('route:login', function () {
            $.createCookie("callDetails-start", "", -1);
            $.createCookie("contacts-start", "", -1);
            $.createCookie("messages-start", "", -1);
            var key = $.readCookie("auth-key");
            if(key != null){
                window.app_router.navigate('#/call-details', {trigger:true});
            }
            var loginView = new LoginView();
            loginView.render();
        });

        app_router.on('route:confirm', function () {
            Bootbox.confirm("Are you sure?", function(result) {
                if(result){
                    $.createCookie("auth-key", "", -1);
                    $.createCookie("callDetails-start", "", -1);
                    $.createCookie("contacts-start", "", -1);
                    $.createCookie("messages-start", "", -1);
                    window.app_router.navigate('default', {trigger:true});
                }
            });
        });

        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
