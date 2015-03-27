define([
  'jquery',
  'underscore',
  'backbone',
  'models/callDetails/CallDetailsModel',
  'models/messages/MessagesModel',
  'text!templates/modal/modalTemplate.html'
], function($, _, Backbone, CallDetailsModel, MessagesModel, modalTemplate){
 
  var PersonModel = Backbone.Model.extend(
  {
    validation:
    {
      name: {required:true, msg: "Please enter the person's name."},
      phone: {required:true, msg: "Please enter the person's phone number."},
      email:
      [
        {required:true, msg: "Please enter the person's email address."},
        {pattern:"email", msg: "Please enter a valid email address"}
      ]
    }
  });
  AddPersonView = Backbone.ModalView.extend(
  {
    name: "AddPersonView",
    model: PersonModel,
    templateHtml:
      "<div class='modal-header'>Add a new person to the list</div>" +
      "<form>" +
                "<table class='compact'>" +
                    "<tr><td>" +
                "<label for='name'>Name</label>" +
                        "</td><td>" +
                "<input type='text' id='name' />" +
                    "</td></tr>" +
                    "<tr><td>" +
                "<label for='email'>Email</label>" +
                        "</td><td>" +
                "<input type='text' id='email' />" +
                    "</td></tr>" +
          "<tr><td>" +
                "<label for='phone'>Phone</label>" +
                        "</td><td>" +
                "<input type='text' id='phone' />" +
                    "</td></tr>" +
                    "<tr><td></td><td>" +
                "<input id='addPersonButton' type='submit' value='Add person' />" +
                    "</td></tr>" +
                "</table>" +
      "</form>",
    initialize:
      function()
      {
        _.bindAll( this, "render");
        this.template = _.template( this.templateHtml);
        Backbone.Validation.bind( this,  {valid:this.hideError, invalid:this.showError});
      },
    events:
      {
           "change #email": "validateEmail",
        "submit form": "addPerson"
      },
    getCurrentFormValues:
      function()
      {
        return {
          name: $("#name").val(),
          email: $("#email").val(),
          phone: $("#phone").val()};
      },
    validateEmail:
      function()
      {
        this.model.set( {email: $("#email").val()});
      },
    hideError:
      function(  view, attr, selector)
      {
        var $element = view.$form[attr];
        
        $element.removeClass( "error");
        $element.parent().find( ".error-message").empty();
      },
    showError:
      function( view, attr, errorMessage, selector)
      {
        var $element = view.$form[attr];
        
        $element.addClass( "error");
        var $errorMessage = $element.parent().find(".error-message");
        if( $errorMessage.length == 0)
        {
          $errorMessage = $("<div class='error-message'></div>");
          $element.parent().append( $errorMessage);
        }
        
        $errorMessage.empty().append( errorMessage);
      },
    addPerson:
      function( event)
      {
        event.preventDefault();
        
        if( this.model.set( this.getCurrentFormValues()))
        {
          this.hideModal();
          _people.add( this.model);
        }
      },
      
    render:
      function()
      {
        $(this.el).html( this.template());
        
        this.$form = {
          name: this.$("#name"),
          email: this.$("#email"),
          phone: this.$("#phone")}
          
        return this;
      }
  });
  return AddPersonView;
});