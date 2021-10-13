<?php

function isCurrentPath($path) {
  $uri = $_SERVER['REQUEST_URI'];

  if (strpos($uri, '/cs-4750-project-php/') !== false) {
    $uri = substr($uri, strlen('/cs-4750-project-php'));
  }

  return $uri == $path;
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
