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
        document.getElementById("locationDate").innerHTML = "";
        document.getElementById("logout").innerHTML = "";
        var that = this;
        that.bind("reset", that.clearView);
      },
      login: function (ev) {
        var that = this;
        var data = $(ev.currentTarget).serializeObject1();
        var username = data.username;
        var password = data.password;
        if(username=="" || username==undefined || username==null){
          Bootbox.alert("Please enter username");
        }
        else if(password=="" || password==undefined || password==null){
          Bootbox.alert("Please enter password");
        }
        else {
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
              var key = login.attributes.data["auth-key"];
              $.createCookie("auth-key", key, 2);
              window.app_router.navigate('#/messages', {trigger:true});
            },
            error: function (loginDetails,response) {
              Bootbox.alert("Username or Password is wrong");
            }
          });
        }
        that.bind("reset", that.clearView);
        return false;
      },
      render: function () {
        document.getElementById("locationDate").innerHTML = "";
        var that = this;
        var template = _.template(loginTemplate); 
        that.$el.html(template);
        return that;
      }
    });    
  return LoginView;
});
