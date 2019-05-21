<?php

header("Content-Type: application/json");



//echo "Hello";
$pathID = $_GET['path_name'];

//echo $pathID;

$pk  =0;
if($pathID != ""){
	//$pathQuery = "select fileID from path_info where path_name ='".$pathName."';";
	   
	$db = new mysqli('nayangoswami.com','nayangos_london','@Uttra4321','nayangos_microwave_info');

   /*   
      
  if (mysqli_connect_errno()){
     // echo "<p style = 'color:red;'>Error: could not connect to the database<br/>
     // Please try again later</p>";
  } 
*/
 



	//$path = $db->query($pathQuery)->fetch_row();
	$fileId = $pathID;
	$Success = false;
	if(isset($fileId) && $fileId > 0){
		$fileQuery = "select * from file_info where fileId=$fileId";
		$fileInfo = $db->query($fileQuery)->fetch_row();
		$fileName = $fileInfo[1];
		
	

		if(isset($fileName) && $fileName != ""){
			$upload_dir = '../uploads/';
			$filePath = $upload_dir.$fileName;
			//$path_upload = new Path_upload();

			$success = 0;
			//$db->begin_transaction();

			truncateTables($fileId, $db);
			
		
		


		  
			$pk = save_file_name($db,$fileName);
		  
			  if($pk == 0){
				$success = 1;
				//$db->rollback();
				//unlink($filePath);
				$json_data = array(
					"data" => "Pk error",
					"success" => true);
					echo json_encode($json_data);
				exit;
			  }

			saveFileDataToDatabase($filePath, $pk , $db, true);
		}else{
			$json_data = array(
				"error" => 'Not able to find respective file',
				"success" => $Success
			);
		}

	}else{
		$json_data = array(
			"error" => 'Not able to find respective file',
			"success" => $Success
		);
	}



	$json_data = array(
		"data" => $pk,
		"success" => true
	);

}else{
	$json_data = array(
		"data"            => array(),
		"success" => false
	);

}

echo json_encode($json_data);exit;
//print_r($pathsCollection->fetch_array());exit;

