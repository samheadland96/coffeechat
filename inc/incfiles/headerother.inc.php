<?php
include ("inc/scripts/mysql_connect.inc.php");
session_start();
if (isset($_SESSION['user_login'])) {
$user = $_SESSION["user_login"];
}
else {
$user = "";
}

$get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no'");
$get_unread = mysql_fetch_assoc($get_unread_query);
$unread_numrows = mysql_num_rows($get_unread_query);
$unread_numrows = "(".$unread_numrows.")";
?>
<!DOCTYPE html>

<html lang="en">
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
		<a href="index.php">
		<div class="logo">
		<img src="../img/logo(white).png">
	</a>
	</div>
	</div>

		</header><!--end mashmenu -->
