<?php

include_once "includes/header.php";

include './database/db-helpers.php';

loginCheck();

$teamid = execute_query("SELECT TeamID FROM Team WHERE UserID=?", array($_SESSION['UserID']))['rows_affected'][0]['TeamID'];

// Current Team Members
$sql2 = "SELECT RLPID, TeamID FROM TeamPlayer WHERE TeamID=?";
$team_players = execute_query($sql2, array($teamid));
$current_players = array();
for ($i = 0; $i < $team_players['row_count']; $i++) {
  array_push($current_players, intval($team_players['rows_affected'][$i]['RLPID']));
}


$sql = "SELECT RLPID, name, position, mvps, goals, assists FROM RLPlayer";
$search_params = array();

if (isset($_POST['POST-TYPE'])) {
  if ($_POST['POST-TYPE'] == 'Add/Remove') {
    // Get clicked player button
    foreach ($_POST as $button => $val) {
      $button_info = explode('-', $button);
      if (count($button_info) == 3) {
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
    }
  } else if ($_POST['POST-TYPE'] == 'Search') {
    // Update results to match search terms
    $searchInput = "%" . $_POST['player-search'] . "%";
    $sql .= ' WHERE name LIKE ?';
    array_push($search_params, $searchInput);
  }
}

if (isset($_POST['sort'])) {
  switch ($_POST['sort']) {
    case 'Name_A_Z':
      // Sort by ascending name
      $sql .= " ORDER BY name";
      break;
    case 'Name_Z_A':
      // Sort by descending name
      $sql .= " ORDER BY name DESC";
      break;
    case 'Goals':
      // Sort by descending goals
      $sql .= " ORDER BY goals DESC";
      break;
    case 'Assists':
      // Sort by descending assists
      $sql .= " ORDER BY assists DESC";
      break;
    case 'MVPs':
      // Sort by descending mvps
      $sql .= " ORDER BY mvps DESC";
      break;
    default:
      break;
  }
}

$data = execute_query($sql, $search_params);

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
    <form class="player-search-top-section" action="player-search" method="post">
      <div class="ps-input">
        <input type="text" name="POST-TYPE" value="Search" style="display: none;">
        <input type="text" name="player-search" id="player-search" placeholder="Search Player Info..." autofocus>
        <i class="fas fa-search"></i>
      </div>
      <div class="ps-dropdown">
        <label for="sort">Sort By: </label>
        <select name="sort" id="sort-input" onchange="this.form.submit()">
          <option selected disabled value="">----- Select Option -----</option>
          <option value="Name_A_Z">Name (A-Z)</option>
          <option value="Name_Z_A">Name (Z-A)</option>
          <option value="Goals">Goals</option>
          <option value="Assists">Assists</option>
          <option value="MVPs">MVPs</option>
        </select>
      </div>
      <input type="submit" style="display: none" />
    </form>

    <div class="player-search-bottom-section">
      <form class="table-wrapper" action="player-search" method="post">
        <input type="text" name="POST-TYPE" value="Add/Remove" style="display: none;">
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
            <?php $i = 0;
            for (; $i < $data['row_count']; $i++) :
              $player = $data['rows_affected'][$i]; ?>
              <tr>
                <td><?php textTD($player['name']) ?></td>
                <td><?php textTD(substr($player['position'], 0, strlen($player['position']) - 1)) ?></td>
                <td><?php textTD($player['goals']) ?></td>
                <td><?php textTD($player['assists']) ?></td>
                <td><?php textTD($player['mvps']) ?></td>
                <td style="vertical-align: top;"><?php actionsTD($player['RLPID']) ?></td>
              </tr>
            <?php endfor;
            for (; $i < 5; $i++) : ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
