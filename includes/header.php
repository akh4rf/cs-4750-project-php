<!DOCTYPE html>
<html lang="en">

<?php
include_once 'url-helpers.php';
include("./database/db-helpers.php");
include 'login-check.php';
session_start();

// loginCheck();

$profilePicURL="";
if (isset($_SESSION['UserID'])) {
  $myuserid = $_SESSION['UserID'];
  $sql = "SELECT profilePicURL FROM UserInfo WHERE UserID=?;";
  $data = execute_query($sql, array($myuserid));
  if ($data['row_count'] == 1) {
    $user = $data['rows_affected'][0];
    $profilePicURL = $user['profilePicURL'];
  } else {
    $error_msg = "Error with UserInfo";
  }
}

?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fantasy Soccer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href=<?php echo transformPath('/css/reset.css') ?>>
  <link rel="stylesheet" href=<?php echo transformPath('/css/styles.css') ?>>
</head>

<body>

  <div style="display: grid; grid-template-rows: 10vh 90vh; width: 100vw; height: 100vh; color: white;">
    <div class="top-bar">
      <a style="height: 100%; text-decoration: none; padding: 0 25px; color: white;" href=<?php echo transformPath('/') ?>>
        <div style="display: flex; align-items: center; height: 100%; font-size: 32px;">Upper90</div>
      </a>
      <div style="font-size: 45px; padding: 0 25px;">
        <?php if (strlen($profilePicURL)==0) : ?>
          <a style="text-decoration: none; color: white; height: 100%; display: flex; align-items: center;" href=<?php echo transformPath('/login') ?>>
            <i class="far fa-user-circle"></i>
          </a>
        <?php else : ?>
          <a style="text-decoration: none; color: white; height: 100%; display: flex; align-items: center;" href="#" onclick="toggle_visibility('menu');">
          <img src="<?php echo $profilePicURL ?>" style="width: 50px; height: 50px; border-radius: 999px;">  
        </a>
          <div id="menu" style="text-decoration: none; color: black; background-color: var(--lightest-blue); height: 80px; display: flex; flex-direction: column; align-items: center; z-index:100; position: fixed;">
          <a style="text-decoration: none; font-size: 20px; margin-top: 10px; color: var(--dark-blue); font-weight: 700;" href=<?php echo transformPath('/logout') ?>>Logout</a>
          <a style="text-decoration: none; font-size: 20px; margin-top: 25px; color: var(--dark-blue); font-weight: 700;" href=<?php echo transformPath('/profile') ?>>Profile</a>
          </div>
          
        <?php endif ?>
      </div>
    </div>
    <div style="height: 100%; width: 100%; position: relative;">
      <?php include_once "includes/sidebar.php" ?>
      <div style="width: 100%; height: 100%; position: absolute; z-index: 5;">

      <script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';

    }
//-->
</script>