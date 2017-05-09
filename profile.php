<?php include("inc/incfiles/headerloggedin.inc.php");
?>


<?php

if (isset($_GET['u'])) {
	$username = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($username)) {
 	//check user exists
	$check = mysql_query("SELECT id, username, first_name, last_name FROM users WHERE username='$username'");
	if (mysql_num_rows($check)===1) {
	$id = $row['id'];
	$get = mysql_fetch_assoc($check);
	$username = $get['username'];
	$firstname = $get['first_name'];
	$lastname = $get['last_name'];
	$user_id = $_SESSION['id'];

	}
	else
	{
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
	exit();
	}
	}
}
//Check whether the user has uploaded a profile pic or not
  $check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
  $get_pic_row = mysql_fetch_assoc($check_pic);
  $profile_pic_db = $get_pic_row['profile_pic'];
  if ($profile_pic_db == "") {
  $profile_pic = "img/default_pic.jpg";
  }
  else
  {
  $profile_pic = "userdata/profile_pics/".$profile_pic_db;
  }
?>
<div class="row">
		<div class="small-4 large-8 columns">

					<div class="profilePosts">


					<?php


					//$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
					$getposts = mysql_query("SELECT * FROM post WHERE username='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());

if ($getposts== 0) {
	echo "<h1>No posts yet!</h1>";
}

else {
				 while ($row = mysql_fetch_assoc($getposts)) {
 			   						$id = $row['id'];
 			   						$body = $row['body'];
										$brand_shop = $row['brand_shop'];
 			   						$date_added = $row['date_added'];
 			   						$added_by = $row['username'];
										$likes = $row['likes'];

 			$get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
			$get_info = mysql_fetch_assoc($get_user_info);
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
 echo  "
<p />
			<div class='single-post'>
			<div class='single-post-prof-image'>
					<img src='$profilepic_info' height=''> </div>
			<div class='posted_by'>$added_by</div>
 	  	<br /><br />
 			<div class='single-post-body'>
			<h4  class='brand-shop'><bold>$brand_shop</bold></h4>
			$body<br /><p /><p />

 			</div>
			<p><bold>$likes Likes</bold> <a style='color:#59cae0; font-weight:normal;' href='like.php?id=$id'>Like</a><p>
			<p class='date'>$date_added</p>

 			</div>
 			   						";
 			   }

}

				if (isset($_POST['sendmsg'])) {
					 header("Location: send_msg.php?u=$username");
					}


$getfollowers = mysql_query("SELECT * FROM users WHERE username='$username'") or die(mysql_error());
while ($row = mysql_fetch_assoc($getfollowers)) {
			$following = $row['following'];
			$followers = $row['followers'];

}
					?>
					</div>
		</div>
<div class="small-4 large-4 columns">
<img class="profile-image" src="<? echo $profile_pic; ?>" alt="<? echo $username; ?>'s Profile" title="<? echo $username; ?>'s Profile" />
<div class="profile-title"><h3 class="profile-username"><?php echo $username; ?></h3></div>
<div class="profile-title"><h5 class="profile-name"><?php echo $firstname; ?> <?php echo $lastname; ?></h5></div>
<h6 class="follow-section">Followers: <a href=""><?php echo $followers; ?></a> | Following: <a href=""><?php echo $following; ?></a></h6>

<div class="row">

	<div class="medium-6 columns">
<?php


		include 'connect.php';
		$query2 = mysql_query("SELECT * FROM following WHERE user_id='$user_id' AND follower_id='$id'");
		//mysql_close($conn);
		//if(mysql_num_rows($query2)>=1){
			//echo "<a href='unfollow.php?userid=$id&username=$username' class='button round follow-message'>Unfollow</a>";
		//}
		//else{
			echo "<a href='' class='button round follow-message'>Follow</a>";
		//}


?>




</div>
<div class="medium-6 columns">
	<a href="send_msg.php?u=<?php echo $username; ?>" class='button round follow-message'>Message</a>
</div>
</div>


<div class="profileLeftSideContent">
	<?php
		$about_query = mysql_query("SELECT bio FROM users WHERE username='$username'");
		$get_result = mysql_fetch_assoc($about_query);
		$about_the_user = $get_result['bio'];

		echo "<p class='profile-bio'><bold>Bio</bold><br>$about_the_user</p>";
	?>
<div class="profileLeftSideContent">
</div>
</div>
</div>
