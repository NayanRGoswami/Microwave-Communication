<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Path Info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
</head>
<body>


<div class="container">

 
<div class="modal fade" id="edit_path" role="dialog">
   <div class="modal-dialog">

     
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Edit Path Information</h4>
       </div>

       <div class="modal-body">
         <form id ='pathForm' >
         <table id="pathTable" >
         <tr>
           <td><input id="pathId" name="pathId" type = "hidden" readonly></td>
           <td><span></span></td>
         </tr>
         <tr><td><label>Path Name</label></td>
             <td><input id="pathName" name="pathName" type="text" readonly></td>
             <td><span></span></td>
         </tr>

         <tr><td><label>Path Length</label></td>
           <td><input id="pathLength" name="pathLength" type="text" ></td>
           <td><span></span></td>
         </tr>

         <tr><td><label>Description</label></td>
           <td><input id="description" name="description" type="text"></td>
           <td><span></span></td>
         </tr>

         <tr><td><label>Note</label></td>
           <td><input id="note" name="note" type="textarea"  rows="4" cols="50"></td>
           <td><span></span></td>
         </tr>

         </table>
         </form>
         <div id="err2" style="color=red"></div>
       </div>
       <div class="modal-footer">
         <button type="button" id="path_submit" class="btn btn-default"  >Submit</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button>
       </div>
     </div>

   </div>
 </div>

  
 <div class="container">
  
  <!-- Modal -->
  <div class="modal fade" id="edit_end" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit End Path</h4>
        </div>
       
        <div class="modal-body">

          <form id ='frm_end' >
          <table id="tbl_end" >
          <tr>
            <td><label>Path ID</label></td>
            <td><input id="end_fileID" name="end_fileID" type="number" readonly></td>
            <td></td>
          </tr>

          <tr>
            <td><label>Distance</label></td>
            <td><input id="end_distance" name="end_distance" type="number" readonly></td>  
            <td></td>
          </tr>

          <tr>
            <td><label>Ground Height </label></td>
            <td><input id="end_grd_ht" name="end_grd_ht" type="number" ></td>
            <td></td>
          </tr>

          <tr>
            <td><label>Antenna Height</label></td>
            <td><input id="end_atn_ht" name="end_atn_ht" type="number"></td>
            <td></td>
          </tr>

          </table>
          </form>

          <div id="err" style="color=red"></div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_sbmt" class="btn btn-default" >Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="edit_mid" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Mid Path</h4>
        </div>
        <div class="modal-body">
          <form id = "mid-form">
          
            <input id = "dataID" name = "dataID" type="hidden"><span></span><br>

            <label>Mid Distance</label>
            <input id = "distance" name = "distance" readonly type="text"><span></span><br>

            <label>Mid Ground Height </label>
            <input id = "ground_height" name = "ground_height" type="text"><span></span><br>

            <label>Mid Obstruction Height</label>
            <input id = "obstruction_height" name = "obstruction_height" type="text"><span></span><br>

            <label>Mid Terrain Type</label>
            <input id = "terrain_type" name = "terrain_type" type="text"><span></span><br>

            <label>Mid Obstruction Type</label>
            <input id = "obstruction_type" name = "obstruction_type" type="text"><span></span><br>
          </form>
          <div id="err3" style="color=red"></div>
        </div>
        <div class="modal-footer">
          <button type="button" id = "mid_submit" class="btn btn-default">Submit</button>
          <button type="button" id = "mid_cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>

</div>
<script src="js/fetch_data_to_display.js"></script>
</body>
</html>
