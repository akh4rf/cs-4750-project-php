<?php include_once "includes/header.php";
  include("./database/db-helpers.php");

  session_start();
  if($_SERVER["REQUEST_METHOD"]==='POST'){
    $myusername=$_POST['username'];
    $mypassword=$_POST['password'];
    $sql="INSERT INTO Users VALUES (NULL, ?, ?)";
    $statement=$db->prepare($sql);
    try{
      $data=execute_query($sql,array($myusername,$mypassword));
      if($data['row_count']==1){
        $user=$data['rows_affected'][0];
        $_SESSION['username']=$user['username'];
        header("location: login");
      }
    }catch(PDOException $e){
      if($e->getCode() == 'HY093'){ //Handle duplicate error
        $error_msg="Your username is taken";
      }else{
        $error_msg=$e;
      }
    }
  
  }
?>

<link rel="stylesheet" href="css/login-registration.css">
<div class="inner-page-contents">
  <div style="width: 100%;">
    <form class="login-form" action="register" method="post">
      <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 40px; text-shadow: -4px 4px 5px var(--dark-blue);">REGISTER</h1>
      <input type="text" name="username" id="username" autofocus placeholder="Enter Username...">
      <input type="password" name="password" id="password" placeholder="Enter Password...">
      <button type="submit">Submit</button>
      <?php if (isset($error_msg)){echo "<p style='color:red;margin-top: 10px'>".$error_msg."</p>";}?>
      <a style="margin-top: 10px;" href=<?php echo transformPath('/login') ?>>Log In</a>
    </form>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
