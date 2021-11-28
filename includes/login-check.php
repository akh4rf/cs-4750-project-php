<?php

include('./url-helpers.php');

function loginCheck(){
    if(!isset($_SESSION['UserID'])){
        header("location: " . transformPath('/login'));
      }
}

?>
