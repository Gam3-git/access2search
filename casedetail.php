<?php

            $json = file_get_contents('court.json');
            $dataj = json_decode($json, true);
            $db = $dataj['dbA'];
            $driverdb = $dataj['driverA'];
            $conn = new PDO($driverdb."Dbq=$db", null, null);

        if(isset($_GET["caseT"]) && $_GET["caseT"]!="" && isset($_GET["detailC"]) && $_GET["detailC"]!=""){
            $CaseT = $_GET["caseT"];
            // $CaseT = "อ922/62"; $_GET["detailC"] = 6;
            switch ($_GET["detailC"]){
                case 1 :
                    $TableN1 = 'สมุดนัดพิจารณา';
                    $TextV = '[สมุดนัดพิจารณา].[หมายเลขคดีดำที่/พศ],[สมุดนัดพิจารณา].[วันปัจจุบัน],[สมุดนัดพิจารณา].[นัดมาทำไม],[สมุดนัดพิจารณา].เวลา,[สมุดนัดพิจารณา].[ห้องพิจารณาคดีที่],[สมุดนัดพิจารณา].[ผู้พิพากษาที่ขึ้นบัลลังก์],[สมุดนัดพิจารณา].[หมายเหตุ]';
                    $FiledN1 = 'หมายเลขคดีดำที่/พศ';
                    $FiledN2 = 'วันปัจจุบัน';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
                    break ;
                case 2 :
                    $TableN1 = 'TJaymay'; $TableN2 = '1dumnernkan'; $TableN3 = '1Maywhat';
                    $TextV = 'TJaymay.[หมายเลขดำที่/พศ],TJaymay.Datejay,TJaymay.sentto,[1Maywhat].Namemay,TJaymay.Postprice,TJaymay.Poonmay,[1dumnernkan].datail,TJaymay.Datesong,TJaymay.Namesong,TJaymay.vansong';
                    $FiledN1 = 'หมายเลขดำที่/พศ';
                    $FiledN2 = 'Datejay';
                    $query = ConvertTIS620("SELECT $TextV FROM ([$TableN1] 
                    INNER JOIN [$TableN2] ON $TableN1.DumnernTo = [$TableN2].id) 
                    INNER JOIN [$TableN3] ON $TableN1.maywhat = [$TableN3].id 
                    WHERE [$TableN1].[$FiledN1] = '$CaseT' ORDER BY [$TableN1].[$FiledN2] DESC");
                    break ;
                case 3 :
                    $TableN1 = 'Tsarabob';
                    $TextV = 'Tsarabob.[หมายเลขดำที่/พศ],Tsarabob.[สารบบความ],Tsarabob.[สารบบคำพิพากษา]';
                    $FiledN1 = 'หมายเลขดำที่/พศ'; 
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT'");
                    break ;
                case 4 :
                    $TableN1 = 'ฐานข้อมูลติดตามสำนวน';
                    $TableN2 = 'User';
                    $FiledN1 = 'หมายเลขดำที่/พศ'; $FiledN2 = 'วันที่ส่ง';
                    $FiledN3 = 'User_IDentify'; $FiledN4 = 'Dep';

                    $Sub_q1 = "SELECT $FiledN4 FROM $TableN2 WHERE $FiledN3 = [ฐานข้อมูลติดตามสำนวน].[ชื่อผู้ส่ง]";
                    $Sub_q2 = "SELECT $FiledN4 FROM $TableN2 WHERE $FiledN3 = [ฐานข้อมูลติดตามสำนวน].[ส่งไปที่ใคร]";
                    $Sub_q3 = "SELECT $FiledN4 FROM $TableN2 WHERE $FiledN3 = [ฐานข้อมูลติดตามสำนวน].[ชื่อผู้รับ]";
                    $TextV = '[ฐานข้อมูลติดตามสำนวน].[หมายเลขดำที่/พศ],[ฐานข้อมูลติดตามสำนวน].[วันที่ส่ง],[ฐานข้อมูลติดตามสำนวน].[ชื่อผู้ส่ง], ('.$Sub_q1.') AS dep_send ,[ฐานข้อมูลติดตามสำนวน].[ส่งไปที่ใคร], ('.$Sub_q2.') AS dep_send_re ,[ฐานข้อมูลติดตามสำนวน].[สำนวนออกไปทำอะไร],[ฐานข้อมูลติดตามสำนวน].[ชื่อผู้รับ], ('.$Sub_q3.') AS dep_recive, [ฐานข้อมูลติดตามสำนวน].Time';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
                    break ;
                case 5 :
                    $TableN1 = 'ฐานข้อมูลคำสั่งศาล';
                    $TextV = '[ฐานข้อมูลคำสั่งศาล].[หมายเลขคดีดำที่/พศ],[ฐานข้อมูลคำสั่งศาล].[ลำดับที่],[ฐานข้อมูลคำสั่งศาล].[วันเดือนปี],[ฐานข้อมูลคำสั่งศาล].[ชนิดคำคู่ความ],[ฐานข้อมูลคำสั่งศาล].[คำสั่งศาล],[ฐานข้อมูลคำสั่งศาล].[หมายเหตุ]';
                    $FiledN1 = 'หมายเลขคดีดำที่/พศ'; $FiledN2 = 'ลำดับที่';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
                    break ;
                case 6 : 
                    $TableN1 = 'tbooksonguton'; $TableN2 = '1utonwhat';
                    $TextV = '[tbooksonguton].[Rubfongmainkey],[tbooksonguton].[Dateyernuton],[tbooksonguton].[Puyernuton],[tbooksonguton].[Datesonguton],[1utonwhat].[UD_detail],[tbooksonguton].[Datepipaksa],[tbooksonguton].[Kumpipaksa],[tbooksonguton].[justsonguton]';
                    $FiledN1 = 'Rubfongmainkey'; $FiledN2 = 'Datesonguton';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] 
                    INNER JOIN [$TableN2] ON [$TableN1].[Cutkanwhat] = [$TableN2].[UD_id]
                    WHERE [$TableN1].[$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
                    break ;
                case 7 :
                    $TableN1 = 'tbooksongdega'; $TableN2 = '1utonwhat';
                    $TextV = '[tbooksongdega].[Rubfongmainkey],[tbooksongdega].[Dateyerndega],[tbooksongdega].[Puyerndega],[tbooksongdega].[Datesongdega],[1utonwhat].[UD_detail],[tbooksongdega].[Datepipaksa],[tbooksongdega].[Kumpipaksa],[tbooksongdega].[justsongdega]';
                    $FiledN1 = 'Rubfongmainkey'; $FiledN2 = 'Datesongdega';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] 
                    INNER JOIN [$TableN2] ON [$TableN1].[Cutkanwhat] = [$TableN2].[UD_id]
                    WHERE [$TableN1].[$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
                    break ;
                case 8 : 
                    $TableN1 = 'Tpatfong'; $TableN2 = 'แผนกรับฟ้อง';   
                    $TextV = '[Tpatfong].[หมายเลขดำที่/พศ],[Tpatfong].[ครั้งที่],[Tpatfong].[ขังมีกำหนด/วัน],[Tpatfong].[เริ่มนับ],[Tpatfong].[วันครบขัง],
                    [แผนกรับฟ้อง].[ความ],[แผนกรับฟ้อง].[วันเดือนปีรับฟ้อง],[แผนกรับฟ้อง].[โจทก์],[แผนกรับฟ้อง].[จำเลย],[แผนกรับฟ้อง].[ข้อหา],[แผนกรับฟ้อง].[ผู้พิพากษาเวรชี้]';
                    $FiledN1 = 'หมายเลขดำที่/พศ'; $FiledN2 = 'ครั้งที่';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] 
                    LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN1] = [$TableN2].[$FiledN1]
                    WHERE [$TableN1].[$FiledN1] = '$CaseT' ORDER BY [$TableN1].[$FiledN2] ASC");
                    break ;
                case 9 : 
                    $TableN1 = 'TFernfu';    
                    $TextV = '[TFernfu].[หมายเลขดำที่/พศ],[TFernfu].[ความ],[TFernfu].[โจทก์],[TFernfu].[จำเลย],[TFernfu].[ข้อหา],[TFernfu].[คำสั่งศาล],[TFernfu].[ผลคำวินิจฉัย],[TFernfu].[ผลฟื้นฟู],[TFernfu].[วันเดือนปีรับฟ้อง]';
                    $FiledN1 = 'หมายเลขดำที่/พศ';
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT'");
                    break ;
                default : 
                    $TableN1 = 'Tsarabob';
                    $TextV = 'Tsarabob.[หมายเลขดำที่/พศ],Tsarabob.[สารบบความ],Tsarabob.[สารบบคำพิพากษา]';
                    $FiledN1 = 'หมายเลขดำที่/พศ'; 
                    $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT'");
                    break ;
            }
                
            $result = $conn->prepare($query);
            $result->execute();
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            $resDe = ArrayEncodeTH2D($row); 


            if(!empty($resDe)){
            // print_r ($resDe);
            if ( $_GET["detailC"] == 4){
                for($i=0; $i<sizeof($resDe); $i++){
                    $resDe[$i]['dep_send'] = Dep_text($resDe[$i]['dep_send']);
                    $resDe[$i]['dep_send_re'] = Dep_text($resDe[$i]['dep_send_re']);
                    $resDe[$i]['dep_recive'] = Dep_text($resDe[$i]['dep_recive']);
                    $resDe[$i]['ชื่อผู้ส่ง'] = Name_reduce($resDe[$i]['ชื่อผู้ส่ง']);
                    $resDe[$i]['ส่งไปที่ใคร'] = Name_reduce($resDe[$i]['ส่งไปที่ใคร']);
                    $resDe[$i]['ชื่อผู้รับ'] = Name_reduce($resDe[$i]['ชื่อผู้รับ']);
                    }
            } else if ( $_GET["detailC"] == 9) {
                for($i=0; $i<sizeof($resDe); $i++){
                    switch ($resDe[$i]['คำสั่งศาล']){
                        case 1 : $resDe[$i]['คำสั่งศาล']= 'ส่งตัวไปควบคุมเพื่อตรวจพิสูจน์'; break ;
                        case 2 : $resDe[$i]['คำสั่งศาล']= 'ยกคำร้อง'; break ;
                        default : $resDe[$i]['คำสั่งศาล']= '_'; 
                    }
                    switch ($resDe[$i]['ผลคำวินิจฉัย']){
                        case 1 : $resDe[$i]['ผลคำวินิจฉัย']= 'แบบไม่ควบคุมตัว ฟื้นฟูแบบเข้ารับการฟื้นฟูตามโปรแกรม'; break ;
                        case 2 : $resDe[$i]['ผลคำวินิจฉัย']= 'แบบไม่ควบคุมตัว ฟื้นฟูแบบ ผู้ป่วยใน ณ โรงพยาบาล'; break ;
                        case 3 : $resDe[$i]['ผลคำวินิจฉัย']= 'แบบไม่ควบคุมตัว ฟื้นฟูแบบ ผู้ป่วยนอก ณ โรงพยาบาล'; break ;
                        case 4 : $resDe[$i]['ผลคำวินิจฉัย']= 'แบบควมคุมตัวเข้มงวด'; break ;
                        case 5 : $resDe[$i]['ผลคำวินิจฉัย']= 'แบบควบคุมตัวไม่เข้มงวด'; break ;
                        case 6 : $resDe[$i]['ผลคำวินิจฉัย']= 'ส่งตัวคืนพนักงานสอบสวนเพราะไม่พบ เมทฯ'; break ;
                        case 7 : $resDe[$i]['ผลคำวินิจฉัย']= 'ส่งตัวคืนพนักงานสอบสวนเพราะอยู่ระหว่างดำเนินคดี'; break ;
                        default : $resDe[$i]['ผลคำวินิจฉัย']= '_'; 
                    }
                    switch ($resDe[$i]['ผลฟื้นฟู']){
                        case 1 : $resDe[$i]['ผลฟื้นฟู']= 'เป็นที่น่าพอใจ'; break ;
                        case 2 : $resDe[$i]['ผลฟื้นฟู']= 'ไม่เป็นที่น่าพอใจ'; break ;
                        default : $resDe[$i]['ผลฟื้นฟู']= '_'; 
                    }
                }
            }

            echo json_encode($resDe);
            
            } else { $res = null; echo json_encode($res); }
        } else { $res = null; echo json_encode($res); }

