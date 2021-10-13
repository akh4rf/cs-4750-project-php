<?php

include_once "includes/header.php";

$rows = array(
  "One" => "One",
  "Two" => "Two",
  "Three" => "Three",
  "Four" => "Four",
  "Five" => "Five",
  "Six" => "Six"
);

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
        <label for="actions">Actions: </label>
        <select name="actions" id="actions-input">
          <option selected disabled value="">----- Select Option -----</option>
          <option value="Add">Add Player(s) To Team</option>
          <option value="Remove">Remove Player(s) From Team</option>
        </select>
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
              <th>Select</th>
              <th>Player Name</th>
              <th>Goals</th>
              <th>Assists</th>
              <th>MVPs</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $key => $value) : ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
