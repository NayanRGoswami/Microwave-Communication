$("#sel").change(function(){
    contentType:'application/json; charset=utf-8'
   // var sPath = $(this).children("option:selected").val();
    //alert(sPath);
    var data = $(this).serializeArray();
    $.post("php_pages/data.php",data,onSelect);
});

function onSelect(resp){
      // console.log(resp);
    var res = resp.posts;
    var response = resp.posts.length;
    if(response > 0){

        $("#path_info").html("<h3>Path Info</h3><table id = 'path' border = 1><tr><th>path_name</th><th>path_length</th><th>description</th><th>note</th><th>Edit</th></tr>");
        $("#points_info").html("<h3>End Point Info</h3><table id = 'points' border = 1><tr><th>Distance</th><th>Ground Height</th><th>Antenna Height</th><th>Edit</th></tr>");
        $("#mid_info").html("<h3>Main Data Info</h3><table id = 'mid' border = 1><tr><th>Distance</th><th>Gound Height</th><th>Terrain Type</th><th>Obstruction Height</th><th>Obstruction Type</th><th>Edit</th></tr>");

        ////////
               $("#path").append("<tr><td>"+res[0].path_name+"</td><td>"+res[0].path_length +"</td><td>"+res[0].descrip+"</td><td>"+res[0].note+"</td><td> <button  id='btn_path' class='btn btn-success' style= 'margin:5px;' data-toggle='modal' data-target='#edit_path' onclick='sendPathId("+res[0].pathID+")' >Edit</button></td></tr>");
               //////////

            $("#points").append("<tr><td>"+res[0].point1 +"</td><td>"+res[0].point2 +"</td><td>"+res[0].point3+"</td><td> <button  id='btn_end' class='btn btn-success' data-toggle='modal' style= 'margin:5px;' data-target='#edit_end' onclick='sendID("+res[0].pointID+")' >Edit</button></td></tr>");
    };

    var len=res.length;

    for(var i = 0; i < len; i++){
        $("#mid").append("<tr><td>"+res[i].distance+"</td><td>"+res[i].ground_height+"</td><td>"+res[i].terrain_type+"</td><td>"+res[i].obstruction_height+"</td><td>"+res[i].obstruction_type+"</td><td> <button  id='btn_mid' class='btn btn-success' data-toggle='modal' style= 'margin:5px;' data-target='#edit_mid' onclick='send_mid_id("+res[i].dataID+")'>Edit</button></td></tr>");
    }

};

function send_mid_id(mid_id){
    $.ajax({
        type: "POST",
        url: "php_pages/fetch_pathInfo.php",
        data: {
            dataID: mid_id
        },
        success: function (mid_data) {
            var res =JSON.parse(mid_data);
            
             $('#dataID').val(res.dataID);
             $("#distance").val(res.distance);
             $("#ground_height").val(res.ground_height);
             $("#terrain_type").val(res.terrain_type);
             $("#obstruction_height").val(res.obstruction_height);
            $("#obstruction_type").val(res.obstruction_type);
        },
        error: function () {
         alert('Error');
        }
    });

}

function sendPathId(id){
    $.ajax({
                type: "POST",
                url: "php_pages/fetch_pathInfo.php",
                data: {
                    fileID: id
                },
                success: function (data) {
                    var res =JSON.parse(data);
            
                    $("#pathId").val(res.pathID);
                    $("#pathName").val(res.path_name);
                    $("#pathLength").val(res.path_length);
                    $("#description").val(res.descrip);
                    $("#note").val(res.note);
                },
                error: function () {
                 alert('Error');
                }
            });
    }

function sendID(id){
$.ajax({
            type: "POST",
            url: "php_pages/fetch_end_tbl.php",
            data: {
                fileID: id
            },
            success: function (data) {
                
                var res =JSON.parse(data);

               $("#end_fileID").val(res.fileID);
               $("#end_distance").val(res.point1);
               $("#end_grd_ht").val(res.point2);
               $("#end_atn_ht").val(res.point3);

            },
            error: function () {
             alert('Error');
            }
        });
}

