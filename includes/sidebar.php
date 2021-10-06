<?php

$sidebar_items = array(

  "Home" => array("classes" => "fas fa-home", "path" => "./"),
  "How to Play" => array("classes" => "fas fa-info-circle", "path" => "how-to-play"),
  "Player Search" => array("classes" => "fas fa-search", "path" => "player-search"),
  "My Roster" => array("classes" => "fas fa-user-friends", "path" => "my-roster"),
  "Submit Feedback" => array("classes" => "fas fa-comment", "path" => "submit-feedback")
);

function getIconClassFromValue($v)
{
  echo 'class="' . $v . '"';
}

function getHoverClassFromURI($uri)
{
  $class = 'class="sidebar-item';
  if (isCurrentPath($uri)) {
    $class .= ' active"';
  } else {
    $class .= '"';
  }
  echo $class;
}

?>

<link rel="stylesheet" href="css/sidebar.css">

<div style="position: absolute; height: 100%; z-index: 10;">
  <div class="sidebar-wrapper">
    <div class="sidebar-contents">
      <?php foreach ($sidebar_items as $key => $value) : ?>
        <a <?php getHoverClassFromURI($value['path']) ?> href=<?php echo $value['path'] ?>>
          <div>
            <div class="sidebar-icon">
              <div><i <?php getIconClassFromValue($value['classes']) ?>></i></div>
            </div>
            <div class="sidebar-text">
              <div><?php echo $key ?></div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
