<?php include_once "includes/header.php" ?>

<link rel="stylesheet" href="css/feedback.css">
<style>
  p{
    color: red;
    padding: 20px;
  }
</style>
<div class="inner-page-contents">
  <div class="feedback-container">
    <div class="feedback-title">
      <h1>Submit Feedback</h1>
    </div>
    <form class="feedback-form" action="">
      <h2 style="margin-top: 25px; color: var(--dark-blue); font-weight: 700;">How Would You Rate Our App?</h2>
      <div id="rate" class="rate">
        <?php for ($i = 5; $i > 0; $i--) : ?>
          <input type="radio" id="star<?php echo $i ?>" name="rate" value="<?php echo $i ?>" />
          <label for="star<?php echo $i ?>" title="star<?php echo $i ?>">★</label>
        <?php endfor ?>
      </div>
      <textarea autofocus placeholder="Enter your title here..." class="title"  style=" font-size: 100px min-width:500px; max-width:50%;min-height:50px;height:200%;width:50%;"></textarea>
      <textarea autofocus placeholder="Enter your review here..."></textarea>
      <p>Your feedback will not be shared with anyone else!</p>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
