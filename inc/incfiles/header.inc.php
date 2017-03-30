<?
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




			<?
			if (isset($_SESSION["user_login"])) {
			echo '

</header>
<div class="row bottom-header">
<div class="large-7 columns">
.
</div>
<div class="large-5 columns">
	<a class="header-links" href="'. $username . '" >Profile</a>
	<a class="header-links" href="account_settings.php">Settings</a>
	<a class="header-links" href="my_messages.php">Messages ' . $unread_numrows . '</a>
	<a class="header-links" href="logout.php">Logout</a>

</div>
</div>

			';
			}
			else
			{
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
<button href="#signup" class="button join">Join Now!</button>
			</div>
		</div>

				';
			}
			?>

		</header><!--end mashmenu -->
