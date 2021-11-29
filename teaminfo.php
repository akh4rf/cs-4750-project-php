<?php

session_start();
include("./database/db-helpers.php");

//Team Information
$myuserid = $_SESSION['UserID'];
$sql = "SELECT TeamID, name, description, homeColor, awayColor, nationality FROM Team WHERE userid=?;";
$teaminfo = execute_query($sql, array($myuserid));
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

for ($i = 0; $i < $rostersize; $i++) {
  foreach ($rosterinfo['rows_affected'][$i] as $key => $val) {
    if (is_numeric($key)) {
      unset($rosterinfo['rows_affected'][$i][$key]);
    }
  }
}

$jsonData = array(
  "User ID" => $myuserid,
  "Team ID" => $teamid,
  "Team Name" => $teamname,
  "Team Description" => $description,
  "Home Color" => $homeColor,
  "Away Color" => $awayColor,
  "Nationality" => $nationality,
  "Number of Players" => $rostersize,
  "Players" => $rosterinfo['rows_affected']
);

$file = "TeamInfo.json";
$json = fopen($file, "w") or die("Unable to open file!");
fwrite($json, json_encode($jsonData, JSON_PRETTY_PRINT));
fclose($json);
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=' . basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header('Content-type: application/json');
readfile($file);

?>
