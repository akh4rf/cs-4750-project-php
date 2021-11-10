<?php
// Connecting to DB on XAMPP
$username = 'akh4rf';
$password = 'GingerDog2011';
$host = 'mysql01.cs.virginia.edu';
$dbname = 'upper90';


/******************************/
// [Spring 2021] connecting to DB on CS server
// $username = 'your-computingID';
// $password = 'your-password';
// $host = 'usersrv01.cs.virginia.edu';
// $dbname = 'your-computingID';
/******************************/

$dsn = "mysql:host=$host;dbname=$dbname";

/** connect to the database **/
try
{
   $db = new PDO($dsn, $username, $password);
}
catch (PDOException $e){
   $error_message = $e->getMessage();
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e){
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

?>
