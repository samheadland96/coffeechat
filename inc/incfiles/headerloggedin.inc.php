<?php
include ("inc/scripts/mysql_connect.inc.php");
session_start();
if (isset($_SESSION['user_login'])) {
$user = $_SESSION["user_login"];
}
else {
$user = "";
}

$get_unread_query = mysql_query("SELECT opened FROM messages WHERE user_to='$user' && opened='no'");
$get_unread = mysql_fetch_assoc($get_unread_query);
$unread_numrows = mysql_num_rows($get_unread_query);
$unread_numrows = "(".$unread_numrows.")";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/foundation.css">
		<link rel="stylesheet" href="css/app.css">

		<script src="https://use.fontawesome.com/70edd6689c.js"></script>

		<script src="https://use.typekit.net/wse3qql.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

<title>CoffeeChat</title>

</head>
<body>

		<header>
			<div class="row">
  <div class="small-6 columns">
		<div class="logo-loggedin">
		<a href="home.php"><img src="../img/logo-mug.png"></a>
	</div>
	</div>





			<?php
			if (isset($_SESSION["user_login"])) {
			echo '

      <div class="small-6 columns">
        <form action="search.php" method="GET" id="search">
      <input class="search" type="text" name="result" placeholder="Search" required="" />
      </form>
      </div>
</header>


<div class="row bottom-header">
<div class="large-8 columns">
<p class="hello-user">Hello <bold><a href='. $user .'> '. $user .'!</bold></p>
</div>
<div class="large-4 columns bottom">
	<a class="header-links" href="'. $user . '" ><i class="fa fa-user fa-2x" alt="Profile" aria-hidden="true"></i>
</a>
	<a class="header-links" href="account_settings.php"><i class="fa fa-cog fa-2x" aria-hidden="true"></i></a>
	<a class="header-links" href="my_messages.php"><i class="fa fa-comments fa-2x" aria-hidden="true"></i> ' . $unread_numrows . '</a>


	<a class="header-links" href="logout.php">Logout</a>

</div>
</div>

			';
			}
			?>

		</header><!--end mashmenu -->
