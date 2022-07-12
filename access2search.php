<?php date_default_timezone_set("Asia/Bangkok");?>
<html>
<head>
    <meta http-equiv="Content-Type" charset="UTF-8">
    <meta name="viewport" content="text/html, width=device-width, initial-scale=1.0">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/dist/css/animate.min.css">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="jquery/sweetalert2.all.min.js"></script>
    <title>Search</title>
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
            court_text();

            let myVar = setTimeout(function(){ window.open("/access2search", "_self") }, 600000);
            window.addEventListener("click", function(){
            clearTimeout(myVar);
            myVar = setTimeout(function(){ window.open("/access2search", "_self") }, 600000);;
        });


            var link_web = decodeURIComponent(window.location.href);
            var url_check =link_web.replace("http://","");
            // alert(url_check);
            if (url_check.includes("10.37.76.250")){
                caselink = link_web.replace("http://10.37.76.250:9090/access2search/access2search.php","");
            } else{
                caselink = link_web.replace("http://web.smkc.com:9090/access2search/access2search.php","");
            }
            // caselink = link_web.replace("http://10.37.76.250:9090/access2search/access2search.php","");
            if ( caselink != '' ){
                $("#caseT").val(caselink.substr(1));
                search_case(1);
            }
            
            $("#caseT").keypress(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault(); 
                    $("#caseBBtn").click();
                    } });

            $("#caseBBtn").click(function(){
                search_case(1);  });
            $("#caseRBtn").click(function(){
                search_case(2);  });
                
            $("#caseCBtn").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                $("#obt1").val($("#caseT").val())
                search_detailcase(8);
                $("#myModal").modal();  });

             $("#caseFBtn").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                $("#obt1").val($("#caseT").val())
                search_detailcase(9);
                $("#myModal").modal();  });

            $("#obBtn1").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(1);
                $("#myModal").modal();  });
            $("#obBtn2").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(2);
                $("#myModal").modal();  });
            $("#obBtn3").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(3);
                $("#myModal").modal();  });
            $("#obBtn4").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(4);
                $("#myModal").modal();  });
            $("#obBtn5").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(5);
                $("#myModal").modal();  });
            $("#obBtn6").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(6);
                $("#myModal").modal();  });
            $("#obBtn7").click(function(){
                $('#obt18').empty().html(); $('#obt19').empty().html();
                search_detailcase(7);
                $("#myModal").modal();  });

            $("#caseDBtn").click(function(){
                window.open("/access2search","_self");  });
            $("#caseBBte").click(function(){
                window.open("/access2search/access2searchmuti.php","_self");  });


            $("#info-text").click(function(){
                Swal.fire({ title: "รูปแบบการค้นหา (TIP)",
                html: 'คดีก่อนปี 62 : ต้องมีจุดหลังอักษรย่อ เช่น พ . 1 / 61 <br>คดีตั้งแต่ปี 62 : ต้องไม่มีจุดหลังอักษรย่อ เช่น ผบ 1 / 62 <br>คดีแดง E-filing <br> มีรูปแบบปีจำนวน 2 หลัก เช่น ผบE 99 / 64 <br> คดีดำ E-filing เท่านั้น <br> มีรูปแบบปีจำนวน 4 หลัก เช่น ผบE 10 / 2564 ' ,
                });}); 
            });
