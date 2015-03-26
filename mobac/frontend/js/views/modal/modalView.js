define([
  'jquery',
  'underscore',
  'backbone',
  'models/callDetails/CallDetailsModel',
  'models/messages/MessagesModel',
  'text!templates/modal/modalTemplate.html'
], function($, _, Backbone, CallDetailsModel, MessagesModel, modalTemplate){
  
  var ModalView = Backbone.View.extend({
    el: $('#base-modal'),
    className: 'modal fade hide',
    template: modalTemplate,
    events: {
      'hidden': 'teardown'
    },
    initialize: function() {
      _(this).bindAll();
      this.render();
    },
     
    show: function() {
      this.$el.showModal();
    },
     
    teardown: function() {
      this.$el.data('modal', null);
      this.remove();
    },
     
    render: function() {
      var template = _.template(this.template, this.renderView);
      return this;
    },
    renderView: function(template) {
      this.$el.html(template());
      this.$el.modal({show:false}); // dont show modal on instantiation
    }  
  });
  return ModalView;
});