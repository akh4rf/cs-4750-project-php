<!-- //destroy and unset session variables
//then redirect back to home page -->

<?php include_once "url-helpers.php";

session_start();
unset($_SESSION['UserID']);
session_destroy();
redirectTo('/');

?>
