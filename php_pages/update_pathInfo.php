<?php
include '$conn.php';

$pathID = $_POST['pathId'];
$path_length = $_POST['pathLength'];
$path_descrip = $_POST['description'];
$note = $_POST['note'];

if(empty(trim($pathID))){

    echo "end path id is empty!";
    exit;
}

if(empty(trim($path_length))){

    echo "Path length is empty!";
    exit;
}elseif(!is_numeric($path_length)){
    echo "Path length is not numeric!";
    exit;
}elseif(strlen(trim($path_length)) > 5){
    echo "Path length is more than 4.9!";
    exit;
}

if(empty(trim($path_descrip))){

    echo "Description is empty!";
    exit;
}elseif(!is_string($path_descrip))
{
    echo "Description is not valid!";
}elseif(strlen(trim($path_descrip)) > 255){
    echo "Path length is more than 255!";
    exit;
}

if(empty(trim($note))){

    echo "note is empty!";
    exit;
}elseif(!is_string($note)){
    echo "note is not valid!";
    exit;
}


$sql = "UPDATE path_info SET path_length = '$path_length',descrip = '$path_descrip',note = '$note' WHERE pathID = $pathID";


if ($conn->query($sql) === TRUE) {
    echo $pathID;
} else {
    echo "failed to save data";
}
    

$conn->close();




?>
