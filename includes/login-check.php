<?php 

function loginCheck(){
    if(!isset($_SESSION['UserID'])){
        header("location: login");
      }
}

?>