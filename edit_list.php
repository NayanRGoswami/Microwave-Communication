
<html>
<head>
<link href="css/main.css" type="text/css" rel="stylesheet" >
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="edit_list.php">Path Details</a></li>
      <li><a href="curvature_data.php">Curvature Data</a></li>
    </ul>
  </div>
</nav>

<h1>Select A Path To Get Details</h1>

<script src ="js/jquery-3.3.1.js"></script>
      
      <?php
         $db = new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');
         $query = "select * from path_info;";
         
        if($db->query($query)==true){
           
         $rs = $db->query($query);
         if($rs->num_rows > 0){
             $rowm=mysqli_fetch_all($rs,MYSQLI_ASSOC);
             
            echo "</div><select id='sel' name = 'sel'>";
              echo "<option value = ''>Select a path</option>";
             foreach($rowm as $row){
                
                echo "<option value = ".$row['fileID'].">".$row['path_name']."</option>";
             }
           echo  "</select >";

           echo "&nbsp;<button id ='btnResetDB' name = 'btnResetDB'   >Reset Path</button>" ;
         }
        }else{
            echo $db->error;
        }

        
          
      ?>
      
       <div id = "path_info"></div> 
       <div id = "points_info"></div> 
       <div id = "mid_info"></div> 
       
       <script src="js/fetch_data_to_display.js"></script>
<?php

    include_once 'php_pages/edit_end_path.php';

?>
<div id = "footer"><p id = "des">Microwave Communication System</p></div>

</body>
</html>
