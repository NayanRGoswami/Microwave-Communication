<?php
   //echo $_POST['sel'];
 header("Content-Type: application/json");
  //$id = $_POST['sel'];

  $posts = [];

  $db = new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');

  if ($db->connect_errno) {
            $posts['cust_error'] = "Could not connect to database server";
            $posts['err_def'] = $db_conn->connect_errno; 
            $posts['err_query'] =  $db_conn->connect_error;
            echo "connection error";
            exit;                        
    }
    

  $query1 = "SELECT * FROM path_info t1 inner join end_point_info t2 on t1.fileID = t2.fileID
  inner join main_data_info t3 on t1.fileID = t3.fileID where t1.fileID ='".$_POST['sel']."';";
   // inner join begin_point_info t4 on t1.fileID = t4.fileID 
  if($db->query($query1) == true){
      
  $rs = $db->query($query1); 
      if($rs->num_rows > 0){


           $posts['posts'] = array();
         
         while($row = $rs->fetch_assoc()){
             array_push($posts['posts'],$row);
         }

          $post_data = json_encode($posts);
          echo $post_data;
      };
      
  }else{
      echo "Connection error";
      exit;
  }                                     
                                                     
?>