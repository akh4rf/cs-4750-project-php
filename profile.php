<?php include_once "url-helpers.php"; ?>


<?php
include_once "includes/header.php";

loginCheck();

include("./database/db-helpers.php");
$myuserid = $_SESSION['UserID'];
$sql = "SELECT UserID, username, description, profilePicURL FROM Users NATURAL JOIN UserInfo WHERE UserID=?;";
$data = execute_query($sql, array($myuserid));
if ($data['row_count'] == 1) {
  $user = $data['rows_affected'][0];
  $UserID = $user['UserID'];
  $username = $user['username'];
  $description = $user['description'];
  $profilePicURL = $user['profilePicURL'];
} else {
  $error_msg = "Error";
}

$stats = array(
  "Austin" => array(0, 0, 2, 4, 5, 11, 11),
  "Ziyao" => array(0, 5, 6, 6, 7, 7, 7),
  "Jeffrey" => array(0, 1, 1, 7, 9, 9, 10),
  "Emily" => array(3, 3, 7, 9, 10, 13, 13),
);

$days = count($stats[array_key_first($stats)]);
$max = 0;

foreach ($stats as $k => $v) {
  for ($idx = 0; $idx < sizeof($v); $idx++) {
    $max = $max < $v[$idx] ? $v[$idx] : $max;
  }
}

?>

<link rel="stylesheet" href=<?php echo transformPath('/css/profile-modal.css') ?>>

<div class="profile-modal" id="myModal">
  <div class="modal-contents">
    <span class="close">&times;</span>
    <h1 style="font-size: 2em; font-weight: 700; margin-top: 20px;"> Edit Profile </h1>
    <h2 style="font-size: 1.5em; font-weight: 500; margin-top: 45px; text-align: left;"> Current Information: </h2>
    <p style="font-size: 1.25em; font-weight: 400; margin-top: 35px; text-align: left;"> Username: "<?php echo $username ?>"</p>
    <p style="font-size: 1.25em; font-weight: 400; margin-top: 15px; text-align: left;"> Description: "<?php echo $description ?>"</p>
    <p style="font-size: 1.25em; font-weight: 400; margin-top: 15px; text-align: left;"> Profile Picture: "<?php echo $profilePicURL ?>" </p>
    <h2 style="font-size: 1.5em; font-weight: 500; margin-top: 45px; text-align: left;"> New Information: </h2>
    <form class="profile-form" action= "confirm-changes" method= "post">
      <p style="font-size: 1.25em; font-weight: 400; margin-top: 35px; text-align: left;"> Username: <input type="text" name ="username" placeholder= "Enter new username:"></p>
      <p style="font-size: 1.25em; font-weight: 400; margin-top: 15px; text-align: left;"> Description: <input type="text" name ="description" placeholder= "Enter new description:"></p>
      <p style="font-size: 1.25em; font-weight: 400; margin-top: 15px; text-align: left;"> Profile Picture: <input type="text" name ="profilePic" placeholder= "Enter new URL: "></p>
      <button type="submit">Confirm</button>
    </form>
  </div>
</div>


<div class="inner-page-contents">
  <div style="height: 100%; width: 100%; display: grid; grid-template-columns: 500px 1fr;">
    <div class="profile-column" style="padding: 20px 0 20px 40px">
      <div class="profile-info-container">
        <div class="profile-info-header">
          <h1 style="font-size: 1.25em;">My Information</h1>
        </div>
        <div class="profile-info">
          <div class="profile-photo">
            <i class="far fa-user-circle"></i>
          </div>
          <div class="profile-contents">
            <h1 style="font-size: 2.5em; font-weight: 700; margin-top: 20px;"><?php echo $username ?></h1>
            <h2 style="font-size: 1.5em; font-weight: 700; margin-top: 10px;">(ID #<?php echo $UserID ?>)</h2>
            <p style="color: black; padding: 50px 75px; font-size: 1.25em;"><?php echo $description ?></p>
          </div>
          <button class="profile-button" id="myButton"> <i class="fas fa-pencil-alt"></i> Edit Profile </button>
        </div>
      </div>
    </div>
    <div class="profile-column" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px;">
      <div id="stats-header">
        <hr style="margin-bottom: 10px;">
        <h1>STATS</h1>
        <hr style="margin-top: 10px;">
      </div>
      <div id="stats-body">
        <div class="stat-box">
          <p class="stat-num">17</p>
          <p class="stat-label">MVPs</p>
        </div>
        <div class="stat-box">
          <p class="stat-num">24</p>
          <p class="stat-label">Goals</p>
        </div>
        <div class="stat-box">
          <p class="stat-num">33</p>
          <p class="stat-label">Assists</p>
        </div>
      </div>
      <div id="chart">
        <h2 style="position: absolute; text-align: center; font-size: 1.5em; width: 100%; color: black; top: -1em;">Points Over Time</h2>
        <?php

        $colors = ['#b34d61', '#456ede', '#1ea159', '#dad271'];
        shuffle($colors);
        $c = 0;

        foreach ($stats as $stat) :

          $color = $colors[$c++];

        ?>
          <div class="chart-layer">
            <div class="dot-wrapper">
              <?php for ($i = 0; $i < sizeof($stat); $i++) : ?>
                <div class="dot hidden-dot" style="background: <?php echo $color ?>;"></div>
                <?php if ($i < sizeof($stat) - 1) : ?>
                  <div class="line" style="background: <?php echo $color ?>;"></div>
                <?php endif; ?>
              <? endfor; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="chart-covers">
          <?php for ($i = 0; $i < $days; $i++) : ?>
            <div class="chart-cover" style="width: <?php echo 100 / $days ?>%"></div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="./js/profile-modal.js"></script>

<script src="js/chart.js"></script>
<?php
echo '<script>
let js_stats = ' . json_encode($stats) . ';
drawChart(10, 4, js_stats,' . $max . ', ' . $days . ' );
</script>';
?>
<script>
  function resize() {
    drawChart(10, 4, js_stats, <?php echo $max . ', ' . $days ?>)
  }
  window.addEventListener("resize", resize);
</script>

<?php include_once "includes/footer.php" ?>
