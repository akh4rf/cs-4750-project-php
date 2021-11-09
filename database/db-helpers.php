<?php

include 'db-connect.php';

function bindAllParams($stmt, $params) {
  for ($i = 0; $i < count($params); $i++) {
    $stmt->bindValue($i + 1, $params[$i]);
  }
}

function execute_query($sql, $params=null) {
  global $db;
  $stmt = $db->prepare($sql);
  if ($params) { bindAllParams($stmt, $params); }

  $success = $stmt->execute();
  $returnArr = array("was_successful" => $success,
                      "error_info" => $stmt->errorInfo(),
                      "row_count" => $stmt->rowCount(),
                      "rows_affected" => $stmt->fetchAll());
  $stmt->closeCursor();
  return $returnArr;
}

?>
