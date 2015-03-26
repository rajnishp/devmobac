define([
  'jquery',
  'underscore',
  'backbone',
  'models/callDetails/CallDetailsModel',
  'models/messages/MessagesModel',
  'text!templates/modal/modalTemplate.html'
], function($, _, Backbone, CallDetailsModel, MessagesModel, modalTemplate){
  
  var ModalView = Backbone.View.extend({
    className: 'modal',

    events: {
      'click .close': function(event) {
        event.preventDefault();

        this.trigger('cancel');

        if (this.options.content && this.options.content.trigger) {
          this.options.content.trigger('cancel', this);
        }
      },
      'click .cancel': function(event) {
        event.preventDefault();

        this.trigger('cancel');

        if (this.options.content && this.options.content.trigger) {
          this.options.content.trigger('cancel', this);
        }
      },
      'click .ok': function(event) {
        event.preventDefault();

        this.trigger('ok');

        if (this.options.content && this.options.content.trigger) {
          this.options.content.trigger('ok', this);
        }

        if (this.options.okCloses) {
          this.close();
        }
      },
      'keypress': function(event) {
        if (this.options.enterTriggersOk && event.which == 13) {
          event.preventDefault();

          this.trigger('ok');

          if (this.options.content && this.options.content.trigger) {
            this.options.content.trigger('ok', this);
          }

          if (this.options.okCloses) {
            this.close();
          }
        }
      }
    },

   
    initialize: function(options) {
      this.options = _.extend({
        title: null,
        okText: 'OK',
        focusOk: true,
        okCloses: true,
        cancelText: 'Cancel',
        showFooter: true,
        allowCancel: true,
        escape: true,
        animate: false,
        enterTriggersOk: false
      }, options);
    },

    _interpolateBackup : {
      interpolate: /\{\{(.+?)\}\}/g,
      evaluate: /<%([\s\S]+?)%>/g
    },

    
    render: function() {
      var $el = this.$el,
      options = this.options,
      content = options.content;
      var template = _.template(modalTemplate);
      //Create the modal container
      $el.html(template(options));

      var $content = this.$content = $el.find('.modal-body')

      //Insert the main content if it's a view
      if (content && content.$el) {
        content.render();
        $el.find('.modal-body').html(content.$el);
      }

      if (options.animate) $el.addClass('fade');

      this.isRendered = true;

      return this;
    },

    
    open: function(cb) {
      if (!this.isRendered) this.render();

      var self = this,
      $el = this.$el;

      //Create it
      $el.modal(_.extend({
        keyboard: this.options.allowCancel,
        backdrop: this.options.allowCancel ? true : 'static'
      }, this.options.modalOptions));

      //Focus OK button
      $el.one('shown.bs.modal', function() {
        if (self.options.focusOk) {
          $el.find('.btn.ok').focus();
        }

        if (self.options.content && self.options.content.trigger) {
          self.options.content.trigger('shown', self);
        }

        self.trigger('shown');
      });

      //Adjust the modal and backdrop z-index; for dealing with multiple modals
      var numModals = Modal.count,
      $backdrop = $('.modal-backdrop:eq('+numModals+')'),
      backdropIndex = parseInt($backdrop.css('z-index'),10),
      elIndex = parseInt($backdrop.css('z-index'), 10);

      $backdrop.css('z-index', backdropIndex + numModals);
      this.$el.css('z-index', elIndex + numModals);

      if (this.options.allowCancel) {
        $backdrop.one('click', function() {
          if (self.options.content && self.options.content.trigger) {
            self.options.content.trigger('cancel', self);
          }

          self.trigger('cancel');
        });

        $(document).one('keyup.dismiss.modal', function (e) {
          e.which == 27 && self.trigger('cancel');

          if (self.options.content && self.options.content.trigger) {
            e.which == 27 && self.options.content.trigger('shown', self);
          }
        });
      }

      this.on('cancel', function() {
        self.close();
      });

      Modal.count++;

      //Run callback on OK if provided
      if (cb) {
        self.on('ok', cb);
      }

      return this;
    },

    /**
     * Closes the modal
     */
    close: function() {
      var self = this,
        $el = this.$el;

      //Check if the modal should stay open
      if (this._preventClose) {
        this._preventClose = false;
        return;
      }

      $el.one('hidden.bs.modal', function onHidden(e) {
        // Ignore events propagated from interior objects, like bootstrap tooltips
        if(e.target !== e.currentTarget){
          return $el.one('hidden', onHidden);
        }
        self.remove();

        if (self.options.content && self.options.content.trigger) {
          self.options.content.trigger('hidden', self);
        }

        self.trigger('hidden');
      });

      $el.modal('hide');

      Modal.count--;
    },

    /**
     * Stop the modal from closing.
     * Can be called from within a 'close' or 'ok' event listener.
     */
    preventClose: function() {
      this._preventClose = true;
    }
  });
  return ModalView;
});