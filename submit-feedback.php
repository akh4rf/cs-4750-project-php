<?php include_once "includes/header.php";

include './database/db-helpers.php';

// Get post data (see example on Emily's branch)
// Construct SQL query, parameterize with "?"
// i.e. INSERT INTO FEEDBACK VALUES (?, ?, ?, ?, ?);
// $data = execute_query($sql, array($userID, $date, $title, $comment, $rating))



//1: get post data:
session_start();
  if($_SERVER["REQUEST_METHOD"]==='POST'){
    $myuserid=$_POST['UserID'];
    $mytitle=$_POST['title'];
    $mycomment=$_POST['comment'];
    $mytimestamp=$_POST['timestamp'];
    $myrating=$_POST['rating'];
    $sql="SELECT UserID,timestamp,title, comment,rating FROM Feedback WHERE UserID=? AND timestamp=? AND title=? AND comment=? AND rating=?;";
    //"INSERT INTO Users VALUES (NULL, ?, ?)"
    
    $data=execute_query($sql,array($myuserid, $mytimestamp,$mytitle,$mycomment,$myrating));
    if($data['row_count']==1){
      $user=$data['rows_affected'][0];
      $_SESSION['UserID']=$user['UserID'];
      $_SESSION['timestamp']=$user['timestamp'];
      $_SESSION['title']=$user['title'];
      $_SESSION['comment']=$user['comment'];
      $_SESSION['rating']=$user['rating'];
      header("location: submit-feedback");
    }
  }
?>

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
    <form class="feedback-form" action="submit-feedback" method="post">
      <h2 style="margin-top: 25px; color: var(--dark-blue); font-weight: 700;">How Would You Rate Our App?</h2>
      <div id="rate" class="rate">
        <?php for ($i = 5; $i > 0; $i--) : ?>
          <input type="radio" id="star<?php echo $i ?>" name="rate" value="<?php echo $i ?>" />
          <label for="star<?php echo $i ?>" title="star<?php echo $i ?>">★</label>
        <?php endfor ?>
      </div>
        <input type="text" placeholder="Enter your title here..." class="title"  style="margin-bottom: 25px; width: 30%; height: 50px;" autofocus>
      <textarea placeholder="Enter your review here..."></textarea>
      <p>Your feedback will not be shared with anyone else!</p>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
