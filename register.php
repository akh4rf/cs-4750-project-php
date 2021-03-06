<?php include_once "includes/header.php";
include("./includes/LR-error-bar.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $myusername = $_POST['username'];
  $mypassword = $_POST['password'];

  if (strlen($mypassword) < 6) {
    $error_msg = "Password too short.";
  } else {
    $sql = "INSERT INTO Users VALUES (NULL, ?, ?)";
    $data = execute_query($sql, array($myusername, $mypassword));

    if ($data['row_count'] == 1) {
      // User's corresponding UserInfo and Team instances are created by SQL Triggers
      redirectTo('/login');
    } else {
      $error_code = $data['error_info'][1];
      if ($error_code == 1062) {
        $error_msg = "This username is taken!";
      } else {
        $error_msg = "Error creating user. Please contact support.";
      }
    }
  }
}
?>

<link rel="stylesheet" href="css/login-registration.css">
<div class="inner-page-contents">
  <?php if (isset($error_msg)) {
    LR_error_bar($error_msg);
  } ?>
  <div style="width: 100%;">
    <form class="login-form" action="register" method="post">
      <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 40px; text-shadow: -4px 4px 5px var(--dark-blue);">REGISTER</h1>
      <input type="text" name="username" id="username" autofocus placeholder="Enter Username...">
      <input type="password" name="password" id="password" placeholder="Enter Password...">
      <button type="submit">Submit</button>
      <a style="margin-top: 10px;" href=<?php echo transformPath('/login') ?>>Log In</a>
    </form>
  </div>
</div>

<script src="./js/LR-error-bar.js"></script>
<?php include_once "includes/footer.php" ?>
