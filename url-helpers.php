<?php

function redirectTo($path) {
  $protocol = ($_SERVER['HTTP_HOST'] == "cs4750-fantasy-sports.herokuapp.com") ? 'https' : 'http';
  header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . transformPath($path));
}

function isCurrentPath($path) {
  $uri = $_SERVER['REQUEST_URI'];

  if (strpos($uri, '/cs-4750-project-php/') !== false) {
    $uri = substr($uri, strlen('/cs-4750-project-php'));
  }
  // Need to check for home page, as otherwise this would always highlight the sidebar item for homepage
  return ($path == '/' && $uri != $path) ? false : (strpos($uri, $path) !== false);
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

function transformPath($path)
{
  $host = $_SERVER['HTTP_HOST'];
  if ($host != "cs4750-fantasy-sports.herokuapp.com") {
    $path = '/cs-4750-project-php' . $path;
  }
  return $path;
}

?>
