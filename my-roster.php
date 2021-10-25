<?php

include_once "includes/header.php";
$iso = "us";
$color1 = "#FFFFFF";
$color2 = "#0000FF";

?>
<link rel="stylesheet" href="./vendor/components/flag-icon-css/css/flag-icon.min.css">

<div class="inner-page-contents">
  <div style="height: 100%; width: 100%; display: grid; grid-template-columns: 500px 1fr;">
    <div class="profile-column" style="padding: 20px 0 20px 40px">
      <div class="profile-info-container">
        <div class="profile-info-header">
          <h1 style="font-size: 1.25em;">Team Information</h1>
        </div>
        <div class="profile-info">
          <div class="profile-contents">
            <h1 style="font-size: 2.5em; font-weight: 700; margin-top: 20px;">TEAM NAME</h1>
            <hr style="margin-top: 10px; border: none; background: black; height: 4px; width: 75%;">
            </hr>
            <p style="color: black; padding: 25px 75px; font-size: 1.25em;">This is my team's description! My team is the best!</p>
          </div>
          <div class="team-info-row">
            <h2 style="font-size: 1.5em;">Team Nationality</h2>
            <span style="font-size: 80px; margin-left: auto;" class="flag-icon flag-icon-<?php echo $iso ?>"></span>
          </div>
          <div class="team-info-row">
            <h2 style="font-size: 1.5em;">Team Colors</h2>
            <div class="team-color" style="margin-left: auto; background: <?php echo $color1 ?>"></div>
            <div class="team-color" style="margin-left: 16px; background: <?php echo $color2 ?>"></div>
          </div>
          <button class="profile-button" style="margin-top: 15px;"> <i class="fas fa-cog"></i> Team Settings </button>
        </div>
      </div>
    </div>
    <div class="profile-column" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px;">
      <div id="roster-header">
        <hr style="margin-bottom: 10px;">
        <h1>ROSTER</h1>
        <hr style="margin-top: 10px;">
      </div>
      <div class="roster">
        <?php for ($i = 0; $i < 5; $i++) : ?>
          <div class="roster-player-wrapper">
            <div class="roster-player-info">
              <div style="height: 100%; display: flex; padding: 0 20px;">
                <div style="height: 100%; display: flex; flex-direction: column; justify-content: center; font-weight: 700;">
                  <div>Lionel Messi</div>
                  <div>Age: 34</div>
                </div>
                <div style="display: flex; margin: 0 auto;">
                  <div class="roster-player-statbox">
                    <div>12</div>
                    <div>Goals</div>
                  </div>
                  <div class="roster-player-statbox" style="margin: 0 25px">
                    <div>9</div>
                    <div>Assists</div>
                  </div>
                  <div class="roster-player-statbox">
                    <div>20</div>
                    <div>MVPs</div>
                  </div>
                </div>
              </div>
              <button id=<?php echo $i ?> onclick="removePlayer(this.id)"><i class="far fa-times-circle" style="display: flex;"></i></button>
              <div class="roster-player-pfp">
                <img src="./Messi.png" alt="">
              </div>
            </div>
          </div>
        <?php endfor ?>
      </div>
    </div>
  </div>
</div>

<script>
  function removePlayer(num) {
    console.log(num);
  }
</script>

<?php include_once "includes/footer.php" ?>
