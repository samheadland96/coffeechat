<?php
include("inc/incfiles/headerloggedin.inc.php");

?>
<?php
if (isset($_FILES['post-image'])) {
 if (((@$_FILES["post-image"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["post-image"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) //1 Megabyte
{
 $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 $rand_dir_name = substr(str_shuffle($chars), 0, 15);
 mkdir("userdata/user_photos/$rand_dir_name");

 if (file_exists("userdata/user_photos/$rand_dir_name/".@$_FILES["post-image"]["name"]))
 {
  echo @$_FILES["profilepic"]["name"]." Already exists";
 }
 else
 {
  move_uploaded_file(@$_FILES["post-image"]["tmp_name"],"userdata/user_photos/$rand_dir_name/".$_FILES["post-image"]["name"]);
  //echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
  $profile_pic_name = @$_FILES["post-image"]["name"];
  $profile_pic_query = mysql_query("UPDATE post SET photo='$rand_dir_name/$profile_pic_name' WHERE username='$user'");
  header("Location: account_settings.php");

 }
}
else
{
    echo "Invailid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif";
}
}
?>
<?php
if (!isset($_SESSION["user_login"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=\">";
}
else
{
?>
<?php

// ADDS USERS' POST TO THE DATABASE
$post = @$_POST['post'];
$postimage = @$_POST['post-image'];
if ($post != "") {
$date_added = date("Y-m-d");
$added_by = $user;
$user_posted_to = $username;
$user_id = $_SESSION['id'];

$sqlCommand = "INSERT INTO post VALUES('', '$post','$date_added','$added_by', '$user_id', '$postimage')";
$query = mysql_query($sqlCommand) or die (mysql_error());

}
?>
<div class="row">
  <div class="medium-7 medium-centered columns">

    <!-- Post form for user to add post -->
          <form class="" action="" method="POST">
        	   <textarea type="text" class="home-post" name="post" placeholder="Post an update!"rows="" cols=""></textarea>
          <input type="file" name="post-image" /><br />
        	<input class="button round"type="submit" name="send" value="Post"/>
        	</form>
        </div>

</div>
</div>



<div class="row">
  <div class="medium-7 medium-centered columns">
  <?php
  //If the user is logged in

  $getposts = mysql_query("SELECT * FROM post WHERE username='$user' & user_id IN (SELECT user2_id FROM following WHERE user1_id='$user_id') ORDER BY date_added DESC LIMIT 10 ") or die(mysql_error());

  while ($row = mysql_fetch_assoc($getposts)) {
  						$id = $row['id'];
  						$body = $row['body'];
              $added_by = $row['username'];
  						$date_added = $row['date_added'];


$get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
$get_info = mysql_fetch_assoc($get_user_info);

//RETRIEVES THE USERS' PROFILE PIC FROM THE DATABASE

$profilepic_info = $get_info['profile_pic'];
if ($profilepic_info == "") {
$profilepic_info = "./img/default_pic.jpg";
}
else
{
$profilepic_info = "./userdata/profile_pics/".$profilepic_info;
}
?>

<?php
// DISPLAYS THE USERS POSTS

  	echo  "
      <p />
  		<div class='single-post'>
      <div class='single-post-prof-image'>
          <img src='$profilepic_info' >
      </div>
  		<div class='single-post-user'>$added_by</div>
          <br /><br />
      <div class='single-post-body'>$body</div>
      <br/>
      <div class=''>$postimage</div>
      <p class='date'>$date_added</p>
        <p />
      </div>";
  }
  }
  ?>


</div>