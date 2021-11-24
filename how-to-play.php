<?php include_once "includes/header.php" ?>
<link rel="stylesheet" href="css/instructions.css">

<div class="inner-page-contents">

<div class="feedback-container">
    <div class="feedback-title">
      <h1>Background Information</h1>
    </div>
    <div class="feedback-form">
      <h2 style="margin-top: 25px; color: var(--dark-blue); font-weight: 700;">How Would You Rate Our App?</h2>
      <input type="text" placeholder="Enter your title here..." name="title" id="title" style="margin-bottom: 10px; width: 75%; font-size: 1em; padding: 10px;" autofocus required>
      <textarea name="comment" placeholder="Enter your review here..." required></textarea>
      <button type="submit">Submit</button>
    </div>
  </div>

  <div class="feedback-container">
    <div class="feedback-title">
      <h1>Scoring Breakdown</h1>
    </div>
    <form class="feedback-form" action="submit-feedback" method="post">
      <h2 style="margin-top: 25px; color: var(--dark-blue); font-weight: 700;">How Would You Rate Our App?</h2>
      <input type="text" placeholder="Enter your title here..." name="title" id="title" style="margin-bottom: 10px; width: 75%; font-size: 1em; padding: 10px;" autofocus required>
      <textarea name="comment" placeholder="Enter your review here..." required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>

  <!-- <div class="backgroundinfo">
  <p>Welcome to Upper90! You are in charge of a fantasy soccer team of five players.</p>
  <p>The goal is to choose players and assemble a roster that gets you the most points. </p>
  <p>You can compete with your friends and make changes to your team along the way.</p>
</div> -->

<!-- <div class="scoring">
  <p>Each player's points is based on their real life performances</p>
  <p>The point breakdown is as follows:</p>
</div> -->

  <!-- <p class="Instructions">Figure shows how to register and login to get started to play the game:</p> -->
  <!-- <img src="https://static01.nyt.com/images/2020/09/25/sports/25soccer-nationalWEB1/merlin_177451008_91c7b66d-3c8a-4963-896e-54280f374b6d-superJumbo.jpg"  width="100" height="100"> -->
</div>
</div>
<?php include_once "includes/footer.php" ?>
