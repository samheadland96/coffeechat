<?php
include("inc/incfiles/headerloggedin.inc.php");

include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
include('./classes/Notify.php');

?>

<?php
if (!isset($_SESSION["user_login"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=\">";
}
else
{
?>
<?php
?>
<div class="row">
  <div class="medium-7 medium-centered columns">
          <form class="post-form" action="<?php echo $username; ?>" method="POST">
        	<textarea type="text" class="post-update" name="post" placeholder="Post an update!"rows="" cols=""></textarea>
          Upload a photo!
          <input type="file" name="post-image" /><br />
        	<input class="button post-button"type="submit" name="send" value="Post"/>
        	</form>
        </div>

</div>
</div>
<?php
//If the user is logged in
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

<script language="javascript">
         function toggle<? echo $id; ?>() {
           var ele = document.getElementById("toggleComment<? echo $id; ?>");
           var text = document.getElementById("displayComment<? echo $id; ?>");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>

<div class="row">
<div class="medium-7 medium-centered columns">
  <?php
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
    <h6><a href='logout.php' style='float:right;'>Logout</a></h6>
    <table>
      <tr>
        <td>
          <img src='./default.jpg' style='width:35px;'alt='display picture'/>
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

}
}
?>


</div>
