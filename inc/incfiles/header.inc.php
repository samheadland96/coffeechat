<?php
include ("inc/scripts/mysql_connect.inc.php");
session_start();
if (isset($_SESSION['user_login'])) {
$user = $_SESSION["user_login"];
}
else {
$user = "";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
	<meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
		<script src="js/parsley.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="css/foundation.css">
		<link rel="stylesheet" href="css/app.css">

		<script src="https://use.typekit.net/wse3qql.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<title>CoffeeChat</title>

</head>
<body>

		<header>
			<div class="row">
  <div class="small-6 columns">
		<div class="logo">
		<img src="../img/logo(white).png">
	</div>
	</div>




			<?php

				echo '
				<div class="small-6 columns">
				<form action="index.php" method="post" name="form1">
				<div class="row login-form">
				<div class="medium-4 columns">
				<input  type="text" class="login-username" name="user_login" placeholder="Username" /><p />
				</div>
				<div class="medium-4 columns">
				<input type="password" class="login-password" name="password_login" placeholder="Password" /><p />
				<p class="forgot-password"><a href="forgot-password.php">Forgot Password?</a></p>
				</div>
				<div class="medium-4 columns">
				<input type="submit" name="button" class="button login" value="Login">
				</div>
				</div>
				</form>

			</div>
			</div>
			<div class="row">

				<div class="medium-10 medium-centered slogan">
<h1>Networking for Coffee Lovers.</h1>
<a href="login.php"<button class="button join">Join Now!</button></a>
			</div>
		</div>

				';

			?>

		</header><!--end mashmenu -->
