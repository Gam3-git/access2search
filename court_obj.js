function court_text(){
    $.getJSON('court.json', function(msg) { 
        $("#courtN").html(msg.courtN);
    });
}

function date_case(datetext){
    if (datetext[2] != null){ 
        datecase =  datetext;
        datecase[2] = datecase[2].substring(2, 0);
        datecase[0] = parseInt(datecase[0]) + 543;
        return datecase[2]+"/"+datecase[1]+"/"+datecase[0];
    } else { return; }
}
function date_case2(datetext){
    if (datetext[0] != null){ 
        datecase =  datetext;
        datecase[0] = datecase[0].substring(2, 0);
        datecase[2] = parseInt(datecase[2]) - 543;
        return datecase[1]+"/"+datecase[0]+"/"+datecase[2];
    } else { return; }
}

// ------------------------------------ค้นหาจากเลขคดี-------------------------------------------------------

function search_case(num){
    if (num == 1){
        linkajax ="caseb.php?caseT="+$("#caseT").val();
    } else {
        linkajax ="caseb.php?caseRT="+$("#caseT").val();
    }
    
    $.ajax({
        type: "POST",
        url: linkajax,
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังค้นหาข้อมูล...',
                icon: 'warning',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                  }
            });
        },
        success: function(result){
        var jsonData = JSON.parse(result);
        if(jsonData == null){
            Swal.fire({ title: "ไม่พบข้อมูล", icon: "error", showConfirmButton: false, timer: 1000,});
            $('#form2')[0].reset();
            $('#form3')[0].reset();
        } else {
            // console.log(jsonData);
            Swal.fire({ icon: "success", showConfirmButton: false, timer: 1000,});
            $('#form2')[0].reset();
            $('#form3')[0].reset();
        $("#obt1").val(jsonData.valueC[0]['หมายเลขดำที่/พศ']);
        
        if(jsonData.valueC[0]['หมายเลขแดงที่'] != 0){
            var redcase = jsonData.valueC[0]['ผ/ฝ']+Math.floor(jsonData.valueC[0]['หมายเลขแดงที่'])+'/'+Math.floor(jsonData.valueC[0]['พศa']);
            $("#obt4").val(date_case(jsonData.valueC[0]['วันเดือนปีที่ตัดสิน'].split("-")));
        }else {
            var redcase = "";
            $("#obt4").val("");
        }
        $("#obt2").val(redcase);
        $("#obt3").val(date_case(jsonData.valueC[0]['วันเดือนปีรับฟ้อง'].split("-")));
        $("#obt5").val(jsonData.valueC[0]['ความa']);
        $("#obt6").val(jsonData.valueC[0]['ผู้พิพากษาเวรชี้']);
        $("#obt7").val(jsonData.valueC[0]['ข้อหา']);
        $("#obt8").val(jsonData.valueC[0]['ทุนทรัพย์']);
        $("#obt9").val(jsonData.valueC[0]['ชื่อผู้พิพากษา']);
        $("#obt10").val(jsonData.valueC[0]['องค์คณะ']);
        $("#obt11").val(jsonData.valueC[0]['ผู้พิพากษาตัดสิน']);
        $("#obt12").val(date_case(jsonData.valueC[0]['วันครบอุทธรณ์'].split("-")));
        $("#obt15").val(jsonData.valueC[0]['สารบบคำพิพากษา']);
        $("#obt16").val(jsonData.valueC[0]['namework']);
        $("#obt17").val(date_case(jsonData.valueC[0]['Timework'].split("-")));
        $("#obt17-2").val(jsonData.valueC[0]['เลขผัดฟ้อง']);

        $("#obt13").val(jsonData.valueP.replaceAll('\\n', '\n'));
        $("#obt14").val(jsonData.valueD.replaceAll('\\n', '\n'));
        }
    }, 
    error:function(msg){
        console.log( "error:", msg );
    }
});
}


// ------------------------------------ค้นหารายละเอียดคดี-------------------------------------------------------

