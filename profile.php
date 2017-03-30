<? include("inc/incfiles/headerloggedin.inc.php");

include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
include('./classes/Notify.php');
?>


<?php
if (isset($_GET['u'])) {
	$username = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($username)) {
 	//check user exists
	$check = mysql_query("SELECT username, first_name FROM users WHERE username='$username'");
	if (mysql_num_rows($check)===1) {
	$get = mysql_fetch_assoc($check);
	$username = $get['username'];
	$firstname = $get['first_name'];

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
				<div id="status"></div>
					<form action="<?php echo $username; ?>" method="POST">
							<textarea type="text" id="post" class="profile-post"name="post" placeholder="Post an update!"rows="4" cols="60"></textarea>
							<input class="button"type="submit" name="send" value="Post"/>
					</form>

					<div class="profilePosts">
						<?php

						function getTime($t_time){
							$pt = time() - $t_time;
							if ($pt>=86400)
								$p = date("F j, Y",$t_time);
							elseif ($pt>=3600)
								$p = (floor($pt/3600))."h";
							elseif ($pt>=60)
								$p = (floor($pt/60))."m";
							else
								$p = $pt."s";
							return $p;
						}
							if($user_id){
								include "connect.php";
								$query = mysql_query("SELECT username, followers, following, posts
						                              FROM users
						                              WHERE id='$user_id'
						                             ");
								mysql_close($conn);
								$row = mysql_fetch_assoc($query);
								$username = $row['username'];
								$tweets = $row['posts'];
								$followers = $row['followers'];
								$following = $row['following'];
								echo "
								<table>
									<tr>
										<td>
											<img src='./default.jpg' alt='display picture'/>
										</td>
										<td valign='top' style='padding-left:8px;'>
											<h6><a href='./$username'>@$username</a></h6>
											<h6 font=2 style='margin-top:-10px;'>Tweets: <a href='#'>$tweets</a> | Followers: <a href='#'>$followers</a> | Following: <a href='#'>$following</a></h6>
										</td>
									</tr>
								</table>
								<form action='tweet.php' method='POST'>
									<textarea class='form-control' placeholder='Type your tweet here' name='post'></textarea>
									<button type='submit' style='float:right;margin-top:3px;' class='btn btn-info btn-xs'>Tweet</button>
								</form>
								<br>
								<br>
								";
								include "connect.php";
								$tweets = mysql_query("SELECT username, post, timestamp
													   FROM posts
													   WHERE user_id = $user_id OR (user_id IN (SELECT user2_id FROM following WHERE user1_id='$user_id'))
													   ORDER BY timestamp DESC
													   LIMIT 0, 10
													  ");
								while($tweet = mysql_fetch_array($tweets)){
									echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
									echo "<div style='font-size:10px;float:right;'>".getTime($tweet['timestamp'])."</div>";
									echo "<table>";
									echo "<tr>";
									echo "<td valign=top style='padding-top:4px;'>";
									echo "<img src='./default.jpg' style='width:35px;'alt='display picture'/>";
									echo "</td>";;
									echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
									echo "<a style='font-size:12px;' href='./".$tweet['username']."'>@".$tweet['username']."</a>";
									$new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$tweet['post']);
									$new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
									echo "<div style='font-size:10px; margin-top:-3px;'>".$new_tweet."</div>";
									echo "</td>";
									echo "</tr>";
									echo "</table>";
									echo "</div>";
								}
								mysql_close($conn);
							}
						?>

					<?
					//$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
					while ($row = mysql_fetch_assoc($getposts)) {
											$id = $row['id'];
											$body = $row['body'];
											$date_added = $row['date_added'];
											$added_by = $row['added_by'];

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


											echo "
											<div class='single-post'>
					           <img class='profile-icon' src='$profilepic_info'>

											<div class='posted_by'>
											Posted by:
					                                                <a href='$added_by'>$added_by</a> on $date_added</div>
					                                                <br/><br/><br/>
					                                                <div class='profile-body'>
					                                                $body<br /><p /><p />
					                                                </div>
																													</div>
											";
					}

				if (isset($_POST['sendmsg'])) {
					 header("Location: send_msg.php?u=$username");
					}

					?>
					</div>
		</div>
<div class="small-4 large-4 columns">
<img class="profile-image" src="<? echo $profile_pic; ?>" alt="<? echo $username; ?>'s Profile" title="<? echo $username; ?>'s Profile" />
<div class="profile-title"><h3 class="profile-username"><?php echo $username; ?></h3></div>

<input type="submit" class="button addfriend-sendmsg" name="follow" value="Follow" />

 <form action="send_msg.php?u=<? echo $username; ?>" method="POST">

 <? echo $errorMsg; ?>
 <input type="submit" class="button addfriend-sendmsg" name="sendmsg" value="Send Message" />
 <!--<iframe src='http://localhost/like_but_frame.php?uid=<?php echo $username; ?>' style='border: 0px;height: 23px; width: 110px;'> </iframe>-->
 </form>
<div class="profileLeftSideContent">

<?php
  $about_query = mysql_query("SELECT bio FROM users WHERE username='$username'");
  $get_result = mysql_fetch_assoc($about_query);
  $about_the_user = $get_result['bio'];

  echo "<p class='profile-bio'><bold>Bio</bold><br>$about_the_user</p>";
?>
</div>
<div class="profileLeftSideContent">

<div class="profileLeftSideContent">
</div>
</div>
</div>
