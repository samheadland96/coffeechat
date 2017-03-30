<head>
  <link rel="stylesheet" href="css/app.css">

</head>
<?php
session_start();
if (isset($_SESSION['user_login'])) {
$user = $_SESSION["user_login"];
}
else {
$user = "";
}
?>

<?php

include("./inc/scripts/mysql_connect.inc.php");
$getid = $_GET['id'];

?>
<!--<script language="javascript">
         function toggle() {
           var ele = document.getElementById("toggleComment");
           var text = document.getElementById("displayComment");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>-->

<?php
if (isset($_POST['postComment' . $getid . ''])) {
 $post_body = $_POST['post_body'];
 $posted_to = "sinimma";
 $insertPost = mysql_query("INSERT INTO post_comments VALUES ('','$post_body','$user','$posted_to','0','$getid')");
 echo "Comment Posted!<p />";
}
?>

<div id='toggleComment'  style='display:;'>
<form action="comment_frame.php?id=<?php echo $getid; ?>" method="POST" name="postComment<?php echo $getid; ?>">
<input type="text" class='comment-input' placeholder="Comment" name="post_body">
<input type="submit" name="postComment<?php echo $getid; ?>" value="Post Comment">
</form>
</div>
<?php

//Get Relevant Comments
$get_comments = mysql_query("SELECT * FROM post_comments WHERE post_id='$getid' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if ($count != 0) {
while ($comment = mysql_fetch_assoc($get_comments)) {

$comment_body = $comment['post_body'];
$posted_to = $comment['posted_to'];
$posted_by = $comment['posted_by'];
$removed = $comment['post_removed'];

echo "<p class='postedby'><b>$posted_by: </b></p><p class='comment-body'>".$comment_body."</p><hr />";

}
}
else
{
 echo "";
}

?>
