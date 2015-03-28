/*define([
  'jquery',
  'underscore',
  'backbone',
  'text!templates/modal/modalTemplate.html'
], function($, _, Backbone, modalTemplate){
 
  var ModalView = Backbone.ModalView.extend({
      
    initialize: function(){
      _.bindAll( this, "render");
      this.template = _.template( this.templateHtml);
      Backbone.Validation.bind( this,  {valid:this.hideError, invalid:this.showError});
    },
    events: {
        
    },
    hideError: function(  view, attr, selector){
      var $element = view.$form[attr];
      
      $element.removeClass( "error");
      $element.parent().find( ".error-message").empty();
    },
    showError: function( view, attr, errorMessage, selector){
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
    
    render: function(){
      $(this.el).html( this.template());
      
      this.$form = {
        name: this.$("#name"),
        email: this.$("#email"),
        phone: this.$("#phone")}
        
      return this;
    }
  });
  return ModalView;
});*/