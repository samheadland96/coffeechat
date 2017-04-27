<!--  -->

<? include("inc/incfiles/header.inc.php"); ?>
<?php
if (!isset($_SESSION["user_login"])) {
    echo "";
}
else
{
    echo "<meta http-equiv=\"refresh\" content=\"0; url=home.php\">";
}
?>
<?php
$reg = @$_POST['reg'];
//declaring variables to prevent errors
$fn = ""; //First Name
$ln = ""; //Last Name
$un = ""; //Username
$em = ""; //Email
$pswd = ""; //Password
$pswd2 = ""; // Password 2
$d = ""; // Sign up Date
$u_check = ""; // Checks to see if username already exists
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password2']);



if ($reg) {
// Check to see if user already exists
$u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
// Counts the amount of rows where username = $un
$check = mysql_num_rows($u_check);

if ($check == 0) {
// Check to see if all of the fields have been filed in
if ($fn&&$ln&&$un&&$em&&$pswd&&$pswd2) {
// Check that passwords entered match
if ($pswd==$pswd2) {
// Checks the maximum length of username/first name/last name does not exceed 25 characters
if (strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
echo "The maximum limit for username/first name/last name is 25 characters!";
}
else
{
// check the maximum length of password does not exceed 25 characters and is not less than 5 characters
if (strlen($pswd)>30||strlen($pswd)<5) {
echo "Your password must be between 5 and 30 characters long!";
}
else
{
// Encrypts password and password 2 using md5 before sending it to the database
$pswd = md5($pswd);
$pswd2 = md5($pswd2);
$query = mysql_query("INSERT INTO users VALUES ('','$un','$em','$pswd', '0', '0','$fn','$ln','','')");
die("<h2 class='welcome'>Welcome to CoffeeChat!</h2 class='welcome-login'>Login to your account to get started ...");
}
}
}
else {
echo "Your passwords don't match!";
}
}
else
{
echo "Please fill in all of the fields";
}
}

else
{
echo "Username already taken ...";
}
}



?>
<?
//Login Script
if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {

    // Filters everything but numbers and letters
	  $user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]);
    //Filter everything but numbers and letters
    $password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]);
    // Query the person
	  $md5password_login = md5($password_login);
    //Check for their existance

    $sql = mysql_query("SELECT id FROM users WHERE username='$user_login' AND password='$md5password_login' LIMIT 1");

    // Counts the number of rows returned
    $userCount = mysql_num_rows($sql);

	if ($userCount == 1) {
		while($row = mysql_fetch_array($sql)){
             $id = $row["id"];
	}
		 $_SESSION["user_login"] = $user_login;
    exit("<meta http-equiv=\"refresh\" content=\"0\">");
		}
    // If login is incorrect, then error message is displayed.
    else {
    echo '<script type="text/javascript">alert("Login Incorrect");</script>';

	}
}
?>
<!-- Introduction Text -->
<div class="row">
  <div class="medium-10 medium-centered columns">
    <h2 class="title">CoffeeChat is a new social networking website, aimed to connect those with the same interest together: Coffee!</h2>
  </div>
</div>
<!-- Features Section -->
<div class="row features-section">
  <!-- Feature 1 -->
  <div class="large-4 columns">
    <img src="img/features1.jpg"/>
    <div class="features-text">
    <h3 style="text-align:center;"><bold>Review Coffee</bold></h3>
    </div>
</div>
<!-- Feature 2 -->
  <div class="large-4 columns features">
    <img src="img/features2.jpg"/>
    <div class="features-text">
    <h3 style="text-align:center;"><bold>Connect with others</bold></h3>
  </div>
</div>
<!-- Feature 3 -->
  <div class="large-4 columns features">
    <img src="img/features3.jpg"/>
    <div class="features-text">
    <h3 style="text-align:center;"><bold>Message Friends</bold></h3>
  </div>
</div>

</div>
<!-- Sign up section -->
<section class="row signup-section" id="signup">
    <h2>Sign up!</h2>
<div class="medium-10 medium-centered columns">

  <div class="medium-7 medium-centered columns">
   <form action="" method="post">

   <input type="text" size="40" name="fname"  class="signup-inputs round" placeholder="First Name" title="First Name" value="<? echo $fn; ?>" required=""><p />
   <input type="text" size="40" name="lname" class="signup-inputs round" placeholder="Last Name" title="Last Name" value="<? echo $ln; ?>" required=""><p />
   <input type="text" size="40" name="username" class="signup-inputs round" placeholder="Username" title="Username" value="<? echo $un; ?>" required=""><p />
   <input type="text" size="40" name="email" class="signup-inputs round" placeholder="Email" title="Email" value="<? echo $em; ?>" required=""><p />
   <input type="password" size="40" class="signup-inputs round" name="password" placeholder="Password"  value="" required=""><p />
   <input type="password" size="40" class="signup-inputs round" name="password2" placeholder="Repeat Password" value="" required=""><p/>
   <input type="submit" style="text-align:center; margin:0 auto; display:block;"class="button round"name="reg" value="Sign Up!">
   </form>
  </div>
</div>
</section>
<!-- Footer -->

<footer>
<p>&copy; CoffeeChat 2017</p>
</footer>
</body>
</html>
