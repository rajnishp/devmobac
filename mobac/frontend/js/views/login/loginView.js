define([
  'jquery',
  'underscore',
  'backbone',
  'Bootstrap',
  'Bootbox',
  'text!templates/login/loginTemplate.html',
  'models/login/LoginModel'
  ], function($, _, Backbone, Bootstrap, Bootbox, loginTemplate, LoginModel){
    
    var LoginView = Backbone.View.extend({

      el : $("#page"),
      events: {
        'submit .edit-login-form': 'login'
      },

      initialize : function() {
        document.getElementById("logout").innerHTML = "";
        var that = this;
        that.bind("reset", that.clearView);
      },
      login: function (ev) {
        var that = this;
        console.log("savePost");
        console.log(this);
        var loginDetails = {};
          //console.log(ev.currentTarget);
        loginDetails.root = $(ev.currentTarget).serializeObject1();
        var login = new LoginModel({id: null});
        login.save(loginDetails,{
          success: function (login) {
            that.bind("reset", that.clearView);
            //that.render({id: null});
            delete login;
            delete this.login;
            document.getElementById("logout").innerHTML = '<a href="#/logout">Log Out </a>';
            var key = login.attributes.data["auth-key"];
            $.createCookie("auth-key", key, 2);
            window.app_router.navigate('#/messages', {trigger:true});
          },
          error: function (loginDetails,response) {
            Bootbox.alert("Please try again");
          }
        });
        return false;
      },
      render: function () {
        var that = this;
        var template = _.template(loginTemplate);
        //$('#login-template').html(template); 
        that.$el.html(template);
        return that;
      }
    });    
  return LoginView;
});
