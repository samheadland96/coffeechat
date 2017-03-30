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
?>
<div class="row">
  <div class="medium-7 medium-centered columns">
          <form class="" action="post.php" method="POST">
        	<textarea type="text" class="home-post" name="post" placeholder="Post an update!"rows="" cols=""></textarea>
          Upload a photo!
          <input type="file" name="post-image" /><br />
        	<input class="button round"type="submit" name="send" value="Post"/>
        	</form>
        </div>

</div>
</div>


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

}
// FOLLOWERS POSTS TO APPEAR HERE!!!
?>


</div>
