<?php
include("inc/incfiles/headerloggedin.inc.php");

?>

<?php
if (!isset($_SESSION["user_login"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=\">";
}
else
{
?>
<?php
$post = @$_POST['post'];
if ($post != "") {
$date_added = date("Y-m-d");
$added_by = $user;
$user_posted_to = $username;

$sqlCommand = "INSERT INTO post VALUES('', '$post','$date_added','$added_by')";
$query = mysql_query($sqlCommand) or die (mysql_error());

}
?>
<div class="row">
  <div class="medium-7 medium-centered columns">
          <form class="" action="" method="POST">
        	<textarea type="text" class="home-post" name="post" placeholder="Post an update!"rows="" cols=""></textarea>
          Upload a photo!
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
  $getposts = mysql_query("SELECT * FROM post WHERE added_by='$user' ORDER BY id DESC LIMIT 10") or die(mysql_error());
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

                                                  ?>


                                                 <?php
  						echo  "

  						<p />
  						<div class='single-post'>

                                                  <div class='single-post-prof-image'>
                                                  <img src='$profilepic_info' height=''>
                                                  </div>
  						<div class='posted_by'>$added_by</div>
                                                  <br /><br />
                                                  <div class='single-post-body'>
                                                  $body<br /><p /><p />
                                                  </div>
                                                  <p />
                                                  </div>
  						";
  }
  }
  ?>


</div>
