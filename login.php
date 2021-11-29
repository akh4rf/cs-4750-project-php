<?php include_once "includes/header.php";
include("./database/db-helpers.php");
include("./includes/LR-error-bar.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $myusername = $_POST['username'];
  $mypassword = $_POST['password'];
  $sql = "SELECT UserID,username FROM Users WHERE username=? AND password=?;";
  // "INSERT INTO Users VALUES (NULL, ?, ?)"

  $data = execute_query($sql, array($myusername, $mypassword));
  if ($data['row_count'] == 1) {
    $user = $data['rows_affected'][0];
    $_SESSION['username'] = $user['username'];
    $_SESSION['UserID'] = $user['UserID'];
    redirectTo('/');
  } else {
    $error_msg = "Your Username or Password is invalid.";
  }
}
?>
<link rel="stylesheet" href="css/login-registration.css">
<div class="inner-page-contents">
  <?php if (isset($error_msg)) {
    LR_error_bar($error_msg);
  } ?>
  <div style="width: 100%;">
    <form class="login-form" action="login" method="post">
      <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 40px; text-shadow: -4px 4px 5px var(--dark-blue);">LOG IN</h1>
      <input type="text" name="username" id="username" autofocus placeholder="Enter Username..." autocomplete="on">
      <input type="password" name="password" id="password" placeholder="Enter Password..." autocomplete="off">
      <button type="submit">Submit</button>
      <a style="margin-top: 10px;" href="">Forgot Password</a>
      <a href=<?php echo transformPath('/register') ?>>Register</a>
    </form>
  </div>
</div>

<script src="./js/LR-error-bar.js"></script>
<?php include_once "includes/footer.php" ?>
