<?php
// Includes the header inc file into the page
include ("./inc/incfiles/headerother.inc.php");

if ($user) {
  //If the user clicks 'NO' button then it returns back to settings page
if (isset($_POST['no'])) {
 header("Location: account_settings.php");
}

// If 'YES' button is clicked, the user is removed from the database
if (isset($_POST['yes'])) {
$close_account = mysql_query("DELETE FROM users WHERE username='$user'");
$close_account = mysql_query("DELETE FROM users WHERE username='$user'");

// Message displayed on screen confirming closed account
echo "Your Account has been closed!";

// Session is destroyed
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
