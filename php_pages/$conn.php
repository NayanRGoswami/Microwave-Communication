<?php
//$conn = mysqli_connect("localhost","haiyun","1234","microwave_info");

// Check connection
// if (mysqli_connect_errno())
//   {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   }

//........................................
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $conn =new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');
  $conn->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
  exit('Error connecting to database'); //Should be a message a typical user could understand
}
?>