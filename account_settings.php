<?php
include ("inc/incfiles/headerloggedin.inc.php");

if ($user) {

}
else
{
 die ("You must be logged in to view this page!");
}
?>
<?php
  $senddata = @$_POST['senddata'];

  //Password variables for changing password
  $old_password = strip_tags(@$_POST['oldpassword']);
  $new_password = strip_tags(@$_POST['newpassword']);
  $repeat_password = strip_tags(@$_POST['newpassword2']);

  // If the form has been submitted
  if ($senddata) {
    // SELECT query to check for user
  $password_query = mysql_query("SELECT * FROM users WHERE username='$user'");
  while ($row = mysql_fetch_assoc($password_query)) {
        $db_password = $row['password'];

        //md5 the old password before checking if it matches
        $old_password_md5 = md5($old_password);

        //Check whether old password equals the $db_password
        if ($old_password_md5 == $db_password) {
         //Continue Changing the users password ...
         //This checks whether the 2 new passwords match
         if ($new_password == $repeat_password) {
           // If the password is less than or equal to 4 ,then it displays an error message
            if (strlen($new_password) <= 4) {
             echo "Sorry! But your password must be more than 4 character long!";
            }
            else
            {

            //md5 the new password before adding it to the database
            $new_password_md5 = md5($new_password);

           // Updates the users password
           $password_update_query = mysql_query("UPDATE users SET password='$new_password_md5' WHERE username='$user'");
           echo "Success! Your password has been updated!";

            }
         }
         // THe following is display if the passwords do not match
         else
         {
          echo "Your two new passwords don't match!";
         }
        }

        else
        {
         echo "The old password is incorrect!";
        }
  }
   }
  else
  {
   echo "";
  }


  $updateinfo = @$_POST['updateinfo'];

  //First Name, Last Name and About the user query
  $get_info = mysql_query("SELECT first_name, last_name, bio FROM users WHERE username='$user'");
  $get_row = mysql_fetch_assoc($get_info);
  $db_firstname = $get_row['first_name'];
  $db_last_name = $get_row['last_name'];
  $db_bio = $get_row['bio'];

  //Submit what the user types into the database
  if ($updateinfo) {
   $firstname = strip_tags(@$_POST['fname']);
   $lastname = strip_tags(@$_POST['lname']);
   $bio = @$_POST['bio'];

    //Submit the form to the database
    $info_submit_query = mysql_query("UPDATE users SET first_name='$firstname', last_name='$lastname', bio='$bio' WHERE username='$user'");
    echo "Your profile info has been updated!";
    header("Location: $user");
    echo "<meta http-equiv=\"refresh\" content=\"0; url=\">";

  }
  else
  {
   //Do nothing
  }
  //Check whether the user has uploaded a profile pic or not
  $check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$user'");
  $get_pic_row = mysql_fetch_assoc($check_pic);
  $profile_pic_db = $get_pic_row['profile_pic'];
  if ($profile_pic_db == "") {
  $profile_pic = "img/default_pic.jpg";
  }
  else
  {
  $profile_pic = "userdata/profile_pics/".$profile_pic_db;
  }
  //Profile Image upload script
  if (isset($_FILES['profilepic'])) {
   if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) //1 Megabyte
  {
   $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $rand_dir_name = substr(str_shuffle($chars), 0, 15);
   mkdir("userdata/profile_pics/$rand_dir_name");

   if (file_exists("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
   {
    echo @$_FILES["profilepic"]["name"]." Already exists";
   }
   else
   {
    move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
    //echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
    $profile_pic_name = @$_FILES["profilepic"]["name"];
    $profile_pic_query = mysql_query("UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$user'");
    header("Location: account_settings.php");

   }
  }
  else
  {
      echo "Invailid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif";
  }
  }

?>

<div class="row">
  <div class="medium-10 medium-centered columns">
    <h2 class="account-settings">Account Settings</h2>

<div class="large-7 columns">
  <p>UPLOAD PROFILE PICTURE:</p>

<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="profilepic" /><br />
<input type="submit"  class="button round" name="uploadpic" value="Upload Image">
</form>
</div>
<div class="large-5 columns">
<img src="<? echo $profile_pic; ?>" style="border-radius:60px; border: 2px solid #59cae0" width="110" />
</div>
    <div class="row">
      <div class="medium-12 columns">
      <form action="account_settings.php" method="post">
      <p class="settings-title">CHANGE YOUR PASSWORD:</p> <br />
    </div>
</div>
<div class="row">
<div class="medium-6 columns">

Your Old Password: <input type="text" class="noborder" name="oldpassword" id="oldpassword" size="40"><br />
</div>
<div class="medium-6 columns">
Your New Password: <input type="text" class="noborder"  name="newpassword" id="newpassword" size="40"><br />
Repeat Password  : <input type="text" class="noborder"  name="newpassword2" id="newpassword2" size="40"><br />
<input type="submit" name="senddata"  class="button round" value="Update Information">
</form>
</div>
</div>
<div class="row">
<form action="account_settings.php" method="post">
<p class="settings-title">UPDATE YOUR PROFILE INFO:</p> <br />
<div class="medium-6 columns">

First Name: <input type="text" class="noborder"  name="fname" id="fname" size="40" value="<? echo $db_firstname; ?>"><br />
</div>
<div class="medium-6 columns">

Last Name: <input type="text" class="noborder"  name="lname" id="lname" size="40" value="<? echo $db_last_name; ?>"><br />
</div>
<div class="medium-12 columns">

About You: <textarea name="bio" id="bio" class="noborder"  rows="7" cols="40"><? echo $db_bio; ?></textarea>
</div>
<input type="submit" class="button round" name="updateinfo" value="Update Information">
</form>
<form action="close_account.php" method="post">
<p class="settings-title">CLOSE ACCOUNT:</p> <br />
<input type="submit" name="closeaccount" i class="button round" value="Close My Account">
</form>

<br />
<br />
</div>
</div>
