<?php
if(isset($_POST['fileID'])){
    $fileID=$_POST['fileID'];
}



// Create connection
$conn = new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');

// // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM end_point_info WHERE fileID = '$fileID'";

$result = $conn->query($sql);

$row = mysqli_fetch_array($result);

$data =json_encode($row);

echo $data;

//........................

// $arr = [];
// $stmt = $conn->prepare("SELECT * FROM end_point_info WHERE fileID = ?");
// $stmt->bind_param("i", $fileID);
// $stmt->execute();
// $result = $stmt->get_result();
// while($row = $result->fetch_assoc()) {
//   $arr[] = $row;
// }
// if(!$arr) exit('No rows');

// $data =json_encode($arr);

// echo $data;
// $stmt->close();
?>
