<?php

session_start();


if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['login__username'])){
  //echo $_POST['login__username'];
  if($_POST['login__username'] == "admin" && $_POST['login__password'] == "admin"){
    $_SESSION['user_id'] = $_POST['login__username'];
    //echo $_SESSION['user_id'];
    header('Location: index.php');

    exit;
  }

}
?>

<!DOCTYPE html>
<html class="wf-myriadpro-n6-active wf-museosans-n3-active wf-museosans-n5-active wf-museosans-n7-active wf-myriadpro-n4-active wf-active"><head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Mobac | Keep your mobile back</title>
      <link rel="stylesheet" type="text/css" href="css/validationEngine.css" media="screen" title="no title" charset="utf-8">
      <link rel="stylesheet" type="text/css" href="css/newLogin.css">
      <style type="text/css">.tk-museo-sans{font-family:"museo-sans",sans-serif;}.tk-myriad-pro{font-family:"myriad-pro",sans-serif;}</style>
      <link href="css/d.css" rel="stylesheet">
</head>
<body>
	<article class="c-login-art">
    <section class="c-login-cont">
    <h2>Mobac Keep your mobile back</h2>
			<span class="c-login-contIn">
				<span class="c-logo-head">Log In to Mobac</span>
        <form id="form_login" method="post">
    	    <span class="c-login-sep">
		        	<label class="c-login-label" for="login__username">Username</label>
 		     		<input name="login__username" id="login__username" autofocus="" placeholder="username"  autocapitalize="off" type="text">
 		    	</span>
      		<span class="c-login-sep">
      			<label class="c-login-label" for="login__password">Password</label>
        			<input name="login__password" id="login__password" placeholder="password" autocomplete="off" type="password">
      		</span>
       		<span class="c-login-sep c-submit-sep">
        		<input name="submit" class="c-apply-btn" id="c-login-btn" value="Log In" type="submit">                		
       		</span>
       		<input name="login__is_form_submitted" value="true" type="hidden">
       	</form>
  		</span>
      <span id="login_success" class="c-logout-splash c-disp-none"></span>
   	</section>
	</article>
	<footer class="c-login-foot" style="position: fixed; bottom: 0px; left:0px; right:0px;">
		© Dpower4 2014
	</footer>

<div style="top: 301.483px; left: 863.917px; margin-top: 0px; opacity: 0.87;" class="formError login__usernameformError"><div class="formErrorContent">* This field is required<br></div><div class="formErrorArrow"></div></div>
</body>
</html>