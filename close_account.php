<?php
include ("./inc/incfiles/headerother.inc.php");

//Take the user back
if ($user) {
if (isset($_POST['no'])) {
 header("Location: account_settings.php");
}
if (isset($_POST['yes'])) {
$close_account = mysql_query("DELETE FROM users WHERE username='$user'");
$close_account = mysql_query("DELETE FROM users WHERE username='$user'");

echo "Your Account has been closed!";
session_destroy();
}
}
else
{
 die ("<h2 style='text-align:center;'>You must be logged in to view this page!</h2><br/>Click <a href='index.php'>HERE</a> to go back");
}
?>
<br />
<center>
<form action="close_account.php" method="POST">
Are you sure you want to close your account?<br>
<input type="submit" class="button round" name="no" value="No, take me back">
<input type="submit" class="button round" name="yes" value="Yes I'm sure">
</form>
</center>
