/*
$("#sel").change(function(){
    var path = $("#sel").val();
    var cur =$("#sel_curvature").val();
    $("#curvature").html('');
    $.post("php_pages/curvature_cal.php",{'pathid':path, 'curv':cur},onSelect);
});

function onSelect(resp){

    var val = JSON.parse(resp);

    if(val.err){
         $("#curvature").html('<h4>'+val.err+'</h4>').css('color','red');
    }else{
        var len = val.length;

        var str;
        str+= "<table>";
        str+="<tr><th>Distance from Start End Point</th><th>Ground Height</th><th>Terrain Type</th><th>Obstruction Height</th><th>Obstruction Type</th><th>Curvature Height</th><th>Apparent and Obstruction Height</th><th>1st Freznel Zone</th><th>Total Clearance Height</th></tr>";

        for(i=0; i<len; i++){

            str+="<tr>";
            str+="<td>"+val[i].d1+"</td>";
            str+="<td>"+val[i].grd_ht+"</td>";
            str+="<td>"+val[i].tr_tp+"</td>";
            str+="<td>"+val[i].obs_ht+"</td>";
            str+="<td>"+val[i].obs_tp+"</td>";
            str+="<td>"+val[i].h+"</td>";
            str+="<td>"+val[i].apt+"</td>";
            str+="<td>"+val[i].f1+"</td>";
            str+="<td>"+val[i].clr+"</td>";
            str+="</tr>";

        }

        str+= "</table>";

       // $("#curvature").html(str);

       // DrawGraph();

      //  $('table th').css('border','solid 1px black');
      //  $('table td').css('border','solid 1px black');
    }
};

*/
$("#btnCal").click(function(){
    var path = $("#sel").val();
    var cur =$("#sel_curvature").val();
     $("#curvature").html('');
     $("#PA").html('');
     $("#path_info").html('');
     $("#end_point_info").html('');
     $("#plotly-div").html('');


     $.post("php_pages/curvature_cal.php",{'pathid':path, 'curv':cur},
     function(res){

        var val = JSON.parse(res);
        //console.log(val);
        if(val.err){
           $("#PA").html('<h4>'+val.err+'</h4>').css('color','red');
        }else{
            var len = val.length;           
            
            var pa = val[0].pa;

            
            
            $("#PA").html("<h3>Calculation Results </h3><br><p>Path Ateunation =  " + pa +" </p> ").css('color','black');
           // document.getElementById("PA").innerHTML ="<h3>Calculation Results </h3><br><b>Path Ateunation = </b> " + pa + "<br>";

            var path_data = val[0].path_data;   
            
            var strPathInfo ;
            strPathInfo= "<h3> Path Information </h3><table class='table' width ='80%'>";
            
            strPathInfo+="<tr> ";
            strPathInfo+="<th>Path Name</th>";
            strPathInfo+="<td>"+path_data[2]+"</td>";            
            strPathInfo+="</tr></thead>";

            strPathInfo+="<tr>";
            strPathInfo+="<th>Frequency</th>";
            strPathInfo+="<td>"+path_data[3]+"</td>";            
            strPathInfo+="</tr>";

            strPathInfo+="<tr>";
            strPathInfo+="<th>Description</th>";
            strPathInfo+="<td>"+path_data[4]+"</td>";            
            strPathInfo+="</tr>";

            strPathInfo+="<tr>";
            strPathInfo+="<th>Note</th>";
            strPathInfo+="<td>"+path_data[5]+"</td>";            
            strPathInfo+="</tr>";

            strPathInfo+= "</table>";

            $("#path_info").html(strPathInfo);
            //document.getElementById("path_info").innerHTML = strPathInfo;
            
            var begin_point_info = val[0].begin_data;
            var end_point_info = val[0].end_data;

              
            var strEnd;
            strEnd= "<h3> End Point Information </h3><table class='table' width ='80%'> <thead class='thead-dark'>";
            strEnd+="<tr><th>Distance from Start End Point</th><th>Ground Height</th><th>Antena Height</th></tr>";
            strEnd+="<tr></thead>";
            strEnd+="<td>"+begin_point_info[2]+"</td>";
            strEnd+="<td>"+begin_point_info[3]+"</td>";
            strEnd+="<td>"+begin_point_info[4]+"</td>";
            strEnd+="</tr>";
            strEnd+="<tr>";
            strEnd+="<td>"+end_point_info[2]+"</td>";
            strEnd+="<td>"+end_point_info[3]+"</td>";
            strEnd+="<td>"+end_point_info[4]+"</td>";
            strEnd+="</tr>";
            strEnd+= "</table>";
            
            $("#end_point_info").html(strEnd);
            //document.getElementById("end_point_info").innerHTML =strEnd;

            var str;
            str= "<h3> Mid Point Information </h3><table width ='80%' class='table'>";
            str+="<tr><th>Distance from Start End Point</th><th>Ground Height</th><th>Terrain Type</th><th>Obstruction Height</th><th>Obstruction Type</th><th>Curvature Height</th><th>Apparent and Obstruction Height</th><th>1st Freznel Zone</th><th>Total Clearance Height</th></tr>";
             
            // *****Added for Graph  . changes in 
            var xV = [];
            var xfrez =[];
            var groundWithObstr =[];
            
            var pathXData =[];
            var pathYData =[];

            pathXData =[begin_point_info[2],end_point_info[2]]   ;
            pathYData = [parseFloat(begin_point_info[3]) + parseFloat(begin_point_info[4]), parseFloat(end_point_info[3])+ parseFloat(end_point_info[4])] ;

           // console.log(pathXData);
           // console.log(pathYData);

            // *********End 
            for(i=0; i<len; i++){

                str+="<tr>";
                str+="<td>"+val[i].d1+"</td>";
                str+="<td>"+val[i].grd_ht+"</td>";
                str+="<td>"+val[i].tr_tp+"</td>";
                str+="<td>"+val[i].obs_ht+"</td>";
                str+="<td>"+val[i].obs_tp+"</td>";
                str+="<td>"+val[i].h+"</td>";
                str+="<td>"+val[i].apt+"</td>";
                str+="<td>"+val[i].f1+"</td>";
                str+="<td>"+val[i].clr+"</td>";
                str+="</tr>";
                // *****Added for Graph
               xV[i+1] =parseFloat(val[i].d1);
               xfrez[i+1] =parseFloat(val[i].clr);
               groundWithObstr[i+1] = parseFloat(val[i].apt)  ;
            }
             
             //********* */
            str+= "</table>";

            $("#curvature").html(str);

            $('table th').css('border','solid 1px black');
            $('table td').css('border','solid 1px black');

            //  ******************************** Graph 
           

              data = null;     
            trace1 = {
                x: xV, 
                y: xfrez, 
                line: {
                  color: 'red', 
                  shape: 'spline', 
                  width: 3
                }, 
                mode: 'lines', 
                name: '1st freznel', 
                type: 'scatter', 
                uid: '45c0a4'
              };
              trace2 = {
                x: xV, 
                y: groundWithObstr, 
                line: {
                  color: 'green', 
                  shape: 'spline', 
                  width: 3
                }, 
                mode: 'lines', 
                name: 'Ground + Obstruction', 
                type: 'scatter', 
                uid: 'fc8c63'
              };

              trace3 = {
                x: pathXData, 
                y: pathYData,
                line: {
                  color: 'blue', 
                  shape: 'spline', 
                  width: 3
                }, 
                mode: 'lines', 
                name: 'Path', 
                type: 'scatter', 
                uid: 'fc8c99'
              };
              data = [trace1, trace2,trace3];
              layout = {
                annotations: [
                  {
                    arrowcolor: 'rgba(68, 68, 68, 0)', 
                    ax: -246, 
                    ay: -164, 
                    font: {
                      color: 'rgb(129, 129, 126)', 
                      size: 14
                    }, 
                    text: '<b>' + $("#sel option:selected").text() + ':' + $("#sel_curvature option:selected").text() + '</b>'
                  }
                ], 
                autosize: true, 
                height: 350, 
                legend: {
                  x: -0.24796901053454015, 
                  y: 0.9713068181818182, 
                  bgcolor: 'rgba(242, 242, 242, 0)', 
                  traceorder: 'reversed'
                }, 
                margin: {
                  r: 80, 
                  t: 20, 
                  b: 20, 
                  l: 175
                }, 
                paper_bgcolor: 'rgb(242, 242, 242)', 
                plot_bgcolor: 'rgb(242, 242, 242)', 
                title: ' ', 
                width: 1000, 
                xaxis: xV  ,  /*{        autorange: true,  range: xV,  showgrid: true,  tickformat: '',  title: ' ', type: 'linear' }, */
                yaxis: {
                  autorange: false, 
                  gridcolor: 'rgb(208, 208, 208)', 
                  range: [0, 120], 
                  ticksuffix: '  ', 
                  title: ' ', 
                  type: 'linear'
                }
              };
              Plotly.newPlot('plotly-div', {
                data: data,
                layout: layout
              }); 
              
            /* Plotly.plot( 'plotly-div', [{
                x: xV,
                y: [1, 2, 4, 8, 16] }], {
                margin: { t: 0 } } ); */
        }
     })
  
});
//******************End of graph */
