<?php

include_once "includes/header.php";

loginCheck();

//Team Information
$UserID = $_SESSION['UserID'];
$sql = "SELECT TeamID, name, description, homeColor, awayColor, nationality FROM Team WHERE UserID=?;";
$teaminfo = execute_query($sql, array($UserID));
if ($teaminfo['row_count'] == 1) {
  $user = $teaminfo['rows_affected'][0];
  $teamname = $user['name'];
  $description = $user['description'];
  $homeColor = $user['homeColor'];
  $awayColor = $user['awayColor'];
  $nationality = $user['nationality'];
  $teamid = $user['TeamID'];
} else {
  $error_msg = "Error!";
}

$sql2 = "SELECT RLPID, name, picURL, age, position, mvps, goals, assists FROM RLPlayer NATURAL JOIN TeamPlayer WHERE TeamID=?";
$rosterinfo = execute_query($sql2, array($teamid));
$rostersize = $rosterinfo['row_count'];

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  if ($_POST['POST-TYPE'] == 'RemovePlayer') {
    for ($i = 0; $i < $rostersize; $i++) {
      if (isset($_POST['button-' . $i])) {
        $sql3 = "DELETE FROM TeamPlayer WHERE TeamID=? AND RLPID=?";
        // Delete player from team in DB
        $removeinfo = execute_query($sql3, array($teamid, $rosterinfo['rows_affected'][$i]['RLPID']));
        // Decrement roster size and nullify player in returned team data
        $rostersize -= 1;
        for ($j = $i; $j < $rostersize; $j++) {
          $rosterinfo['rows_affected'][$j] = $rosterinfo['rows_affected'][$j + 1];
        }
      }
    }
  } else if ($_POST['POST-TYPE'] == 'EditTeamInfo') {
    // Retrieve title, comment & rating from POST data
    $teamname = $_POST['teamName'];
    $description = $_POST['description'];
    $nationality = $_POST['nationality'];
    $homeColor = $_POST['homeColor'];
    $awayColor = $_POST['awayColor'];


    $sql4 = "UPDATE Team SET name = ?, description = ?, homeColor = ?, awayColor = ?, nationality = ? WHERE UserID = ?;";

    //check order of these values in database
    $data2 = execute_query($sql4, array($teamname, $description, $homeColor, $awayColor, $nationality, $UserID));
  }
}

$countries = json_decode(file_get_contents('./countries.json'), true);

?>

<link rel="stylesheet" href=<?php echo transformPath('/css/modal.css') ?>>

<div class="modal" id="myModal">
  <div class="modal-contents">
    <span class="close">&times;</span>
    <div class="modal-contents-inner">
      <h1 style="font-size: 2em; font-weight: 700; margin-top: 20px;"> Edit Roster Information </h1>
      <h2 style="font-size: 1.5em; font-weight: 500; margin-top: 35px; text-align: left;"> Current Information: </h2>
      <div style="margin-top: 15px; word-break: break-all;" class="grid">
        <p> Team Name: </p>
        <p style="text-align: left;">"<?php echo $teamname ?>"</p>
        <p> Team Description: </p>
        <p style="text-align: left;">"<?php echo $description ?>"</p>
        <p> Team Nationality: </p>
        <p style="text-align: left;">"<?php echo $nationality ?>" </p>
        <p> Team Colors: </p>
        <p style="text-align: left;">"<?php echo $homeColor ?> and <?php echo $awayColor ?>" </p>
      </div>
      <h2 style="font-size: 1.5em; font-weight: 500; margin-top: 35px; text-align: left;"> New Information: </h2>
      <form action="my-roster" method="post">
        <input type="text" name="POST-TYPE" value="EditTeamInfo" style="display: none;">
        <div class="grid">
          <p> Team Name: </p><input type="text" name="teamName" placeholder="Enter new team name..." value="<?php echo $teamname ?>" autofocus required>
          <p> Team Description: </p><textarea name="description" placeholder="Enter new description..." maxlength="255" required><?php echo $description ?></textarea>
          <p> Team Nationality: </p><select name="nationality" id="nationality" style="max-width: 100%; width: 100%;" required>
            <?php foreach ($countries as $country) : ?>
              <option <?php if ($nationality == $country['alpha2']) {
                        echo 'selected';
                      } ?> value="<?php echo $country['alpha2'] ?>"><?php echo $country['name'] ?></option>
            <?php endforeach ?>
          </select>
          <p> Home Color: </p><input type="color" name="homeColor" placeholder="Enter new home color... " value="<?php echo $homeColor ?>">
          <p> Away Color: </p><input type="color" name="awayColor" placeholder="Enter new away color... " value="<?php echo $awayColor ?>">
        </div>
        <button type="submit" id="confirm">Confirm</button>
      </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="./flag-icon-css/css/flag-icon.min.css">

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
          <div style="margin-top: 15px; display: flex; gap: 10px;">
            <button class="profile-button" id="myButton"> <i class="fas fa-cog"></i> Team Settings </button>
            <a class="profile-button" style="text-decoration: none;" href=<?php echo transformPath('/teaminfo') ?>><i class="fas fa-download"></i> Export Data</a>
          </div>
        </div>
      </div>
    </div>
    <div class="profile-column" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px;">
      <div id="roster-header">
        <hr style="margin-bottom: 10px;">
        <h1>ROSTER</h1>
        <hr style="margin-top: 10px;">
      </div>
      <form action="my-roster" method="post" class="roster">
        <?php for ($i = 0; $i < $rostersize; $i++) :
          $info = $rosterinfo['rows_affected'][$i];
        ?>
          <div class="roster-player-wrapper">
            <div class="roster-player-info">
              <div style="height: 100%; display: flex; padding: 0 20px;">
                <div style="height: 100%; display: flex; flex-direction: column; justify-content: center; font-weight: 700;">
                  <div><?php echo $info['name'] ?></div>
                  <?php if ($info['age'] > 0) : ?>
                    <div>Age: <?php echo $info['age'] ?></div>
                  <?php endif; ?>
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
              <button type="submit" name="button-<?php echo $i ?>"><i class="far fa-times-circle" style="display: flex;"></i></button>
              <div class="roster-player-pfp">
                <?php if ($info['picURL']) : ?>
                  <img src=<?php echo $info['picURL'] ?> alt="">
                <?php else : ?>
                  <p style="color: white; font-weight: 700;">No Picture</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endfor ?>
        <?php for ($i = $rostersize; $i < 5; $i++) :
        ?>
          <div class="roster-player-wrapper">
            <div class="roster-player-info">
              <div style="height: 100%; display: flex; justify-content: center; align-items: center; padding: 0 20px;">
                <div style="font-weight: 700;">EMPTY PLAYER SLOT</div>
              </div>
              <button type="submit" name="button-<?php echo $i ?>"><i class="far fa-times-circle" style="display: flex;"></i></button>
              <div class="roster-player-pfp">
                <a style="border-radius: 999px; height: 60%; width: 60%; border: 5px solid white; display: flex; justify-content: center; align-items: center; text-decoration: none;" href="<?php echo transformPath('/player-search'); ?>">
                  <i class="fas fa-plus" style="color: white; font-size: 48px;"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endfor ?>
        <input type="text" name="POST-TYPE" value="RemovePlayer" style="display: none;">
      </form>
    </div>
  </div>
</div>

<script src="./js/modal.js"></script>

<?php include_once "includes/footer.php" ?>
