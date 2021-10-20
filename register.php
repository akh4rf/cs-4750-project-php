<?php include_once "includes/header.php" ?>

<link rel="stylesheet" href="css/login-registration.css">
<div class="inner-page-contents">
  <div style="width: 100%;">
    <form class="login-form" action="">
      <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 40px; text-shadow: -4px 4px 5px var(--dark-blue);">REGISTER</h1>
      <input type="text" name="username" id="username" autofocus placeholder="Enter Username...">
      <input type="password" name="password" id="password" placeholder="Enter Password...">
      <button type="submit">Submit</button>
      <a style="margin-top: 20px;" href=<?php echo transformPath('/login') ?>>Log In</a>
    </form>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