</script>
</head>
<body>
<div class="container">
<div class="row">
    <div class="col-12">
    <form name = "form1" id="form1">
    <table style="height: 100%; width: 100%">
                <tbody>
                    <tr>
                    <td class="text-warning bg-dark text-center">
                    <p style="font-size:20px;" name="courtN" id="courtN"></p>
                    <p style="font-size:25px;">
                    <input style="width: 60%" type="text" name="caseT" id="caseT" autofocus> <i id="info-text" class="fa-solid fa-circle-info fa-1x animate__animated animate__heartBeat animate__infinite"></i></p>
                    <p style="font-size:20px;">
                    <input type="button" name="caseDBtn" id="caseDBtn" value="   หน้าแรก   ">
                    <input class="btn-success" type="button" name="caseBBtn" id="caseBBtn" value=" ค้นหาเลขคดีดำ ">
                    <input class="btn-danger" type="button" name="caseRBtn" id="caseRBtn" value="    ค้นหาเลขคดีแดง   ">
                    <input class="btn-warning" type="button" name="caseCBtn" id="caseCBtn" value="ค้นหาเลขผัดฟ้อง/ฝากขัง">
                    <input class="btn-info" type="button" name="caseFBtn" id="caseFBtn" value="ค้นหาเลขฟื้นฟู">
                    <input type="button" name="caseBBte" id="caseBBte" value=" ค้นหาชื่อหรือข้อมูลคดี "></p>
                    <p style="font-size:15px;">|| รูปแบบหมายเลขคดีก่อนปี 62 : อ.1/61 || รูปแบบหมายเลขคดีตั้งแต่ปี 62 : อ1/62 || รูปแบบหมายเลขคดี e-Filing : ผบE1/2563 || </p>
                  
                    
                    </td>
                    </tr></tbody></table></form>
    </div></div></div>

                <div class="container">
                <div class="row">
                <div class="col-6">
                <form name = "form2" id="form2" method="post">
                <table style="height: 100%; width: 100%"><tbody>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> หมายเลขคดีดำ </p>
                                <input type="text" style="font-size:16px;" id="obt1" name="obt1"  value=""></td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> หมายเลขคดีแดง </p>
                                <input type="text" style="font-size:16px; color:red;" id="obt2" name="obt2"  value="">  
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> วันรับฟ้อง </p>
                                <input type="text" style="font-size:16px;" id="obt3" name="obt3"  value=""> </td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> วันตัดสิน </p>
                                <input type="text" style="font-size:16px; color:red;" id="obt4" name="obt4"  value="">
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> ประเภทคดี </p>
                                <input type="text" style="font-size:16px;" id="obt5" name="obt5"  value=""> </td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> ผู้พิพากษารับฟ้อง </p>
                                <input type="text" style="font-size:16px;" id="obt6" name="obt6"  value="">
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> ข้อหา </p>
                                <textarea style="font-size:16px;" id="obt7" name="obt7" rows="1"> </textarea></td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> ทุนทรัพย์ </p>
                                <input type="text" style="font-size:16px;" id="obt8" name="obt8"  value="">
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> เจ้าของสำนวน </p>
                                <input type="text" style="font-size:16px;" id="obt9" name="obt9"  value=""> </td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> องค์คณะ </p>
                                <input type="text" style="font-size:16px;" id="obt10" name="obt10"  value="">
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:16px;"> ผู้พิพากษาตัดสิน </p>
                                <input type="text" style="font-size:16px;" id="obt11" name="obt11"  value=""> </td>
                                <td class="text-right"> 
                                <p style="font-size:16px;"> วันครบอุทธรณ์ </p>
                                <input type="text" style="font-size:16px; color:red;" id="obt12" name="obt12"  value="">
                                </td></tr>
                            </tbody></table></form>
                </div>
                <div class="col-6">
                <form name = "form3" id="form3" method="post">
                <table style="height: 100%; width: 100%"><tbody>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> โจทก์ / ผู้ร้อง </p>  
                                <textarea id="obt13" name="obt13" rows="2" cols="45">
                                </textarea> 
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> คู่ความ / จำเลย </p> 
                                <textarea id="obt14" name="obt14" rows="3" cols="45">
                                </textarea>
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> สารบบคำพิพากษา </p> 
                                <textarea style="color:red;" id="obt15" name="obt15" rows="4" cols="45">
                                </textarea> 
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> ผู้ปฏิบัติงาน
                                <input type="text" id="obt16" name="obt16"  value=""> </p>  
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> วันที่ปฏิบัติงาน
                                <input type="text" id="obt17" name="obt17"  value=""> </p>  
                                </td></tr>
                                <tr><td class="text-right"> 
                                <p style="font-size:14px;"> คดีผัดฟ้อง/ฝากขัง
                                <input type="text" id="obt17-2" name="obt17-2"  value=""> </p>  
                                </td></tr>
                            </tbody></table></form>
                </div>
                <div class="col-12">
                <form name = "form4" id="form4" method="post">
                <table style="height: 100%; width: 100%"><tbody>
                                <tr><td class="bg-dark text-center">
                                <input class="btn-outline-dark" type="button" name="obBtn1" id="obBtn1" value="   วันนัดพิจารณา   "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn2" id="obBtn2" value="  ผลการส่งหมาย  "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn3" id="obBtn3" value="  สารบบ  "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn4" id="obBtn4" value="  ระบบติดตามสำนวน  "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn5" id="obBtn5" value="   คำสั่งศาล  "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn6" id="obBtn6" value="  ข้อมูลอุทธรณ์  "  style="font-size:15px;" >
                                <input class="btn-outline-dark" type="button" name="obBtn7" id="obBtn7" value="  ข้อมูลฎีกา  "  style="font-size:15px;" >
                                </td></tr>
                            </tbody></table></form>
                </div>
                </div>

                <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog  modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-danger"><p name="obt19" id="obt19">ไม่พบรายละเอียดข้อมูลคดี</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    <div class="modal-body">
                    <table class="table table-bordered table-sm" name="obt18" id="obt18"></table>
                    </div>
                </div>
                </div>
            </div>
               
</div>
</body>
</html>