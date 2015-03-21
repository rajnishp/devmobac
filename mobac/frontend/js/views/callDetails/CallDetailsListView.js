define([
  'jquery',
  'underscore',
  'backbone',
  'collections/callDetails/CallDetailsCollection',
  'text!templates/callDetails/callDetailsTemplate.html'
  ], function($, _, Backbone, CallDetailsCollection, CallDetailsTemplate){

    var CallDetailsView = Backbone.View.extend({

     el : $("#page"),
     
     initialize : function() {
     
      var that = this;
      console.log("i am in CallDetails");
      that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var CallDetails = new CallDetailsCollection();
      console.log("inside render");
      CallDetails.fetch({
        success: function (CallDetails) {
           //defining teplate
        console.log("inside render success");  
        console.log(CallDetails);
        var template = _.template(CallDetailsTemplate, {CallDetails: CallDetails.models[0].attributes.data.CallDetails});
        $('#CallDetails-list-template').html(template); 
        console.log(template);
        that.$el.html(template);
        $('#callDetailsTable').DataTable();
        return that;
          }
      });

    }
   
  });


  
  return CallDetailsView;

});
