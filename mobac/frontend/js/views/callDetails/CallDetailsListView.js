define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'Bootstrap',
  'Bootbox',
  'collections/callDetails/CallDetailsCollection',
  'text!templates/callDetails/callDetailsTemplate.html',
  'text!templates/callDetails/phoneDetailsTemplate.html',
  'models/callDetails/CallDetailsModel'
  ], function($, _, Backbone, Datatable, Bootstrap, Bootbox, CallDetailsCollection, CallDetailsTemplate, PhoneDetailsTemplate, CallDetailsModel){

    var CallDetailsView = Backbone.View.extend({
    
     el : $("#page"),
     events: {
      'click #delcall': 'deleteCallDetails'
     },
     initialize : function() {
      document.getElementById("logout").innerHTML = '<a href="#/logout">Log Out </a>';
      var that = this;
      
      that.bind("reset", that.clearView);
     },
     deleteCallDetails: function (options) {
      Bootbox.confirm("Do u really want to delete this?", function(result) {
        if(result){
          var that = this;
          var key = $.readCookie("auth-key");
          var rowId = options.target.attributes[1].value;
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
                if(flag == 0){
                  var oldDate = callD.time;
                  var a = oldDate.split(/-|\s|:/); 
                  var date = new Date(a[0], a[1] -1, a[2], a[3], a[4], a[5]);
                  if(callD.callerName == ""){
                    numbers.push({"name" : callD.secondParty, "number": callD.secondParty, "date": date, "count" : 1});
                  }
                  else 
                    numbers.push({"name" : callD.callerName, "number": callD.secondParty, "date": date, "count" : 1});
                }
                else
                  numbers[i].count = numbers[i].count + 1;
                flag = 0;

              });
              if(numbers == ""){
                Bootbox.alert("Sorry No Data Available");
              }
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
                  if(detail.callerName == ""){
                    Details.push({"id" : detail.id, 'name': detail.secondParty, "callDuration" : detail.callDuration, "time" : date, "type" : detail.type});
                  }
                  else {
                    Details.push({"id" : detail.id, 'name': detail.callerName, "callDuration" : detail.callDuration, "time" : date, "type" : detail.type});
                  }
                }
              });
              if(Details == ""){
                Bootbox.alert("Sorry No Data Available");
              }
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

          if(status == "401"){
            document.getElementById("logout").innerHTML = "";
            Bootbox.alert("Please login first");
            window.app_router.navigate('default', {trigger:true});
          }
          else {
            Bootbox.alert("Please try again");
          }
        }
      });

    }
   
  });
  
  return CallDetailsView;

});
