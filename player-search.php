<?php

include_once "includes/header.php";

include './database/db-helpers.php';

loginCheck();

$sql = "SELECT RLPID, name, position, mvps, goals, assists FROM RLPlayer";

$data = execute_query($sql);

$teamid = execute_query("SELECT TeamID FROM Team WHERE UserID=?", array($_SESSION['UserID']))['rows_affected'][0]['TeamID'];

// Current Team Members
$sql2 = "SELECT RLPID, TeamID FROM TeamPlayer WHERE TeamID=?";
$team_players = execute_query($sql2, array($teamid));
$current_players = array();
for ($i = 0; $i < $team_players['row_count']; $i++) {
  array_push($current_players, intval($team_players['rows_affected'][$i]['RLPID']));
}

// Get clicked player button
foreach ($_POST as $button => $val) {
  $button_info = explode('-', $button);
  $RLPID = intval($button_info[1]);
  switch ($button_info[2]) {
    case 'add':
      if (count($current_players) < 5) {
        $timestamp = date('Y-m-d H:i:s');
        $add_sql = "INSERT INTO TeamPlayer VALUES (?, ?, ?, 0, 0, 0)";
        $addinfo = execute_query($add_sql, array($RLPID, $teamid, $timestamp));
        array_push($current_players, $RLPID);
      }
      break;
    case 'remove':
      if (count($current_players) > 0) {
        $remove_sql = "DELETE FROM TeamPlayer WHERE TeamID=? AND RLPID=?";
        // Delete player from team in DB
        $removeinfo = execute_query($remove_sql, array($teamid, $RLPID));
        if (($idx = array_search($RLPID, $current_players)) !== false) {
          unset($current_players[$idx]);
        }
      }
      break;
    default:
      echo "ERROR";
      break;
  }
}

function actionsTD($RLPID)
{
  global $current_players;
  $style = 'width: 80%;
            color: white;
            border: none;
            padding: 1rem;
            font-family: \'Open Sans\', sans-serif;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;';

    if (in_array($RLPID, $current_players)) {
      $style .= ' background-color: red;';
      $action = "Remove";
      $RLPID .= '-remove';
    } else {
      if (count($current_players) == 5) {
        $style .= ' background-color: gray;';
        echo '<div class="ps-actions">
            <button type="submit" style="' . $style . ' cursor: unset;" disabled>Roster Full</button>
            </div>';
        return;
      }
      $style .= ' background-color: green;';
      $action = "Add";
      $RLPID .= '-add';
    }
    echo '<div class="ps-actions">
          <button name="button-' . $RLPID . '" type="submit" style="' . $style . '">' . $action . ' Player</button>
        </div>';
}

function textTD($contents)
{
  echo '<div class="ps_text">' . $contents . '</div>';
}

?>

<link rel="stylesheet" href="css/player-search.css">
<div class="inner-page-contents">
  <div class="player-search">
    <div class="player-search-top-section">
      <div class="ps-input">
        <input type="text" name="player-search" id="player-search" placeholder="Search Player Info..." autofocus>
        <i class="fas fa-search"></i>
      </div>
      <div class="ps-dropdown">
        <label for="sort">Sort By: </label>
        <select name="sort" id="sort-input">
          <option selected disabled value="">----- Select Option -----</option>
          <option value="Name_A_Z">Name (A-Z)</option>
          <option value="Name_Z_A">Name (Z-A)</option>
          <option value="Goals">Goals</option>
          <option value="Assists">Assists</option>
          <option value="MVPs">MVPs</option>
        </select>
      </div>
    </div>
    <div class="player-search-bottom-section">
      <form class="table-wrapper" action="player-search" method="post">
        <table>
          <thead>
            <tr class="table-header">
              <th>Player Name</th>
              <th>Position</th>
              <th style="width: 100px;">Goals</th>
              <th style="width: 100px;">Assists</th>
              <th style="width: 100px;">MVPs</th>
              <th style="width: 200px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < $data['row_count']; $i++) :
              $player = $data['rows_affected'][$i]; ?>
              <tr>
                <td><?php textTD($player['name']) ?></td>
                <td><?php textTD(substr($player['position'], 0, strlen($player['position']) - 1)) ?></td>
                <td><?php textTD($player['goals']) ?></td>
                <td><?php textTD($player['assists']) ?></td>
                <td><?php textTD($player['mvps']) ?></td>
                <td style="vertical-align: top;"><?php actionsTD($player['RLPID']) ?></td>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
        </form>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