function search_detailcase(num){
    if (num == null ){ d_linkajax ="casedetail.php?caseT="+$("#obt1").val()+"&detailC=1"; }
        else {  d_linkajax ="casedetail.php?caseT="+$("#obt1").val()+"&detailC="+num;  }

    $.ajax({
        type: "POST",
        url: d_linkajax,
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังค้นหาข้อมูล...',
                icon: 'warning',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                  }
            });
        },
        success: function(result){
            var jsonData = JSON.parse(result);
            if(jsonData == null){
                Swal.fire({ title: "ไม่พบข้อมูล", icon: "error", showConfirmButton: false, timer: 1000,});
                $('#obt19').empty().append('ไม่พบรายละเอียดข้อมูลคดี');
            } else {
                Swal.fire({ icon: "success", showConfirmButton: false, timer: 1000,});
                detailcase(jsonData,num);
        }
        }
    });
}


function detailcase(obj,num){
    var jsonData = obj;
    console.log( jsonData );
    switch (num) {
        case 1 :
        $('#obt19').empty().append('รายละเอียดข้อมูลคดี : วันนัดพิจารณา'); 
        var temp1 ='<thead class=bg-success><tr><th>วันนัดพิจารณา</th><th>รายการนัดฯ</th><th>เวลา</th><th>ห้องพิจารณาคดีที่</th><th>ผู้พิพากษาที่ขึ้นบัลลังก์</th><th>หมายเหตุ</th></tr></thead><tbody>';
        $('#obt18').empty().append(temp1);       
        for(var i = 0; i < jsonData.length; i++) {

            var temp = '<tr><td>' +date_case(jsonData[i]['วันปัจจุบัน'].split("-"))+ '</td>';
            temp+= '<td>' + jsonData[i]['นัดมาทำไม'] + '</td>';
            timec = jsonData[i]['เวลา'].split(".");
            if (timec[0].toString().length <= 1){
                var timecase = '0' + timec[0].toString() + ':' + timec[1].toString() + '0 น.';
            } else {
            var timecase = timec[0].toString() + ':' + timec[1].toString() + '0 น.';
            }
            temp+= '<td>' + timecase + '</td>';
            temp+= '<td>' + jsonData[i]['ห้องพิจารณาคดีที่'] + '</td>';
            temp+= '<td>' + jsonData[i]['ผู้พิพากษาที่ขึ้นบัลลังก์'] + '</td>';
            temp+= '<td>' + jsonData[i]['หมายเหตุ'] + '</td></tr>';
            $('#obt18').append(temp);
        } $('#obt18').append('</tbody>');
        break;
        case 2 :
        $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ผลการส่งหมาย');
        for(var i = 0; i < jsonData.length; i++) {
            var temp = '<thead class=bg-success><tr><th>วันที่จ่าย</th><th>ผู้ได้รับจ่าย</th><th>ส่งถึง</th><th>ผลการส่ง</th><th>ราคา</th></thead><tbody>';
           
            temp+= '<tr><td>' +date_case(jsonData[i]['Datejay'].split("-"))+ '</td>';
            temp+= '<td>' + jsonData[i]['vansong'] + '</td>';
            temp+= '<td>' + jsonData[i]['sentto'] + '</td>';
            temp+= '<td>' + jsonData[i]['Poonmay'] + '</td>';
            temp+= '<td>' + Math.floor(jsonData[i]['Postprice']) + '</td></tr></tbody>';
            temp += '<thead class=bg-secondary><tr><th>วันที่ส่ง</th><th>ผู้ส่ง</th><th>ประเภท</th><th>การดำเนินการ</th><th></th></thead><tbody>';
            temp+= '<tr><td>' +date_case(jsonData[i]['Datesong'].split("-"))+ '</td>';
            temp+= '<td>' + jsonData[i]['Namesong'] + '</td>';
            temp+= '<td>' + jsonData[i]['Namemay'] + '</td>';
            temp+= '<td>' + jsonData[i]['datail'] + '</td><td></td></tr><tr><td></td></tr><tr><td></td></tr></tbody>';
            $('#obt18').append(temp);
        }
        break;
        case 3 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : สารบบความ ');
            $('#obt19').append('<h3 style=color:white;>'+jsonData[0]['หมายเลขดำที่/พศ']+'</h3>');
            for(var i = 0; i < jsonData.length; i++) {
                var temp = '<thead class=bg-success><tr><th>สารบบความ</th><th>สารบบคำพิพากษา</th></tr></thead><tbody>';
                temp += '<tr><td style=width:50%;>'+jsonData[i]['สารบบความ']+'</td>';
                temp += '<td style=color:red;width:50%;>'+jsonData[i]['สารบบคำพิพากษา']+'</td></tr></tbody>';
                $('#obt18').append(temp);
            }
        break;
        case 4 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ติดตามสำนวนความ');
            var temp1 = '<thead class=bg-success><tr><th>วันที่ส่ง</th><th>ผู้ส่ง</th><th>ส่งถึง</th><th>ส่งเพื่อดำเนินการ</th><th>ผู้รับ</th><th>วันที่รับ</th></tr></thead><tbody>';
            $('#obt18').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                var temp = '<tr><td>' +date_case(jsonData[i]['วันที่ส่ง'].split("-"))+ '</td>';
                temp += '<td><a style=color:midnightblue;>'+jsonData[i]['dep_send']+'</a><br>'+jsonData[i]['ชื่อผู้ส่ง']+'</td>';
                temp += '<td><a style=color:midnightblue;>'+jsonData[i]['dep_send_re']+'</a><br>'+jsonData[i]['ส่งไปที่ใคร']+'</td>';
                temp += '<td>'+jsonData[i]['สำนวนออกไปทำอะไร']+'</td>';
                temp += '<td><a style=color:midnightblue;>'+jsonData[i]['dep_recive']+'</a><br>'+jsonData[i]['ชื่อผู้รับ']+'</td>';
                temp += '<td>'+jsonData[i]['Time']+'</td></tr>';
                $('#obt18').append(temp);
            } $('#obt18').append('</tbody>');
        break;
        case 5 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : คำสั่งศาล');
            var temp1 = '<thead class=bg-success><tr><th>ลำดับ</th><th>วันที่ยื่น</th><th>ชนิดเอกสาร</th><th>คำสั่งศาล</th><th>วันที่ศาลมีคำสั่ง</th></tr></thead><tbody>';
            $('#obt18').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                var temp = '<tr><td>' +jsonData[i]['ลำดับที่']+ '</td>';
                temp += '<td>' +date_case(jsonData[i]['วันเดือนปี'].split("-"))+ '</td>';
                temp += '<td>'+jsonData[i]['ชนิดคำคู่ความ']+'</td>';
                temp += '<td>'+jsonData[i]['คำสั่งศาล']+'</td>';
                temp += '<td>' +date_case(jsonData[i]['หมายเหตุ'].split("-"))+ '</td></tr>';
                $('#obt18').append(temp);
            } $('#obt18').append('</tbody>');
        break;
        case 6 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ข้อมูลอุทธรณ์');
            for(var i = 0; i < jsonData.length; i++) {  
                var temp = '<thead class=bg-success><tr><th>ลำดับ</th><th>วันที่ยื่น</th><th>ผู้ยื่น</th><th>วันอ่านคำพิพากษา</th><th>คำพิพากษา</th></tr></thead><tbody>';
                temp+= '<tr><td>'+(i+1)+'</td><td>' +date_case(jsonData[i]['Dateyernuton'].split("-"))+ '</td><td>' +jsonData[i]['Puyernuton']+'</td>';
                temp+= '<td>' +date_case(jsonData[i]['Datepipaksa'].split("-"))+'</td><td style=color:red;width:50%;>' +jsonData[i]['Kumpipaksa']+'</td></tr></tbody>';

                temp+= '<thead><tr><th></th><th>วันส่งศาลอุทธรณ์</th><th>เรื่องอุทธรณ์</th><th></th><th>ผู้พิพากษาที่อ่าน</th></tr></thead><tbody>';
                temp+= '<tr><td></td><td>' +date_case(jsonData[i]['Datesonguton'].split("-"))+ '</td><td>' +jsonData[i]['UD_detail']+'</td>';
                temp+= '<td></td><td>'+jsonData[i]['justsonguton']+'</td></tr></tbody>';
                $('#obt18').append(temp);
            }
        break;
        case 7 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ข้อมูลฎีกา');
            for(var i = 0; i < jsonData.length; i++) {  
                var temp = '<thead class=bg-success><tr><th>ลำดับ</th><th>วันที่ยื่น</th><th>ผู้ยื่น</th><th>วันอ่านคำพิพากษา</th><th>คำพิพากษา</th></tr></thead><tbody>';
                temp+= '<tr><td>'+(i+1)+'</td><td>' +date_case(jsonData[i]['Dateyerndega'].split("-"))+ '</td><td>' +jsonData[i]['Puyerndega']+'</td>';
                temp+= '<td>' +date_case(jsonData[i]['Datepipaksa'].split("-"))+'</td><td style=color:red;width:50%;>' +jsonData[i]['Kumpipaksa']+'</td></tr></tbody>';

                temp+= '<thead><tr><th></th><th>วันส่งศาลฎีกา</th><th>เรื่องฎีกา</th><th></th><th>ผู้พิพากษาที่อ่าน</th></tr></thead><tbody>';
                temp+= '<tr><td></td><td>' +date_case(jsonData[i]['Datesongdega'].split("-"))+ '</td><td>' +jsonData[i]['UD_detail']+'</td>';
                temp+= '<td></td><td>'+jsonData[i]['justsongdega']+'</td></tr></tbody>';
                $('#obt18').append(temp);
            }
        break;
        case 8 :
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ผัดฟ้อง/ฝากขัง'); 
            $('#obt19').append('<h3 style=color:white;>'+jsonData[0]['หมายเลขดำที่/พศ']+'</h3>');
            var temp = '<tr class=text-center><td> ประเภทคดี : '+jsonData[0]['ความ']+'<br> วันผัดฟ้อง/ฝากขังแรก : '+date_case(jsonData[0]['วันเดือนปีรับฟ้อง'].split("-"))+
            '<br> ผู้ร้อง : '+jsonData[0]['โจทก์']+'<br> ผู้ต้องหา : '+jsonData[0]['จำเลย']+'<br> ข้อหา : '+jsonData[0]['ข้อหา']+'<br> ผู้พิพากษาเวรชี้ : '+jsonData[0]['ผู้พิพากษาเวรชี้']+'</td></tr>';
            $('#obt18').append(temp);
            for(var i = 0; i < jsonData.length; i++) { 
                temp = '<tr class=text-center><td> ครั้งที่ : '+jsonData[i]['ครั้งที่']+' อนุญาต : '+jsonData[i]['ขังมีกำหนด/วัน']+' วัน  นับแต่วันที่ : '+
                date_case(jsonData[i]['เริ่มนับ'].split("-"))+' ถึง : '+date_case(jsonData[i]['วันครบขัง'].split("-"))+'</td></tr>';
                $('#obt18').append(temp);
            } 
        break; 
        case 9 : 
            $('#obt19').empty().append('รายละเอียดข้อมูลคดี : ฟื้นฟู'); 
            $('#obt19').append('<h3 style=color:white;>'+jsonData[0]['หมายเลขดำที่/พศ']+'</h3>');
            var temp = '<tr class=text-center><td> ประเภทคดี : '+jsonData[0]['ความ']+'<br> วันที่รับฟื้นฟู : '+date_case(jsonData[0]['วันเดือนปีรับฟ้อง'].split("-"))+
            '<br> ผู้ร้อง : '+jsonData[0]['โจทก์']+'<br> ผู้ต้องหา : '+jsonData[0]['จำเลย']+'<br> ข้อหา : '+jsonData[0]['ข้อหา']+'<br> คำสั่งศาล : '+jsonData[0]['คำสั่งศาล']+
            '<br> ผลคำวินิจฉัย : '+jsonData[0]['ผลคำวินิจฉัย']+'<br> ผลฟื้นฟู : '+jsonData[0]['ผลฟื้นฟู']+'</td></tr>';
            $('#obt18').append(temp);
        break;  
        default: $('#obt18').empty().html(); $('#obt19').empty().append('ไม่พบข้อมูลคดี'); break;
    }
}


