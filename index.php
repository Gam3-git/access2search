<?php date_default_timezone_set("Asia/Bangkok");?>
<html>
<head>
    <meta http-equiv="Content-Type" charset="UTF-8">
    <meta name="viewport" content="text/html, width=device-width, initial-scale=1.0">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="jquery/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
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
            .no-gutters { margin-right: 0; margin-left: 0; > .col,> [class*="col-"] {padding-right: 0;padding-left: 0;}}
</style>
<script type="text/javascript">
            $(document).ready(function(){
                $.getJSON('court.json', function(msg) { 
                $("#courtN").html(msg.courtN);
                });
			$("#BBtn").click(function(){
				window.location.href = "access2search.php";});
			$("#TBtn").click(function(){
				window.location.href = "access2searchmuti.php";});
            });
</script>
<body>
    <div class="container-fluid">

    <div class="row justify-content-center">
    <div class="col-8 text-center">
	<img class="mt-5 mb-3" src="img/coj1.png" alt width="150" >
	<h1 class="h3 mb-3 font-weight-normal">
    <p name="courtN" id="courtN"></p></h1>
	</div></div>

	<div class="row justify-content-center">
    <div class="col-4 text-center">
	<p class="mt-4 mb-3  text-muted"><u> ค้นหาด้วยหมายเลขคดีดำ<br>หมายเลขคดีแดง  </u></p>
	<button class="btn btn-lg btn-primary btn-lg btn-block mt-3" name="BBtn" id="BBtn">ค้นหาด้วยหมายเลขคดี</button>
	</div><div class="col-4 text-center">
	<p class="mt-4 mb-3  text-muted"><u> ค้นหาด้วยข้อมูลในคดีเช่น ชื่อ-สกุล เลขบัตรประชาชน <br> ข้อหา เหตุเกิด วันนัดพิจารณา  </u></p>
	<button class="btn btn-lg btn-info btn-lg btn-block mt-3" name="TBtn" id="TBtn">ค้นหาด้วยข้อมูลคดี</button>
	</div></div>

	<div class="row justify-content-center">
    <div class="col-8 text-center">
	<p class="mt-4 mb-3 text-muted">  ระบบบริการข้อมูลประชาชนใช้บริการแสดงข้อมูลเบื้องต้นเท่านั้น </p>
	<!-- <p class="mt-4 mb-3 text-muted"> VERSION 1.0 < อยู่ระหว่างปรับปรุงเพิ่มเติม > &#128516; </p> -->
	</div></div>

</div>
</body>
</html>