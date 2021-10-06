<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fantasy Soccer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<?php

function isCurrentPath($path)
{
  $uri = $_SERVER['REQUEST_URI'];

  if (strpos($uri, '/cs-4750-project-php/') !== false) {
    $uri = substr($uri, strlen('/cs-4750-project-php'));
  }

  return $uri == $path;
}

?>

<body>

  <div style="display: grid; grid-template-rows: 10vh 90vh; width: 100vw; height: 100vh; color: white;">
    <div class="top-bar">
      <a style="height: 100%; text-decoration: none; padding: 0 25px; color: white;" href="/">
        <div style="display: flex; align-items: center; height: 100%; font-size: 32px;">Upper90</div>
      </a>
      <div style="font-size: 45px; padding: 0 25px;"><a style="text-decoration: none; color: white; height: 100%; display: flex; align-items: center;" href="/"><i class="far fa-user-circle"></i></a></div>
    </div>
    <div style="height: 100%; width: 100%; position: relative;">
      <?php include_once "includes/sidebar.php" ?>
      <div style="width: 100%; height: 100%; background: var(--light-blue); position: absolute; z-index: 5;">