// ------------------------------------ค้นหาจากข้อความ-------------------------------------------------------

function textsearch(num){

    if (num == null ){ linkajax ="casetext.php?caseT="+$("#caseT").val()+"&detailC=1";
        }else if(num == 4){
            textdate = date_case2($("#caseT").val().split("/")); 
            linkajax ="casetext.php?caseT="+textdate+"&detailC="+num;
        } else { linkajax ="casetext.php?caseT="+$("#caseT").val()+"&detailC="+num; } 
        
    $.ajax({
        type: "POST",
        url: linkajax,
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังค้นหาข้อมูล...',
                icon: 'warning',
                text: 'เมื่อพบข้อมูลคลิกที่เลขคดีดำเพื่อดู',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                  }
            });
        },
        success: function(result,textStatus, jqXHR){
            console.log(textStatus + ": " + jqXHR.status);
        var jsonData = JSON.parse(result);
        if(jsonData == null){   
            // console.log(jsonData); 
            Swal.fire({ title: "ไม่พบข้อมูล", icon: "error", showConfirmButton: false, timer: 1000,});
            $('#obttext').DataTable().clear().draw();
            $('#obttext').DataTable().destroy();
            $('#obttext').DataTable();
            
        } else {
            // console.log(jsonData);
            Swal.fire({ icon: "success", showConfirmButton: false, timer: 1000,});
            $('#obttext').DataTable().clear().draw();
            $('#obttext').DataTable().destroy();
            textsearch_detail(jsonData,num);  
            
        }
    }, 
    error:function(jqXHR, textStatus, errorThrown){
        console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
    }
    });
}