function Dep_text($value){ 
    switch ($value){
        case "3" : 
        case "24" :
            return $value = "(ศูนย์หน้าบัลลังก์)"; break;
        case "4" : return $value  = "(ประชาสัมพันธ์)"; break;
        case "5" : return $value  = "(การเงิน)"; break;
        case "6" : return $value  = "(หมายสี/ขาว)"; break;
        case "7" : return $value  = "(ห้องเก็บสำนวน)"; break;
        case "8" : return $value  = "(อุทธรณ์/ฎีกา)"; break;
        case "9" : return $value  = "(สารบรรณ)"; break;
        case "15" : return $value  = "(ผู้บริหารศาล)"; break;
        case "16" : return $value  = "(งานไกล่เกลี่ย)"; break;
        case "25" : return $value  = "(งานคดี)"; break;
        case "26" : return $value  = "(ผู้พิพากษา)"; break;
        default : return $value  = "_";
        } 
}

function Name_reduce($value){
    $value=substr($value, 0, strrpos($value, ' '));
    return $value;
}

function ConvertUTF8($value){
    return iconv('TIS-620', 'UTF-8',$value);
}
function ConvertTIS620($value){
    return iconv('UTF-8','TIS-620',$value);
}
function ArrayEncodeTH($ar){ 
    $rows = array();
    foreach ($ar as $key => $value) {
            $key = ConvertUTF8($key);
            $value = ConvertUTF8($value); 
            $rows[$key] = $value;    
    }
    return $rows;
}
function ArrayEncodeTH2D($arr){  
    $rows = array();
    if($arr)
        foreach($arr as $row ) {
            $rows[] = ArrayEncodeTH($row);
        }
    return $rows;
}    
?>

