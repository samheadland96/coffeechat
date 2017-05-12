<?php
$id = $_GET['id'];

// Selects id from post table where the id is equal to the one passed through in the link
$query = mysql_query("SELECT * FROM post WHERE id='$id'");
mysql_close($conn);

// If statement to check if query has been made
if(mysql_num_rows($query)>=1)
{

}
			include 'connect.php';

			//Updates post table by adding 1 like to the 'likes' column where the id is equal.
			mysql_query("UPDATE post SET likes = likes + 1 WHERE id='$id'");
			mysql_close($conn);
			echo "<meta http-equiv=\"refresh\" content=\"0; url=home.php\">";
?>
