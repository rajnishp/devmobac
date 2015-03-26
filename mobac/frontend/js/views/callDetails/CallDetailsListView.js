define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/callDetails/CallDetailsCollection',
  'text!templates/callDetails/callDetailsTemplate.html',
  'text!templates/callDetails/phoneDetailsTemplate.html',
  'models/callDetails/CallDetailsModel'
  ], function($, _, Backbone, Datatable, CallDetailsCollection, CallDetailsTemplate, PhoneDetailsTemplate, CallDetailsModel){

    var CallDetailsView = Backbone.View.extend({
      
     el : $("#page"),
     events: {
      'click #delcall': 'deleteCallDetails'
     },
     initialize : function() {
     
      var that = this;
      
      that.bind("reset", that.clearView);
     },
     deleteCallDetails: function (options) {
        
        var that = this;
        
        var rowId = options.target.attributes[2].value;
        
        var callDetails = new CallDetailsModel({id: rowId});
        
        callDetails.destroy({
          success: function () {
            
            delete that.callDetails;
            
            delete callDetails;
            window.app_router.navigate('call-details', {trigger:true}); 
          }
        });
      },
    render: function (options) {
      var that = this;
      var options = options; 
      var CallDetails = new CallDetailsCollection();
      
      var key = $.readCookie("auth-key");
      CallDetails.fetch({
        
        beforeSend: function (xhr) {
            xhr.setRequestHeader('AUTH-KEY', key);
        } ,
        success: function (CallDetails) {  
          callDetailsData = CallDetails.models[0].attributes.data.CallDetails;

          if(options.phone == undefined){
              var numbers = [];
              var flag = 0;
              _.each(callDetailsData, function(callD){
                var that = this;
                for (i = 0; i < numbers.length; i++) { 
                    if (numbers[i].number == callD.secondParty ) {
                      flag = 1;
                      break;
                    }
                }
                if(flag == 0)
                  numbers.push({"number" : callD.secondParty, "name" : callD.callerName, "count" : 1});
                else
                  numbers[i].count = numbers[i].count + 1;
                flag = 0;

              });

              var template = _.template(CallDetailsTemplate, {Numbers: numbers});
              $('#CallDetails-list-template').html(template); 
              
              that.$el.html(template);
              $('#callDetailsTable').DataTable();
            }
            else { 
              var Details = [];
              _.each(callDetailsData, function(detail){
                var that = this;
                if (options.phone == detail.secondParty ) {
                  var oldDate = detail.time;
                  var a = oldDate.split(/-|\s|:/); 
                  var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
                  Details.push({"id" : detail.id, "secondParty" : detail.secondParty, "callDuration" : detail.callDuration, "time" : date, "type" : detail.type});
                }
              });
              
              var template = _.template(PhoneDetailsTemplate, {Details: Details});
              $('#PhoneDetails-list-template').html(template); 
              
              that.$el.html(template);
              $('#phoneDetailsTable').DataTable();
            }
          $("#locationDate").html("");
          return that;
        },
        error: function (CallDetails, response) {
          var status = response.status;
          if(status == "401")
            window.app_router.navigate('default', {trigger:true});
        }
      });

    }
   
  });
  
  return CallDetailsView;

});
