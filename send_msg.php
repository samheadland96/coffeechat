<?php
include("inc/incfiles/headerloggedin.inc.php");
?>
<div class="row">
<div class="medium-7 medium-centered columns">
<?php
if (isset($_GET['u'])) {
	$username = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($username)) {
 	//check user exists
	$check = mysql_query("SELECT * FROM users WHERE username='$username'");
	if (mysql_num_rows($check)===1) {
	$get = mysql_fetch_assoc($check);
	$username = $get['username'];

	//Check user isn't sending themself a private message
	if ($username != $user) {
          if (isset($_POST['submit'])) {
            $msg_title = strip_tags(@$_POST['msg_title']);
            $msg_body = strip_tags(@$_POST['msg_body']);
            $date = date("Y-m-d");
            $opened = "no";
            $deleted = "no";



            if (strlen($msg_title) < 3) {
             echo "Your message title cannot be less than 3 characters in length!";
            }

            else
            if (strlen($msg_body) < 3) {
             echo "Your message cannot be less than 3 characters in length!";
            }
            else
            {

            $send_msg = mysql_query("INSERT INTO messages VALUES ('','$user','$username','$msg_title', '$msg_body','$date','$opened', '$deleted')");
           echo "Your message has been sent!";
            }
          }
        echo "

        <form action='send_msg.php?u=$username' method='POST'>
        <h2>Send Message: ($username)</h2>
        <input type='text' name='msg_title' size='30' onClick=\"value=''\" placeholder='Enter the message title here ...' required=''><p />
        <textarea cols='50' rows='12' name='msg_body' required=''></textarea><p />
        <input type='submit' class='button round' name='submit' value='Send Message'>
        </form>

        ";
        }
        else
        {
         header("Location: $user");
        }
	}
	}
}
?>
</div>
