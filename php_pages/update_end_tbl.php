<?php
include '$conn.php';

$fileID= $_POST['end_fileID'];
$end_distance= $_POST['end_distance'];
$end_grd_ht= $_POST['end_grd_ht'];
$end_atn_ht= $_POST['end_atn_ht'];

if(empty(trim($fileID))){

    echo "end point id is empty!";
    exit;
}

if(empty(trim($end_distance))){

    echo "distance is empty!";
    exit;
}elseif(strlen(trim($end_distance)) > 5){
    echo "point length is more than 5 characters!";
    exit;
}

if(empty(trim($end_grd_ht))){

    echo "ground height is empty!";
    exit;
}elseif(strlen(trim($end_grd_ht)) > 5){
    echo "point length is more than 5 characters!";
    exit;
}

if(empty(trim($end_atn_ht))){

    echo "antenna height is empty!";
    exit;
}elseif(strlen(trim($end_atn_ht)) > 5){
    echo "point length is more than 5 characters!";
    exit;
}

if(!is_numeric(trim($fileID))){

    echo "end point id should be a number!";
    exit;
}

if(!is_numeric(trim($end_distance))){

    echo "distance should be a number!";
    exit;
}

if(!is_numeric(trim($end_grd_ht))){

    echo "ground height should be a number!";
    exit;
}

if(!is_numeric(trim($end_atn_ht))){

    echo "antenna height should be a number!";
    exit;
}


$sql = "UPDATE end_point_info SET point2='$end_grd_ht',  point3 = '$end_atn_ht' WHERE pointID='$fileID'";

if ($conn->query($sql) === TRUE) {
    echo $fileID;
} else {
    echo "failed to save data";
}
    

$conn->close();


?>
