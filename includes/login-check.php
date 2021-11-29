<?php

function loginCheck(){
    if(!isset($_SESSION['UserID'])){
      redirectTo('/login');
    }
}

?>
