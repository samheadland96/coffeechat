<?php include("inc/incfiles/headerloggedin.inc.php"); ?>

<?php
    $searchresult = $_GET['result'];
?>
<div class="row">
  <div class='medium-10 medium-centered columns'>
<h1>You searched for "<?php echo $searchresult; ?>"</h1>
</div>
</div>
<?php
$get_user_info = mysql_query("SELECT * FROM users WHERE username='$searchresult' ");
$get_info = mysql_fetch_assoc($get_user_info);

$profilepic_info = $get_info['profile_pic'];
if ($profilepic_info == "") {
$profilepic_info = "./img/default_pic.jpg";
}
else
{
$profilepic_info = "./userdata/profile_pics/".$profilepic_info;
}


//$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
$getposts = mysql_query("SELECT * FROM users WHERE username='$searchresult' ORDER BY id DESC LIMIT 10") or die(mysql_error());

if ($getposts) {

while ($row = mysql_fetch_assoc($getposts)) {
          $id = $row['id'];
          $username = $row['username'];
          $profilepic = $row['profile_pic'];

?>
<div class="row">
  <div class='medium-10 medium-centered columns'>

<?php
          echo  "

<div class='single-post'>
<div class='row'>
<div class='medium-8 columns'>
          <div class='search-pic'>
          <img src='$profilepic_info' height=''>
          <a href='$username'>$username</a>
          </div>

</div>
<div class='medium-4 columns'>

<p class='viewprofile'><a href='$username'>View Profile</a></p>

</div>
</div>
</div>
          </div>
          </div>
          ";

}
}
else {
  echo "No Results found";
}
?>
