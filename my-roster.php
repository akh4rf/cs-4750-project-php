<?php

include_once "includes/header.php";
include("./database/db-helpers.php");

session_start(); //did session start so i could see changes take place, but in reality will only occur after button press
//Update Team Information
//information is retrieved from Team Settings
// $sql="UPDATE Team SET homeColor = 'Blue', awayColor = 'Red', nationality = 'England', description = 'test for aayush query', name = 'Tottenham' WHERE UserID = 100001;";
// $myuserid='100001'; //hardcoded, needs to be gained from session later
// $data=execute_query($sql,array($myuserid)); //updates database

//Team Information
$myuserid='100001'; //hardcoded, needs to be gained from session later
$sql="SELECT name, description, homeColor, awayColor, nationality FROM Team WHERE userid=?;";
$teaminfo = execute_query($sql,array($myuserid));
if($teaminfo['row_count']==1){
  $user=$teaminfo['rows_affected'][0];
    $teamname=$user['name'];
    $description=$user['description'];
    $homeColor=$user['homeColor'];
    $awayColor=$user['awayColor'];
    $nationality=$user['nationality'];
}else{
  $error_msg="Error!";
}

//Roster
//RLPlayer age, name, RLPID
//TeamPlayer RLPID, TeamID
//Team TeamID, UserID(input)

$sql2="SELECT name, picURL, age, position, mvps, goals, assists FROM RLPlayer NATURAL JOIN TeamPlayer WHERE TeamID=?";
$teamid=2;//teamID=2 is example
$rosterinfo = execute_query($sql2,array($teamid));
$rostersize=$rosterinfo['row_count'];
?>


<link rel="stylesheet" href="./vendor/components/flag-icon-css/css/flag-icon.min.css">

<div class="inner-page-contents">
  <div style="width: 100%; display: grid; grid-template-columns: 500px 1fr;">
    <div class="profile-column" style="padding: 20px 0 20px 40px">
      <div class="profile-info-container">
        <div class="profile-info-header">
          <h1 style="font-size: 1.25em;">Team Information</h1>
        </div>
        <div class="profile-info">
          <div class="profile-contents">
            <h1 style="font-size: 2.5em; font-weight: 700; margin-top: 20px;"><?php echo $teamname ?></h1>
            <hr style="margin-top: 10px; border: none; background: black; height: 4px; width: 75%;">
            </hr>
            <p style="color: black; padding: 25px 75px; font-size: 1.25em;"><?php echo $description ?></p>
          </div>
          <div class="team-info-row">
            <h2 style="font-size: 1.5em;">Team Nationality</h2>
            <span style="font-size: 80px; margin-left: auto;" class="flag-icon flag-icon-<?php echo $nationality ?>"></span>
          </div>
          <div class="team-info-row">
            <h2 style="font-size: 1.5em;">Team Colors</h2>
            <div class="team-color" style="margin-left: auto; background: <?php echo $homeColor ?>"></div>
            <div class="team-color" style="margin-left: 16px; background: <?php echo $awayColor ?>"></div>
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
        <?php for ($i = 0; $i < $rostersize; $i++) :
            $info=$rosterinfo['rows_affected'][$i];
        ?>
          <div class="roster-player-wrapper">
            <div class="roster-player-info">
              <div style="height: 100%; display: flex; padding: 0 20px;">
                <div style="height: 100%; display: flex; flex-direction: column; justify-content: center; font-weight: 700;">
                  <div><?php echo $info['name']?></div>
                  <div>Age: <?php echo $info['age'] ?></div>
                  <div><?php echo substr($info['position'], 0, strlen($info['position']) - 1) ?></div>
                </div>
                <div style="display: flex; margin: 0 auto;">
                  <div class="roster-player-statbox">
                  <div><?php echo $info['goals'] ?></div>
                    <div>Goals</div>
                  </div>
                  <div class="roster-player-statbox" style="margin: 0 25px">
                  <div><?php echo $info['assists'] ?></div>
                    <div>Assists</div>
                  </div>
                  <div class="roster-player-statbox">
                  <div><?php echo $info['mvps'] ?></div>
                    <div>MVPs</div>
                  </div>
                </div>
              </div>
              <button id=<?php echo $i ?> onclick="removePlayer(this.id)"><i class="far fa-times-circle" style="display: flex;"></i></button>
              <div class="roster-player-pfp"> 
                <img src=<?php echo $info['picURL'] ?> alt="">
              </div>
            </div>
          </div>
        <?php endfor ?>
        <?php for ($i = $rostersize; $i < 5; $i++) :
        ?>
        <div class="roster-player-wrapper">
            <div class="roster-player-info">
              <div style="height: 100%; display: flex; padding: 0 20px;">
                <div>ADD A PLAYER</div>
              </div>
              <button id=<?php echo $i ?> onclick="removePlayer(this.id)"><i class="far fa-times-circle" style="display: flex;"></i></button>
              <div class="roster-player-pfp">
                <img src="Messi.png" alt="">
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