$("#btn_sbmt").click(function(e){
    
    e.preventDefault();
    $.ajax({
        url: 'php_pages/update_end_tbl.php',
        type: 'post',
        data: $('#frm_end').serialize(),
        success: function(data) {

            var res= parseInt(data);
            if(!isNaN(res)){
                
                $("#err").css('color', 'green')
                         .html('data saved successfully!');

                setTimeout(function() {
                    $('#edit_end').modal('toggle');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }, 1000);

                $("#sel").val(res).change();

                $('#edit_end').on('hidden.bs.modal', function () {
                  $("#err").html('');
                });
            }else{
                $("#err").css('color', 'red')
                      .html(data);
                $('#edit_end').on('hidden.bs.modal', function () {
                    $("#err").html('');
                });
            }

        }
    });
    
})

$("#path_submit").click(function(e){

    e.preventDefault();

      var data = $('#pathForm').serializeArray();

    $.post("php_pages/update_pathInfo.php",data,function(data){

        var res= parseInt(data);
          
            if(!isNaN(res)){
                
                $("#err2").css('color', 'green')
                         .html('data saved successfully!');

                setTimeout(function() {
                    $('#edit_path').modal('toggle');
                }, 1000);

                $("#sel").val(res).change();

                $('#edit_path').on('hidden.bs.modal', function () {
                  $("#err2").html('');
                });
            }else{
                $("#err2").css('color', 'red')
                      .html(data);
                $('#edit_path').on('hidden.bs.modal', function () {
                    $("#err2").html('');
                });
            }

            
    });

})

$("#mid_submit").click(function(e){

    e.preventDefault();

      var data = $('#mid-form').serializeArray();

    $.post("php_pages/update_midinfo.php",data,function(data){
        var res= parseInt(data);

        console.log(res);

        if(!isNaN(res)){
            
            $("#err3").css('color', 'green')
                     .html('data saved successfully!');

            setTimeout(function() {
                $('#edit_mid').modal('toggle');
            }, 1000);

            $("#sel").val(res).change();

            $('#edit_mid').on('hidden.bs.modal', function () {
              $("#err3").html('');
            });
        }else{
            $("#err3").css('color', 'red')
                  .html(data);
            $('#edit_mid').on('hidden.bs.modal', function () {
                $("#err3").html('');
            });
        }
            
    });

})

// modified for reset functionality on 12/03/2019

$("#btnResetDB").click( function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    resetPathData(e);
})


function resetPathData(e) {

    e.preventDefault();
    //give confirmation first, if yes then call this method.
      var selectedPath = $('#sel').find(":selected").val();    
      
    if (selectedPath =='' ){ alert('No Path selected for reset!'); return false;}
     
    var conf = confirm('Are you sure want to reset this Path? <br> This will permanently delete all records and reupload the selected path file');
    if (conf) {  
        $.ajax({
            type: "get",            
            url: "./php_pages/resetpath.php",
            data: {
                path_name: selectedPath
            },
            success: function (resetInfo) {
                //alert( resetInfo.data);
                console.log(resetInfo);
                alert("Path data is successfuly reseted");

               document.location.reload();

               // $("#sel").val(resetInfo.data+1).change();
               
            },
            error: function (resetInfo) {
                alert('reset Failed');
            }
        });
    } else {
        alert("User Cancelled the Reset!");
    } 
}



 $("#tbl_end tr td").css('text-align','left')
$("#tbl_end tr td:first-child").width(140).css('background-color','white');
$('input[type=number]').width(70);
$("#tbl_end tr td:nth-child(2)").width(80).css('text-align','center');
$("#tbl_end tr td:nth-child(3)").css('background-color','white');
$(".modal-body").offset({ top: 10, left: 70 });
$("#err").offset({ top: 0, left: 90 });
$('th').attr("align","right");

// $("#pathTable tr td").css('text-align','left');
// $("#pathTable tr td:first-child").width(140).css('background-color','white');
// $('input[type=number]').width(70);
// $("#pathTable tr td:nth-child(2)").width(80).css('text-align','center');
// $("#pathTable tr td:nth-child(3)").css('background-color','white');
// $("#err2").offset({ top: 0, left: 90 });



$.get("php_pages/data.php",onSelect);


$("#sel_curvature").change(function(){
    
})
