<?php
include '$conn.php';

$pathID= $_POST["pathid"];
$curv=$_POST['curv'];

$arr=[];
$array=[];
$cur_arr=['4/3'=>17, '1'=>12.75, '2/3'=>8.5, 'zero'=>0];

if(empty(trim($pathID))){
    $array=['err'=>"No path selected!"];
    echo json_encode($array);
    exit;
}
if(empty(trim($curv))){
    $array=['err'=>"No curvature selected!"];
    echo json_encode($array);
    exit;
}

// Path Info
$sql = "SELECT * FROM path_info WHERE pathID = '$pathID'";

$result = $conn->query($sql);

$rowPathData = mysqli_fetch_array($result);


// begin point info

$sql = "SELECT * FROM begin_point_info WHERE fileID = '$pathID'";

$result = $conn->query($sql);

$rowBeginData = mysqli_fetch_array($result);

// end point info

$sql = "SELECT * FROM end_point_info WHERE fileID = '$pathID'";

$result = $conn->query($sql);

$rowEndData = mysqli_fetch_array($result);

//$data =json_encode($row);

//array_push($array, $row );

$qry = "SELECT pi.path_length, mdi.distance, mdi.ground_height, mdi.obstruction_height, mdi.terrain_type, mdi.obstruction_type, epi.point1 FROM path_info pi INNER JOIN main_data_info mdi ON pi.fileID = mdi.fileID INNER join end_point_info epi ON pi.fileID=epi.fileID WHERE pi.fileID =$pathID";

$result = $conn->query($qry);

$row = mysqli_fetch_all($result,MYSQLI_ASSOC);

foreach($row as $v){

    $d1 = $v['distance'];
    $D = $v['point1'];
    $d2 =$D - $d1;

    if($curv=='zero'){
        $h =0;
    }else{
        $h=$d1 * $d2 / $cur_arr[$curv];
    }
    //$h = 0;// $d1 * $d2 / $cur_arr[$curv]; //curvature height;
    $divBy=$v['path_length']*$D;
    $f1 = 17.3*sqrt($d1*$d2/$divBy);
    $grdHeight =$v['ground_height'];
    $obsHeight =$v['obstruction_height'];
    $apt_grd_obs_height=$grdHeight+$obsHeight+$h;
    $ttl_clr_height =$apt_grd_obs_height+$f1;
    
    $PA=92.4+20*log10($f1)+20*log10($v['path_length']);
  
    $arr["d1"] = number_format($v['distance'],4);
    $arr["h"] = number_format($h,4);
    $arr["apt"] = number_format($apt_grd_obs_height,4);
    $arr["f1"] = number_format($f1,4);
    $arr["clr"] = number_format($ttl_clr_height,4);
    $arr["tr_tp"]=$v['terrain_type'];
    $arr["obs_tp"]=$v['obstruction_type'];
    $arr["obs_ht"]=number_format($v['obstruction_height'],4);
    $arr["grd_ht"]=number_format($v['ground_height'],4);
    $arr["pa"]=number_format($PA,4); 
    
    $arr["path_data"]=$rowPathData; 
    $arr["begin_data"]=$rowBeginData;
    $arr["end_data"]=$rowEndData; 

    
    
   


    
    array_push($array, $arr);
    

}


echo json_encode($array);

?>