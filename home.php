<?php
include("inc/incfiles/headerloggedin.inc.php");

$user = $_SESSION["user_login"];


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
  $profile_pic_query = mysql_query("UPDATE post SET photo='$rand_dir_name/$profile_pic_name' WHERE username='$username'");
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
$reviewcoffee = @$_POST['reviewcoffee'];
$postimage = @$_POST['post-image'];

if ($post != "") {
$date_added = date("Y-m-d");
$added_by = $user;
$user_posted_to = $username;
$user_id = $_SESSION['id'];

$sqlCommand = "INSERT INTO post VALUES('', '$post','$reviewcoffee','$date_added','$added_by','$user','$postimage', '')";
$query = mysql_query($sqlCommand) or die (mysql_error());

}
?>
<div class="row">
  <div class="medium-7 medium-centered columns">

    <!-- Post form for user to add post -->
          <form class="" action="" method="POST">
        	   <textarea type="text" class="home-post" name="post" placeholder="Write a post, upload a photo, review a coffee!"rows="" cols=""></textarea>
             <div class="row">
               <div class="medium-6 columns">
             <p><bold>Coffee Brand / Shop</bold></p><input type="text" class="noborder" name="reviewcoffee" placeholder="Enter brand/shop you want to review!"rows="" cols="">
</div>
<div class="medium-6 columns">
<p><bold>Upload Photo!</bold></p>
          <button class="file-input">
            <input type="file" class="file-input" name="post-image">
          </button><br />

        </div>

        </div>
        	<input class="button round"type="submit" name="send" value="Post"/>
        	</form>
        </div>

</div>
</div>



<div class="row">
  <div class="medium-7 medium-centered columns">
  <?php
  //If the user is logged in

  $getposts = mysql_query("SELECT * FROM post WHERE username='$username' & user_id IN (SELECT follower_id FROM following WHERE user_id='$user_id') ORDER BY date_added DESC") or die(mysql_error());

  while ($row = mysql_fetch_assoc($getposts)) {
  						$id = $row['id'];
  						$body = $row['body'];
              $review_brand = $row['brand_shop'];
              $added_by = $row['username'];
  						$date_added = $row['date_added'];
              $likes = $row['likes'];

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
          <a href='$added_by'><img src='$profilepic_info' ></a>
      </div>
  		<div class='single-post-user'><a href='$added_by'>$added_by</a></div>
          <br /><br />

      <div class='single-post-body'>
      <h4 class='brand-shop'><bold>$review_brand</bold></h4>$body</div>
      <br/>
      <div class=''>
      <img src='$postimage'>
      </div>
      <p><bold>$likes Likes</bold> <a style='color:#59cae0; font-weight:normal;' href='like.php?id=$id'>Like</a><p>

      <p class='date'>$date_added</p>
        <p />
      </div>";
  }
  }

  ?>


</div>
