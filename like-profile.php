<?php
$id = $_GET['id'];

		$query = mysql_query("SELECT * FROM post WHERE id='$id'");
		mysql_close($conn);

if(mysql_num_rows($query)>=1)
{

}
			include 'connect.php';
			mysql_query("UPDATE post SET likes = likes + 1 WHERE id='$id'");
			mysql_close($conn);
			echo "<meta http-equiv=\"refresh\" content=\"0; url=\">";
?>
