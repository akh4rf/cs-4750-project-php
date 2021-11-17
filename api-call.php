<?php

include('./database/db-connect.php');

$leagues = array(
  "English Non League Premier" => 149,
  "Ghana Premier League" => 177,
  //"La Liga" => 302,
  //"Premier League" => 152,
  //"Ligue 1" => 168,
  //"Serie A" => 207,
  //"Bundesliga" => 56
);

$domain = 'https://apiv3.apifootball.com/';
$validation = '&APIkey=1dd0be1c597e39f9630ab480edd54f5467f72d4930283d14181d79ba64b1ca1b';
// $url = $domain . '?action=get_statistics&match_id=505156' . $validation;

function curl_get($url) {
  $curl_options = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
      "Accept: application/json",
    ),
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CONNECTTIMEOUT => 5
  );
  $curl = curl_init();
  curl_setopt_array($curl, $curl_options);
  $result = curl_exec($curl);
  curl_close($curl);
  return json_decode($result, true);
}

function get_matches_from_range($league, $d1, $d2) {
  global $domain, $validation;
  $url = $domain . '?action=get_events';
  $url .= '&from='. $d1 . '&to=' . $d2 . /*'&league_id=' . $league . */$validation;
  return curl_get($url);
}

function get_matches_on_date($league, $date) {
  return get_matches_from_range($league, $date, $date);
}

function print_json($data) {
  echo '<pre>' . json_encode($data, JSON_PRETTY_PRINT) . '</pre>';
}

// print_json(get_matches_from_range(1, '2021-10-01', '2021-11-01'));

function get_match_ids_by_date_range($d1, $d2) {
  $match_data = get_matches_from_range(1, $d1, $d2);
  print_r($match_data);
  $match_arr = array();
  for ($i = 0; $i < count($match_data); $i++) {
    array_push($match_arr, $match_data[$i]['match_id']);
  }
  return $match_arr;
}

// get_match_ids_by_date_range('2021-10-01', '2021-11-01');

function get_league_teams($id) {
  global $domain, $validation;
  $url = $domain . '?action=get_teams';
  $url .= '&league_id=' . $id . $validation;
  return curl_get($url);
}

// ARCHIVED
/*
function fill_rlplayer_table() {
  // Get list of leagues
  global $leagues, $db;
  $i = 0;
  foreach ($leagues as $name => $id) {
    // Get list of teams in the league
    $team_data = get_league_teams($id);
    // Iterate through each team in the league
    for ($team_index = 0; $team_index < count($team_data); $team_index++) {
      $players = $team_data[$team_index]['players'];
      // Iterate through players in each team
      for ($player_index = 0; $player_index < count($players); $player_index++) {
        $player = $players[$player_index];
        $RLPID_API = $player['player_key'];
        $name = $player['player_name'];
        $picURL = $player['player_image'] ? $player['player_image'] : NULL;
        $age = intval($player['player_age']);
        $position = $player['player_type'];
        $i++;

        $sql = 'INSERT INTO `RLPlayer` VALUES (NULL, :RLPID_API, :name, :picURL, :age, :position, 0, 0, 0);';
        $statement = $db->prepare($sql);

        $statement->bindValue(':RLPID_API', $RLPID_API);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':picURL', $picURL);
        $statement->bindValue(':age', $age);
        $statement->bindValue(':position', $position);

        $result = $statement->execute();
        $error = $statement->errorInfo();
        // $success = ($statement->rowCount() > 0) ? 'successfully' : 'not';
        // echo '<p> Player ' . $i . ' ' . $success . ' inserted. Values: (' . $RLPID_API . ', ' . $name . ', ' . $picURL . ', ' . $age . ', ' . $position . '). Error: ' . $error[2] . '</p>';
        $statement->closeCursor();
      }
    }
  }
}

fill_rlplayer_table();
*/

$timestamp = date('Y-m-d H:i:s');

function get_game_ids_from_range($date1, $date2, $league_id) {
  global $domain, $validation;
  $url = $domain . '?action=get_events';
  $url .= '&from=' . $date1 . '&to=' . $date2 . '&league_id=' . $league_id;
  $url .= $validation;
  $data = curl_get($url);
  $game_ids = array();
  for ($i = 0; $i < count($data); $i++) {
    if (strlen($data[$i]['match_id']) > 0) {
      array_push($game_ids, $data[$i]['match_id']);
    }
  }
  return $game_ids;
}

function get_match_stats($match_id) {
  global $domain, $validation;
  $url = $domain . '?action=get_statistics&match_id=' . $match_id . $validation;
  echo $url;
  $data = curl_get($url);
  return $data;
}

function compute_teamstats($date1, $date2) {
  global $leagues;
  foreach ($leagues as $name => $id) {
    $game_ids = get_game_ids_from_range($date1, $date2, $id);
    for ($match = 0; $match < count($game_ids); $match++) {
      $match_stats = get_match_stats($game_ids[$match]);
      break;
    }
  }
}

compute_teamstats('2021-10-02', '2021-11-02');

?>
