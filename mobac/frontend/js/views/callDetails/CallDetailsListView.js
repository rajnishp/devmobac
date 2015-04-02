define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'Bootstrap',
  'Bootbox',
  'timeago',
  'collections/callDetails/CallDetailsSummaryCollection',
  'collections/callDetails/CallDetailsCollection',
  'text!templates/callDetails/callDetailsTemplate.html',
  'text!templates/callDetails/phoneDetailsTemplate.html',
  'models/callDetails/CallDetailsModel'
  ], function($, _, Backbone, Datatable, Bootstrap, Bootbox, timeago, CallDetailsSummaryCollection, CallDetailsCollection, CallDetailsTemplate, PhoneDetailsTemplate, CallDetailsModel){

    var CallDetailsView = Backbone.View.extend({
    
    el : $("#page"),
    events: {
      'submit .delcall': 'deleteCallDetails'
    },
    initialize : function() {
      var that = this;
      document.getElementById("locationDate").innerHTML = "";
      document.getElementById("logout").innerHTML = "<img src='imgs/logout.jpeg' /> Logout";
      that.bind("reset", that.clearView);
    },
    deleteCallDetails: function (ev) {
      var data = $(ev.currentTarget).serializeObject1();
      Bootbox.confirm("Do u really want to delete this?", function(result) {
        if(result){
          var that = this;
          var key = $.readCookie("auth-key");
          var rowId = data.value;
          
          var callDetails = new CallDetailsModel({id: rowId});
          
          callDetails.destroy({
            beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
            } ,
            success: function () {
              
              delete that.callDetails;
              delete callDetails;
              Bootbox.alert("Deleted Successfully");
              window.app_router.navigate('call-details', {trigger:true}); 
            },
            error: function (response) {
              Bootbox.alert("Please try again");
            }
          });
        }
      });
    },
    render: function (options) {
      var that = this;
      var options = options; 
      var key = $.readCookie("auth-key");
      var numbers = [];
      if(options.phone == undefined || options.phone == ""){
        var CallDetails = new CallDetailsSummaryCollection();
        CallDetails.fetch({
          beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          } ,
          success: function (CallDetails) {  
            callDetailsData = CallDetails.models[0].attributes.data.CallDetails;
            _.each(callDetailsData, function(callD){
              var that = this;
              var oldDate = callD.time;
              var a = oldDate.split(/\s/); 
              var string = $.timeago(a[0]+"T"+a[1]+"Z"); //String(date).substring(0, 25);
              if(callD.callerName !== ""){
                numbers.push({"name" : callD.callerName, "number": callD.secondParty, "date": string, "count" : callD.count, "type" : callD.type});
              }
              else {
                numbers.push({"name" : callD.secondParty, "number": callD.secondParty, "date": string, "count" : callD.count, "type" : callD.type});
              }
            });
            if(numbers == ""){
              Bootbox.alert("Sorry No Data Available");
            }
            var template = _.template(CallDetailsTemplate, {Numbers: numbers});
            //$('#CallDetails-list-template').html(template); 
            that.$el.html(template);
              //$('#callDetailsTable').DataTable();
            return that;
          },
          error: function (CallDetails, response) {
            var status = response.status;
            if(status == "401"){
              Bootbox.alert("Please login first");
              window.app_router.navigate('default', {trigger:true});
            }
            else {
              Bootbox.alert("No data available");
            }
          }
        });
      }
      else {
        var callId = options.phone ;
        var CallDetails = new CallDetailsCollection({id: callId});
        CallDetails.fetch({
          beforeSend: function (xhr) {
              xhr.setRequestHeader('AUTH-KEY', key);
          } ,
          success: function (CallDetails) {  
            callDetailsData = CallDetails.models[0].attributes.data.CallDetails;
            _.each(callDetailsData, function(callD){
              var that = this;
              var oldDate = callD.time;
              var a = oldDate.split(/\s/); 
              var string = $.timeago(a[0]+"T"+a[1]+"Z"); //String(date).substring(0, 25);
              numbers.push({"id": callD.id, "number": callD.secondParty, "date": string, "type" : callD.type, "callDuration": callD.callDuration});
            });
            if(numbers == ""){
              Bootbox.alert("Sorry No Data Available");
            }
            var template = _.template(PhoneDetailsTemplate, {Numbers: numbers});
            //$('#CallDetails-list-template').html(template); 
            that.$el.html(template);
            $('#phoneDetailsTable').DataTable();
            return that;
          },
          error: function (CallDetails, response) {
            var status = response.status;
            if(status == "401"){
              Bootbox.alert("Please login first");
              window.app_router.navigate('default', {trigger:true});
            }
            else {
              Bootbox.alert("No data available");
            }
          }
        });
      }
    }
  });
  return CallDetailsView;

});
