<?php

function LR_error_bar($message)
{
  echo "<div class='login-error-bar'>
          <p style='color:white; font-size: 1em;'>" . $message . "</p>
          <i class='fas fa-times login-error-dismiss'></i>
        </div>
        ";
}

?>
