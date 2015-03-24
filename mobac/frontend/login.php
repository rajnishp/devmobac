<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html class="wf-myriadpro-n6-active wf-museosans-n3-active wf-museosans-n5-active wf-museosans-n7-active wf-myriadpro-n4-active wf-active">
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Mobac | Keep your mobile back</title>
      <link rel="stylesheet" type="text/css" href="css/validationEngine.css" media="screen" title="no title" charset="utf-8">
      <link rel="stylesheet" type="text/css" href="css/newLogin.css">
      <style type="text/css">.tk-museo-sans{font-family:"museo-sans",sans-serif;}.tk-myriad-pro{font-family:"myriad-pro",sans-serif;}</style>
      <link href="css/d.css" rel="stylesheet">
      <script src="js/libs/bootstrap/ga.js" async="" type="text/javascript"></script>
      <script data-main="js/main" src="js/libs/require/require.js"></script>
</head>
<body>
	<article class="c-login-art">
    <section class="c-login-cont">
      <span id="login_success" class="c-logout-splash c-disp-none"></span>
   	</section>
	</article>
	<footer class="c-login-foot" style="position: fixed; bottom: 0px; left:0px; right:0px;">
		© Dpower4 2014
	</footer>

</body>
</html>