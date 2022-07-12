<?php 
    $json = file_get_contents('court.json');
    $dataj = json_decode($json, true);
    $db = $dataj['dbA'];
    $driverdb = $dataj['driverA'];
    $conn = new PDO($driverdb."Dbq=$db", null, null);

    // $_GET["caseT"] = '5100599087226'; $_GET["detailC"] = 3;  3759900011530
    // $_GET["caseT"] = 'วิสาร'; $_GET["detailC"] = 2;
    //  $_GET["caseT"] = '10/26/2021'; $_GET["detailC"] = 4;

    if(isset($_GET["caseT"]) && $_GET["caseT"]!="" && isset($_GET["detailC"]) && $_GET["detailC"]!=""){
    $CaseT = $_GET["caseT"]; 
    switch ($_GET["detailC"]){

  
        case 1 :
            if (substr_count($CaseT, ' ') == 1){
                $Array_caseT = explode(" ", $CaseT); 
                $Text_caseT = $Array_caseT[0].'  '.$Array_caseT[1];
            } else { $Text_caseT = $CaseT; }
            $TableN1 = 'แผนกรับฟ้อง';
            $TableN2 = 'โจทก์';
            $FiledN = 'หมายเลขดำที่/พศ';
            $FiledN2 = 'ชื่อและนามสกุลโจทก์';
            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],[โจทก์].[ชื่อและนามสกุลโจทก์],[แผนกรับฟ้อง].[จำเลย],[แผนกรับฟ้อง].[ข้อหา]';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN] WHERE [$TableN2].[$FiledN2] LIKE '%$Text_caseT%'");
        break ;
        case 2 :
            if (substr_count($CaseT, ' ') == 1){
                $Array_caseT = explode(" ", $CaseT); 
                $Text_caseT = $Array_caseT[0].'  '.$Array_caseT[1];
            } else { $Text_caseT = $CaseT; }
            $TableN1 = 'แผนกรับฟ้อง';
            $TableN2 = 'จำเลย';
            $FiledN = 'หมายเลขดำที่/พศ';
            $FiledN2 = 'ชื่อ และ นามสกุล';
            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],[จำเลย].[ชื่อ และ นามสกุล],[จำเลย].[สถานะ],[แผนกรับฟ้อง].[โจทก์],[แผนกรับฟ้อง].[ข้อหา]';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN] WHERE [$TableN2].[$FiledN2] LIKE '%$Text_caseT%'");
        break ;
        case 3 :
            $TableN1 = 'แผนกรับฟ้อง';
            $TableN2 = 'จำเลย';
            $TableN3 = 'โจทก์';
            $FiledN = 'หมายเลขดำที่/พศ';
            $FiledN2 = 'IDCard';
            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],[โจทก์].[ชื่อและนามสกุลโจทก์],[จำเลย].[ชื่อ และ นามสกุล],[จำเลย].[สถานะ],[แผนกรับฟ้อง].[ข้อหา]';
            $query = ConvertTIS620("SELECT $TextV FROM ([$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN]) LEFT JOIN [$TableN3] ON [$TableN3].[$FiledN] = [$TableN1].[$FiledN] WHERE [$TableN2].[$FiledN2] = '$CaseT' OR [$TableN3].[$FiledN2] = '$CaseT'");           
        break ;
        case 4 :
            $TableN1 = 'แผนกรับฟ้อง';
            $TableN2 = 'สมุดนัดพิจารณา';
            $FiledN = 'หมายเลขดำที่/พศ';
            $FiledN2 = 'หมายเลขคดีดำที่/พศ';
            $FiledN3 = 'วันปัจจุบัน';
            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],[แผนกรับฟ้อง].[โจทก์],[แผนกรับฟ้อง].[จำเลย],[แผนกรับฟ้อง].[ข้อหา],[สมุดนัดพิจารณา].[วันปัจจุบัน]';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN2] WHERE [$TableN2].[$FiledN3] = #$CaseT#");        
        break ;
        case 5 :
            $TableN1 = 'แผนกรับฟ้อง';
            $FiledN2 = 'ข้อหา';
            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],[แผนกรับฟ้อง].[โจทก์],[แผนกรับฟ้อง].[จำเลย],[แผนกรับฟ้อง].[ข้อหา]';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] WHERE [$TableN1].[$FiledN2] LIKE '%$CaseT%'");        
        break ;
        default: $resDe = null; break;

    }
    $result = $conn->prepare($query);
    $result->execute();
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    $resDe = ArrayEncodeTH2D($row); 

    if($_GET["detailC"] == 2 or $_GET["detailC"] == 3){
        for($i=0; $i<sizeof($resDe); $i++){
            switch ($resDe[$i]['สถานะ']){
            case "1" : $resDe[$i]['สถานะ'] = "(จำเลย)"; break;
            case "2" : $resDe[$i]['สถานะ'] = "(ผู้ตาย)"; break;
            case "3" : $resDe[$i]['สถานะ'] = "(ผู้เสียหาย)"; break;
            case "4" : $resDe[$i]['สถานะ'] = "(บุคคลสาบสูญ)"; break;
            case "5" : $resDe[$i]['สถานะ'] = "(คนไร้ความสามารถ)"; break;
            case "6" : $resDe[$i]['สถานะ'] = "(คนเสมือนไร้ความสามารถ)"; break;
            case "7" : $resDe[$i]['สถานะ'] = "(อัยการ/ทนายโจทก์)"; break;
            case "8" : $resDe[$i]['สถานะ'] = "(ทนายจำเลย)"; break;
            case "9" : $resDe[$i]['สถานะ'] = "(ทนายผู้ร้อง)"; break;
            default : $resDe[$i]['สถานะ'] = "(คู่ความ)";
            }}
    }

    if(!empty($resDe)){
        // print_r ($resDe);
        echo json_encode($resDe);
        } else { $resDe = null; echo json_encode($resDe); }
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