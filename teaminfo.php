<?php

include_once "includes/header.php";
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

//Roster
//RLPlayer age, name, RLPID
//TeamPlayer RLPID, TeamID
//Team TeamID, UserID(input)

$sql2 = "SELECT RLPID, name, picURL, age, position, mvps, goals, assists FROM RLPlayer NATURAL JOIN TeamPlayer WHERE TeamID=?";
$rosterinfo = execute_query($sql2, array($teamid));
$rostersize = $rosterinfo['row_count'];

//Print array in JSON format
// echo json_encode($jsonData);
for ($i = 0; $i < $rostersize; $i++) {
  if (isset($_POST['button-' . $i])) {
    $sql3 = "DELETE FROM TeamPlayer WHERE TeamID=? AND RLPID=?";
    // Delete player from team in DB
    $removeinfo = execute_query($sql3, array($teamid, $rosterinfo['rows_affected'][$i]['RLPID']));
    // Decrement roster size and nullify player in returned team data
    $rostersize -= 1;
    for ($j = $i; $j < $rostersize; $j++) {
      $rosterinfo['rows_affected'][$j] = $rosterinfo['rows_affected'][$j+1];
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
  "number of Players" =>$rostersize,
  "Players" => $rosterinfo['rows_affected']
);

echo '<pre style="margin-left: 200px;">' .json_encode($jsonData, JSON_PRETTY_PRINT) . '</pre>';
header('Content-disposition: attachment; filename=TeamInfo.json');
header('Content-type: application/json');
echo $jsonData;
//echo '<pre style="margin-left: 200px;">' . json_encode($jsonData1, JSON_PRETTY_PRINT) . '</pre>';
//$jsonData=json_encode(array('data'=>$jsonData));

//$fp = fopen('result.json', 'w');
//fwrite($fp, json_encode($jsonData));
//fclose($fp);

?>
