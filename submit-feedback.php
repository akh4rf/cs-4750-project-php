<?php include_once "includes/header.php";

loginCheck();

// Get post data (see example on Emily's branch)
// Construct SQL query, parameterize with "?"
// i.e. INSERT INTO FEEDBACK VALUES (?, ?, ?, ?, ?);
// $data = execute_query($sql, array($userID, $date, $title, $comment, $rating))

//1: get post data:
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  if (isset($_POST['rating'])) {
    // Retrieve UserID from session storage
    $UserID = $_SESSION['UserID'];
    // Retrieve title, comment & rating from POST data
    $title = $_POST['title'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO Feedback VALUES (?, ?, ?, ?, ?);";

    $data = execute_query($sql, array($UserID, $timestamp, $title, $comment, $rating));
  }
  if(isset($_POST['rating'])){
    echo '<script>alert("Thank you for your feedback!")</script>';
  }
}
?>

<link rel="stylesheet" href="css/feedback.css">
<div class="inner-page-contents">
  <div class="feedback-container">
    <div class="feedback-title">
      <h1>Submit Feedback</h1>
    </div>
    <form class="feedback-form" action="submit-feedback" method="post">
      <h2 style="margin-top: 25px; color: var(--dark-blue); font-weight: 700;">How Would You Rate Our App?</h2>
      <div id="rate" class="rate">
        <?php for ($i = 5; $i > 0; $i--) : ?>
          <input type="radio" id="star<?php echo $i ?>" name="rating" value=" <?php echo $i ?>"/>
          <label for="star<?php echo $i ?>" title="star<?php echo $i ?>">★ </label>
        <?php endfor ?>
      </div>
      <input type="text" placeholder="Enter your title here..." name="title" id="title" style="margin-bottom: 10px; width: 75%; font-size: 1em; padding: 10px;" autofocus required>
      <textarea name="comment" placeholder="Enter your review here..." required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
