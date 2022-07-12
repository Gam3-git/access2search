<?php

            $json = file_get_contents('court.json');
            $dataj = json_decode($json, true);
            $db = $dataj['dbA'];
            $driverdb = $dataj['driverA'];
            $conn = new PDO($driverdb."Dbq=$db", null, null);

     
            $CaseT = "อ56/64"; 
      
           
            $TableN1 = 'ฐานข้อมูลติดตามสำนวน';
            $TableN2 = 'User';
            $FiledN1 = 'หมายเลขดำที่/พศ'; $FiledN2 = 'วันที่ส่ง';
            
            $FiledN6 = 'User_IDentify'; $FiledN7 = 'Dep';

            $Sub_q1 = "SELECT $FiledN7 FROM $TableN2 WHERE $FiledN6 = [ฐานข้อมูลติดตามสำนวน].[ชื่อผู้ส่ง]";
            $Sub_q2 = "SELECT $FiledN7 FROM $TableN2 WHERE $FiledN6 = [ฐานข้อมูลติดตามสำนวน].[ส่งไปที่ใคร]";
            $Sub_q3 = "SELECT $FiledN7 FROM $TableN2 WHERE $FiledN6 = [ฐานข้อมูลติดตามสำนวน].[ชื่อผู้รับ]";
            
            $TextV = '[ฐานข้อมูลติดตามสำนวน].[หมายเลขดำที่/พศ],[ฐานข้อมูลติดตามสำนวน].[วันที่ส่ง],[ฐานข้อมูลติดตามสำนวน].[ชื่อผู้ส่ง], ('.$Sub_q1.') AS dep_send ,[ฐานข้อมูลติดตามสำนวน].[ส่งไปที่ใคร], ('.$Sub_q2.') AS dep_send_re ,[ฐานข้อมูลติดตามสำนวน].[สำนวนออกไปทำอะไร],[ฐานข้อมูลติดตามสำนวน].[ชื่อผู้รับ], ('.$Sub_q3.') AS dep_recive, [ฐานข้อมูลติดตามสำนวน].Time';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$FiledN1] = '$CaseT' ORDER BY [$FiledN2] DESC");
            
            echo ConvertUTF8($query)."<br><br>";

            
                
            $result = $conn->prepare($query);
            $result->execute();
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            $resDe = ArrayEncodeTH2D($row); 

            for($i=0; $i<sizeof($resDe); $i++){
                switch ($resDe[$i]['dep_send']){
                    case "3" : 
                    case "24" :
                        $resDe[$i]['dep_send'] = "(ศูนย์หน้าบัลลังก์)"; break;
                    case "4" : $resDe[$i]['dep_send'] = "(ประชาสัมพันธ์)"; break;
                    case "5" : $resDe[$i]['dep_send'] = "(การเงิน)"; break;
                    case "6" : $resDe[$i]['dep_send'] = "(หมายสี/ขาว)"; break;
                    case "7" : $resDe[$i]['dep_send'] = "(ห้องเก็บสำนวน)"; break;
                    case "8" : $resDe[$i]['dep_send'] = "(อุทธรณ์/ฎีกา)"; break;
                    case "9" : $resDe[$i]['dep_send'] = "(สารบรรณ)"; break;
                    case "15" : $resDe[$i]['dep_send'] = "(ผู้บริหารศาล)"; break;
                    case "16" : $resDe[$i]['dep_send'] = "(งานไกล่เกลี่ย)"; break;
                    case "25" : $resDe[$i]['dep_send'] = "(งานคดี)"; break;
                    case "26" : $resDe[$i]['dep_send'] = "(ผู้พิพากษา)"; break;
                    default : $resDe[$i]['dep_send'] = "(อื่นๆ)";
                    }
                    switch ($resDe[$i]['dep_send_re']){
                        case "3" : 
                        case "24" :
                            $resDe[$i]['dep_send_re'] = "(ศูนย์หน้าบัลลังก์)"; break;
                        case "4" : $resDe[$i]['dep_send_re'] = "(ประชาสัมพันธ์)"; break;
                        case "5" : $resDe[$i]['dep_send_re'] = "(การเงิน)"; break;
                        case "6" : $resDe[$i]['dep_send_re'] = "(หมายสี/ขาว)"; break;
                        case "7" : $resDe[$i]['dep_send_re'] = "(ห้องเก็บสำนวน)"; break;
                        case "8" : $resDe[$i]['dep_send_re'] = "(อุทธรณ์/ฎีกา)"; break;
                        case "9" : $resDe[$i]['dep_send_re'] = "(สารบรรณ)"; break;
                        case "15" : $resDe[$i]['dep_send_re'] = "(ผู้บริหารศาล)"; break;
                        case "16" : $resDe[$i]['dep_send_re'] = "(งานไกล่เกลี่ย)"; break;
                        case "25" : $resDe[$i]['dep_send_re'] = "(งานคดี)"; break;
                        case "26" : $resDe[$i]['dep_send_re'] = "(ผู้พิพากษา)"; break;
                        default : $resDe[$i]['dep_send_re'] = "(อื่นๆ)";
                    }
                    switch ($resDe[$i]['dep_recive']){
                        case "3" : 
                        case "24" :
                            $resDe[$i]['dep_recive'] = "(ศูนย์หน้าบัลลังก์)"; break;
                        case "4" : $resDe[$i]['dep_recive'] = "(ประชาสัมพันธ์)"; break;
                        case "5" : $resDe[$i]['dep_recive'] = "(การเงิน)"; break;
                        case "6" : $resDe[$i]['dep_recive'] = "(หมายสี/ขาว)"; break;
                        case "7" : $resDe[$i]['dep_recive'] = "(ห้องเก็บสำนวน)"; break;
                        case "8" : $resDe[$i]['dep_recive'] = "(อุทธรณ์/ฎีกา)"; break;
                        case "9" : $resDe[$i]['dep_recive'] = "(สารบรรณ)"; break;
                        case "15" : $resDe[$i]['dep_recive'] = "(ผู้บริหารศาล)"; break;
                        case "16" : $resDe[$i]['dep_recive'] = "(งานไกล่เกลี่ย)"; break;
                        case "25" : $resDe[$i]['dep_recive'] = "(งานคดี)"; break;
                        case "26" : $resDe[$i]['dep_recive'] = "(ผู้พิพากษา)"; break;
                        default : $resDe[$i]['dep_recive'] = "(อื่นๆ)";
                    }
                }

            if(!empty($resDe)){
            print_r ($resDe);
            echo json_encode($resDe);
            } else { $resDe = null; echo json_encode($resDe); }
       

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

