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
          <ul class="nav nav-tabs nav-justified">
            <li><a href='#/messages' class="myclass"><img src="imgs/index.jpeg" /> Messages</a> </li>
            <li><a href='#/call-details' class="myclass" ><img src="imgs/callHis.jpeg" /> Call Logs </a></li>
            <li><a href='#/locations' class="myclass" ><img src="imgs/locations.png" /> Locations </a></li>
            <li><a href='#/contacts' class="myclass" ><img src="imgs/Callloglogo.png" /> Contacts </a></li>
            <li><a href='#/locations' class="myclass" ><img src="imgs/sharelocation.png" /> Share Location </a></li>
            <li><a href='#/logout' class="myclass" id="logout"> </a></li>
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
</body>
</html>
