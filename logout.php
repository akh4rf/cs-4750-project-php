<!-- //destroy and unset session variables
//then redirect back to home page -->

<?php include_once "includes/header.php";

unset($_SESSION['UserID']);
session_destroy();
redirectTo('/');

include_once "includes/footer.php"
?>
