<?php
session_start();
$user_id = $_SESSION['id'];
?>
<?php
if($user_id){
	if($_POST['post']!=""){
		$tweet = htmlentities($_POST['post']);
		$timestamp = time();
		include 'connect.php';
		$query = mysql_query("SELECT username FROM users WHERE id ='$user_id'");
		$row = mysql_fetch_assoc($query);
		$username = $row['username'];
		mysql_query("INSERT INTO posts (username, user_id, post, timestamp) VALUES ('$username', '$user_id', '$tweet', $timestamp)");
		mysql_query("UPDATE users SET posts = posts + 1 WHERE id='$user_id'");
		mysql_close($conn);
		header("Location: .");
	}
}
?>