function textsearch_detail(obj,num){
    var jsonData = obj;
    var htmlsend = "/access2search/access2search.php?"; 
    switch (num) {
        case 1 :
            var temp1 = '<thead class=bg-success><tr><th>หมายเลขคดีดำ</th><th>หมายเลขคดีแดง</th><th>ชื่อ-สกุล โจทก์</th><th>ชื่อ-สกุล จำเลย</th><th>ข้อหา</th><th>ดูเพิ่มเติม</th></tr></thead><tbody>';
            $('#obttext').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                if(jsonData[i]['หมายเลขแดงที่'] != 0){
                    casered = jsonData[i]['ผ/ฝ']+parseInt(jsonData[i]['หมายเลขแดงที่'])+'/'+parseInt(jsonData[i]['พศa']);
                }else{ casered = '-'}
                var temp = '<tr><td><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank">' +jsonData[i]['หมายเลขดำที่/พศ']+ '</a></td>';
                temp += '<td class= text-danger>'+casered+'</td><';
                temp += '<td>'+jsonData[i]['ชื่อและนามสกุลโจทก์']+'</td>';
                temp += '<td>'+jsonData[i]['จำเลย']+'</td>';
                temp += '<td>'+jsonData[i]['ข้อหา']+'</td>';
                temp += '<td style=text-align:center;><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank"><i class="fa-solid fa-up-right-from-square fa-2x"></i></a></td></tr>';
                $('#obttext').append(temp);
            } $('#obttext').append('</tbody>');
            break;
        case 2 :
            var temp1 = '<thead class=bg-success><tr><th>หมายเลขคดีดำ</th><th>หมายเลขคดีแดง</th><th>ชื่อ-สกุล จำเลย</th><th>ชื่อ-สกุล โจทก์</th><th>ข้อหา</th><th>ดูเพิ่มเติม</th></tr></thead><tbody>';
            $('#obttext').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                if(jsonData[i]['หมายเลขแดงที่'] != 0){
                    casered = jsonData[i]['ผ/ฝ']+parseInt(jsonData[i]['หมายเลขแดงที่'])+'/'+parseInt(jsonData[i]['พศa']);
                }else{ casered = '-'}
                var temp = '<tr><td><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank">' +jsonData[i]['หมายเลขดำที่/พศ']+ '</a></td>';
                temp += '<td class= text-danger>'+casered+'</td><';
                temp += '<td>'+jsonData[i]['ชื่อ และ นามสกุล']+' '+jsonData[i]['สถานะ']+'</td>';
                temp += '<td>'+jsonData[i]['โจทก์']+'</td>';
                temp += '<td>'+jsonData[i]['ข้อหา']+'</td>';
                temp += '<td style=text-align:center;><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank"><i class="fa-solid fa-up-right-from-square fa-2x"></i></a></td></tr>';
                $('#obttext').append(temp);
            } $('#obttext').append('</tbody>');
            break;
        case 3 :
            var temp1 = '<thead class=bg-success><tr><th>หมายเลขคดีดำ</th><th>หมายเลขคดีแดง</th><th>ชื่อ-สกุล โจทก์</th><th>ชื่อ-สกุล จำเลย</th><th>ข้อหา</th><th>ดูเพิ่มเติม</th></tr></thead><tbody>';
            $('#obttext').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                if(jsonData[i]['หมายเลขแดงที่'] != 0){
                    casered = jsonData[i]['ผ/ฝ']+parseInt(jsonData[i]['หมายเลขแดงที่'])+'/'+parseInt(jsonData[i]['พศa']);
                }else{ casered = '-'}
                var temp = '<tr><td><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank">' +jsonData[i]['หมายเลขดำที่/พศ']+ '</a></td>';
                temp += '<td class= text-danger>'+casered+'</td><';
                temp += '<td>'+jsonData[i]['ชื่อและนามสกุลโจทก์']+'</td>';
                temp += '<td>'+jsonData[i]['ชื่อ และ นามสกุล']+' '+jsonData[i]['สถานะ']+'</td>';
                temp += '<td>'+jsonData[i]['ข้อหา']+'</td>';
                temp += '<td style=text-align:center;><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank"><i class="fa-solid fa-up-right-from-square fa-2x"></i></a></td></tr>';
                $('#obttext').append(temp);
            } $('#obttext').append('</tbody>');
            break;
        case 4 :
            var temp1 = '<thead class=bg-success><tr><th>หมายเลขคดีดำ</th><th>หมายเลขคดีแดง</th><th>วันนัดพิจารณา</th><th>ชื่อ-สกุล โจทก์</th><th>ชื่อ-สกุล จำเลย</th><th>ข้อหา</th><th>ดูเพิ่มเติม</th></tr></thead><tbody>';
            $('#obttext').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                if(jsonData[i]['หมายเลขแดงที่'] != 0){
                    casered = jsonData[i]['ผ/ฝ']+parseInt(jsonData[i]['หมายเลขแดงที่'])+'/'+parseInt(jsonData[i]['พศa']);
                }else{ casered = '-'}
                var temp = '<tr><td><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank">' +jsonData[i]['หมายเลขดำที่/พศ']+ '</a></td>';
                temp += '<td class= text-danger>'+casered+'</td><';
                temp += '<td>'+date_case( jsonData[i]['วันปัจจุบัน'].split("-"))+'</td>';
                temp += '<td>'+jsonData[i]['โจทก์']+'</td>';
                temp += '<td>'+jsonData[i]['จำเลย']+'</td>';
                temp += '<td>'+jsonData[i]['ข้อหา']+'</td>';
                temp += '<td style=text-align:center;><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank"><i class="fa-solid fa-up-right-from-square fa-2x"></i></a></td></tr>';
                $('#obttext').append(temp);
            } $('#obttext').append('</tbody>');
            break;
        case 5 :
            var temp1 = '<thead class=bg-success><tr><th>หมายเลขคดีดำ</th><th>หมายเลขคดีแดง</th><th>ชื่อ-สกุล โจทก์</th><th>ชื่อ-สกุล จำเลย</th><th>ข้อหา</th><th>ดูเพิ่มเติม</th></tr></thead><tbody>';
            $('#obttext').empty().append(temp1);
            for(var i = 0; i < jsonData.length; i++) {
                if(jsonData[i]['หมายเลขแดงที่'] != 0){
                    casered = jsonData[i]['ผ/ฝ']+parseInt(jsonData[i]['หมายเลขแดงที่'])+'/'+parseInt(jsonData[i]['พศa']);
                }else{ casered = '-'}
                var temp = '<tr><td><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank">' +jsonData[i]['หมายเลขดำที่/พศ']+ '</a></td>';
                temp += '<td class= text-danger>'+casered+'</td><';
                temp += '<td>'+jsonData[i]['โจทก์']+'</td>';
                temp += '<td>'+jsonData[i]['จำเลย']+'</td>';
                temp += '<td>'+jsonData[i]['ข้อหา']+'</td>';
                temp += '<td style=text-align:center;><a href='+htmlsend+encodeURIComponent(jsonData[i]['หมายเลขดำที่/พศ'])+' target="_blank"><i class="fa-solid fa-up-right-from-square fa-2x"></i></a></td></tr>';
                $('#obttext').append(temp);
            } $('#obttext').append('</tbody>');
            break;
            default: $('#obttext').empty(); break;
    }
    $('#obttext').DataTable();
}