<?php 
session_start(); 
/*$user_id = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}*/

?>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Mobac</title>
	<meta name="description" content="">
	<meta name="author" content="rahul lahoria">
	<meta name="viewport" content="width=device-width,initial-scale=1">
 
  <link rel="stylesheet" href="css/bootstrap.css" media="screen">
  <link rel="stylesheet" href="css/bootswatch.css">	
  <link rel="stylesheet" href="css/jquery-dataTables.css">
  
  <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
  <script src="js/libs/bootstrap/ga.js" async="" type="text/javascript"></script>
  
  <script data-main="js/main" src="js/libs/require/require.js"></script>
	
  
</head>
<body>
 
  <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#/messages" class="navbar-brand">
          	<img src ='imgs/mobeclogo.png' style="width:60px; height:40px"/>
          		
          </a>
          <a href="#/messages" class="navbar-brand">
          		Mobac
          </a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav navbar-right nav-tabs">
            <li id="tab1" class="active"><a href="#/messages" ><i class="glyphicon glyphicon-envelope"></i>&nbsp;<span>Messages</span></a></li>
            <li id="tab2" ><a href="#/call-details" ><i class="glyphicon glyphicon-earphone"></i>&nbsp;<span>Call Details</span></a></li>
            <li id="tab3" ><a href="#/locations" ><i class="glyphicon glyphicon-pushpin"></i>&nbsp;<span>Locations</span></a></li>
            <li id="logout"></li><!-- <li><a href="index.html#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li> -->
          </ul>

        </div>
      </div>
    </div>

    <br/><br/>
<div class="container">
  <div class='row'>
      <div class='col-md-1'>
        <div id='locationDate'></div>      
      </div>
      <div class='col-md-10' >
        <div id="page" style="width:100%; height:100%">
          Loading Mobac UI....

        </div>   
      </div>
      <div class="col-md-1">
        
      </div> 
  </div>

  <div id="footer"></div>
</div>
<div class="modal fade hide" id="base-modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
</body>
</html>
