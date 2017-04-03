<? include("inc/incfiles/headerloggedin.inc.php"); ?>


<?php


$username = $_GET[''];

$results = $conn->query("SELECT * FROM users WHERE username='$username'");

while($row=$results->fetch())
{
            // Echo message which then displays the films that were found in the database.
            echo "<p>";
            echo "$row[username]  <br/> ";

          }

?>
