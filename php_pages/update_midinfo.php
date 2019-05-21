<?php include '$conn.php';
$dataID=$_POST['dataID'];
$groundheight = $_POST['ground_height'];
$terrain_type = $_POST['terrain_type'];
$obstruction_height = $_POST['obstruction_height'];
$obstruction_type = $_POST['obstruction_type'];



if(empty(trim($groundheight))){

    echo "Ground height is empty!";
    exit;
}elseif(!is_numeric($groundheight)){
    echo "GroundHeight is not valid!";
    exit;
}

if(empty(trim($terrain_type))){

    echo "Terrain type is empty!";
    exit;
}elseif(!is_string($groundheight)){
    echo "Terrain type is not valid!";
    exit;
}
if(empty(trim($obstruction_height))){

    echo "Obstruction Height is empty!";
    exit;
}elseif(!is_numeric($groundheight)){
    echo "Obstruction Height is not valid!";
    exit;
}
if(empty(trim($obstruction_type))){

    echo "Obstruction Type is empty!";
    exit;
}elseif(!is_string($groundheight)){
    echo "Obstruction Type is not valid!";
    exit;
}
$sql = "UPDATE main_data_info SET ground_height = '$groundheight',terrain_type = '$terrain_type',obstruction_height = '$obstruction_height',obstruction_type = '$obstruction_type' WHERE dataID = $dataID";

if ($conn->query($sql) === TRUE) {

    $sql2 = "SELECT fileID FROM main_data_info WHERE dataID = $dataID";

    $result = $conn->query($sql2);
    $row = $result->fetch_assoc();

    echo $row["fileID"];

} else {
    echo "failed to save data!";
}
    

$conn->close();
?>