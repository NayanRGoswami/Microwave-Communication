<?php




// Create connection
$conn =new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');

// // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(isset($_POST['fileID'])){
    $fileID=$_POST['fileID'];

$sql = "SELECT * FROM path_info WHERE fileID = '$fileID'";

$result = $conn->query($sql);

$row = mysqli_fetch_array($result);

$data =json_encode($row);

echo $data;
}
if(isset($_POST['dataID'])){
$mid_id=$_POST['dataID'];

$sql = "SELECT * FROM main_data_info WHERE dataID = '$mid_id'";

$result = $conn->query($sql);

$row = mysqli_fetch_array($result);

$mid_data =json_encode($row);

echo $mid_data;
}
?>