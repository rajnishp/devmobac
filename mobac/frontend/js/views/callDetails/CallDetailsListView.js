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
      
      var callDetails = new CallDetailsCollection();
      console.log("inside render");
      callDetails.fetch({
        success: function (callDetails) {
           //defining teplate
        console.log("inside render success");  
        console.log(CallDetails);
        var template = _.template(CallDetailsTemplate, {callDetails: callDetails.models[0].attributes.data.callDetails});
        $('#callDetails-list-template').html(template); 
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
