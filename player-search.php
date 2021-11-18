<?php

include_once "includes/header.php";

include './database/db-helpers.php';

loginCheck();

$sql = "SELECT RLPID, name, position, mvps, goals, assists FROM RLPlayer";

$data = execute_query($sql);

function actionsTD($RLPID)
{
  echo '<div class="ps-actions">
          <button style="color: green;">+</button>
          <button style="color: red;">-</button>
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
      <div class="table-wrapper">
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
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
