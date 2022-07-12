<?php date_default_timezone_set("Asia/Bangkok");?>
<html>
<head>
    <meta http-equiv="Content-Type" charset="UTF-8">
    <meta name="viewport" content="text/html, width=device-width, initial-scale=1.0">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/dist/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/dist/css/animate.min.css">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="bootstrap/dist/js/jquery.dataTables.min.js"></script>
    <script src="jquery/sweetalert2.all.min.js"></script>


    <title>Document</title>
    <style> 
			  @font-face {
			  font-family: 'Kanit-Regular';
			  src:url(bootstrap/dist/font/Kanit-Regular/Kanit-Regular.eot) format('embedded-opentype');
			  font-weight: normal;
			  font-style: normal;
						}

			  @font-face {
			  font-family: 'Kanit-Regular';
			  src:  url(bootstrap/dist/font/Kanit-Regular/Kanit-Regular.woff) format('woff'), 
				    url(bootstrap/dist/font/Kanit-Regular/Kanit-Regular.ttf)  format('truetype'), 
				    url(bootstrap/dist/font/Kanit-Regular/Kanit-Regular.svg#Kanit-Regular) format('svg');
			  font-weight: normal;
			  font-style: normal;
						}
			body {font-family: 'Kanit-Regular' !important;} 
          
</style>

<script type="text/javascript" src="court_obj.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        let myVar = setTimeout(function(){ window.open("/access2search", "_self") }, 600000);
        window.addEventListener("click", function(){
            clearTimeout(myVar);
            myVar = setTimeout(function(){ window.open("/access2search", "_self") }, 600000);;
        });

      

     

            court_text();

            $('#obttext').DataTable ({
            bSort: false,
            bFilter: false,
            aoColumns: [ { bSearchable: false, bSortable: false } ],
                "scrollCollapse": false,
                "searchable": false,
                "info":           false,
                "paging":         false  });

                // Swal.fire({ title: "คลิกที่เลขคดีดำเพื่อดูข้อมูล", icon: "info", showConfirmButton: false, });
            

    $("#caseT").keypress(function(event) {
            if (event.keyCode == 13) {
            event.preventDefault(); 
            textsearch(2);
            } });


        $("#case1Btn").click(function(){
            textsearch(1);  });
        $("#case2Btn").click(function(){
            textsearch(2);  });
        $("#case3Btn").click(function(){
            textsearch(3);  });
        $("#case4Btn").click(function(){
            textsearch(4);  });
        $("#case5Btn").click(function(){
            textsearch(5);  });
        $("#case6Btn").click(function(){
            window.open("/access2search/access2search.php", "_self"); });
  
    $("#caseDBtn").click(function(){
        window.open("/access2search","_self");  });

        $("#info-text").click(function(){
            Swal.fire({ title: "รูปแบบการค้นหา (TIP)",
            html: 'ชื่อและนามสกุล : ให้พิมพ์ชื่อเว้นวรรค2ครั้งนามสกุล<br>ไม่ต้องใส่คำนำหน้าในการค้นหา<br>13หลัก : ให้พิมพ์เลขอย่างเดียวโดยไม่มีเครื่องหมาย<br><br>เมื่อพบข้อมูลคลิกที่เลขดำหรือดูเพิ่มเติม<br><br>หลังจากค้นหาแล้วพบข้อมูลสามารถพิมพ์ข้อความในช่อง search เพื่อกรองข้อมูลอีกครั้งได้' ,
        });}); 

    });
</script>
</head><body>
<div class="container">
<div class="row no-gutters">
    <div class="col-12">
    <form name = "form1" id="form1">
    <table style="height: 100%; width: 100%"><tbody><tr>
            <td class="text-warning bg-dark text-center">
            <p style="font-size:20px;" name="courtN" id="courtN"></p>
            <p style="font-size:25px;">
            <input style="width: 60%" type="text" name="caseT" id="caseT" autofocus> <i id="info-text" class="fa-solid fa-circle-info fa-1x animate__animated animate__heartBeat animate__infinite "></i></p>
            <p style="font-size:18px;">
            <input type="button" name="caseDBtn" id="caseDBtn" value=" หน้าแรก ">
            <input type="button" name="case1Btn" id="case1Btn" value="ชื่อ-สกุล โจทก์">
            <input type="button" name="case2Btn" id="case2Btn" value="ชื่อ-สกุล จำเลย,คู่ความ">
            <input type="button" name="case3Btn" id="case3Btn" value="เลขประจำตัวประชาชน">
            <input type="button" name="case4Btn" id="case4Btn" value="วันนัดพิจารณา">
            <input type="button" name="case5Btn" id="case5Btn" value="ข้อหา">
            <input type="button" name="case6Btn" id="case6Btn" value="ค้นหาเลขคดี">
            </p>
            <p style="font-size:15px;">รูปแบบ || วันนัดพิจารณา : 01/12/2563 || การค้นหา ชื่อ หรือ ข้อหา ให้พิมพ์ข้อความบางส่วน เช่น พิมพ์เพียงชื่อ หรือ นามสกุล หรือข้อหาบางส่วน ||</p>
            </td></tr></tbody></table></form>
</div></div></div>

    
<div class="container">
<div class="row">
<div class="col-12 text-center" >

<table class="table table-bordered table-sm" name="obttext" id="obttext"></table></div>
<span id='ct4' style="background-color:#FFFF00"></span>

</div></div>            
</body></html> 