//var $path_folder;


	function save_file_name($db,$unique_name)
	{   
		$file_primary_id  =0;
		$query = "INSERT INTO file_info (file_name) VALUES ('".mysqli_real_escape_string($db,$unique_name)."');";

		if ($db->query($query) === TRUE) {
		//	$file_primary_id  = mysqli_insert_id($db);
		}
		$file_primary_id  = mysqli_insert_id($db);
		return $file_primary_id;

	}

	function saveLinetoDB($db , $pk ,$row, $data, $update)
	{
		$valid = 0;
		//echo $row;
		// save the header data
		if ($row==1) {

			//validate_PathInfo($data);

			//if($update){
				//$query = "update path_info set path_length=$data[1], descrip='".$db->real_escape_string($data[2])."', note='".$db->real_escape_string($data[3])."' where fileID=$pk";
			//}else{
				$query = "INSERT INTO path_info (fileID,path_name,path_length,descrip,note) 
        				  VALUES (" .$pk.", '".$db->real_escape_string($data[0])."',
                          ".$data[1].",'".$db->real_escape_string($data[2])."',
                          '".$db->real_escape_string($data[3])."');";
			


			//echo $query;exit;

			if ($db->query($query) !== TRUE) {
				$valid =1;
			}



		}
		else if ($row ==2 ) {

			// validate_begin_point_info($data);

			$query = "INSERT INTO begin_point_info (fileID,point1,point2,point3) 
        VALUES (" .$pk.", ".$data[0].",
         ".$data[1].",".$data[2]."
            );";





			if ($db->query($query) !== TRUE) {
				$valid =1;
			}

			//echo $query;
		}
		else if ($row ==3) {

			//  validate_end_point_info($data);

			$query = "INSERT INTO end_point_info (fileID,point1,point2,point3) 
        VALUES (" .$pk.", ".$data[0].",
         ".$data[1].",".$data[2]."
            );";





			if ($db->query($query) !== TRUE) {
				$valid =1;
			}
			// echo $query;
		}

		else if ($row > 3 ) {

			// validate_main_data_info($data);

			$query = "INSERT INTO main_data_info (fileID,distance,ground_height,terrain_type,obstruction_height,obstruction_type) 
        VALUES (" .$pk.", ".$data[0].",
         ".$data[1].",'".$db->real_escape_string($data[2])."',
            ".$data[3].",'".$db->real_escape_string($data[4])."');";


			if ($db->query($query) !== TRUE) {
				$valid =1;
			}

			//echo $query;

		}

		return $valid ;

	}

	function delete_wrong_file($db,$pk){

		$query = "DELETE  FROM file_info WHERE fileID = '".$pk."';";


		if ($db->query($query) !== TRUE) {

		}
	}

	function saveFileDataToDatabase($uploaded_csv, $pk, $db, $update=false){
		$row = 1;
		if (($handle = fopen($uploaded_csv, "r")) !== FALSE) {
			while (($csv_data = fgetcsv($handle, 1000, ",")) !== FALSE) {

				$error = "";

				$col_count= count($csv_data);


				$query = "DELETE  FROM file_info WHERE fileID = '".$pk."';";
				if($col_count == 4){

					$path_col1 = $csv_data[0];


					$query1 = "select path_name from path_info where path_name ='".$path_col1."';";

					$rs = $db->query($query1);

					if($rs->num_rows > 0 && $update == true){
						$success =1;
						$db->query($query);
					//	$db->rollback();
					//	unlink($uploaded_csv);
						$error = "Path and File already exists";
						$json['error'] = $error;
						echo json_encode($json);
						exit;
						//echo $val[0];
					}



					if (!is_string($csv_data[0])|| strlen($csv_data[0])>100 || !isset($csv_data[0]))
					{
						$error = "Wrong data type";
						$success = 1;
						//delete_wrong_file($db,$pk);
						if($update == true){
							$db->query($query);
						//	$db->rollback();
						//	unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if (!is_string($csv_data[1])|| strlen($csv_data[1])>100 || !isset($csv_data[0]))
					{
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
						//	unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if (!is_string($csv_data[2])|| strlen($csv_data[2])>100 || !isset($csv_data[0]))
					{
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
							//$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if (!is_string($csv_data[3])|| strlen($csv_data[3])>100) {
						$error = "Wrong data type";
						if($update == true){
							$db->query($query);
							//$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};

					$line1_array[] = $csv_data;

					$valid =  saveLinetoDB( $db ,$pk ,$row, $csv_data, $update);

					if($valid == 1){
						$success = 1;
					}

				}

				if($col_count == 3){

					if(!is_numeric($csv_data[0])) {

						$error = "Wrong data type";
						if($update == true){
							$db->query($query);
							//$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_numeric($csv_data[1])) {
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
						//	unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_numeric($csv_data[2])) {
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
						//	unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};

					$line2n3_array[] = $csv_data;


					$valid =  saveLinetoDB( $db ,$pk ,$row, $csv_data, $update);

					if($valid == 1){
						$success = 1;
					}
				}

				if($col_count == 5){

					if(!is_numeric($csv_data[0])){
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
						//	unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_numeric($csv_data[1])) {
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_string($csv_data[2]) || strlen($csv_data[2]) > 100){
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
							//$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_numeric($csv_data[3])) {
						$error = "Wrong data type";

						$success = 1;
						if($update == true){
							$db->query($query);
							//$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};
					if(!is_string($csv_data[4])) {
						$error = "Wrong data type";
						$success = 1;
						if($update == true){
							$db->query($query);
						//	$db->rollback();
							//unlink($uploaded_csv);
						}
						$json['error'] = $error;
						echo json_encode($json);
						exit;
					};

					$line4_array[] = $csv_data;
					$valid =  saveLinetoDB( $db ,$pk ,$row, $csv_data, $update);

					if($valid == 1){

						$success = 1;
					}
				}

				$row++;

			}
			 
			//if ($success ==0 )
			//{$db->commit();}
			fclose($handle);
		}
	}
 
	
	function truncateTables($fileId, $db){
		$deleteBeginPoints = "delete from begin_point_info where fileID=$fileId;";
		$db->query($deleteBeginPoints);
		$deleteEndPoints = "delete from end_point_info where fileID=$fileId;";
		$db->query($deleteEndPoints);
		$deleteMainPoints = "delete from main_data_info where fileID=$fileId;";
		$db->query($deleteMainPoints);

		$deletePathInfo = "delete from path_info where fileID=$fileId;";
		$db->query($deletePathInfo);

		$deleteFileInfo = "delete from file_info where fileID=$fileId;";
		$db->query($deleteFileInfo);

		return true;
	}


?>