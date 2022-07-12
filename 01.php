<?php 
$json = file_get_contents('court.json');
$dataj = json_decode($json, true);
$db = $dataj[0][dbA];
$driverdb = $dataj[0][driverA];
$conn = new PDO($driverdb."Dbq=$db", null, null);
$TableN1 = 'แผนกรับฟ้อง';
$_GET["caseRT"] = "อ394/62";
$textcase2 = "พ1/63";
$textcase3 = "ผบE1/2563";

    $CaseRT = $_GET["caseRT"];
    $texplode = explode("/",$CaseRT);
    $split = split("[0-9]",$texplode[0]);
    $nexplode = explode($split[0], $texplode[0]);
    echo $split[0]; echo $nexplode[1]; echo $texplode[1]; echo "<br><br>";

    $FiledN1 = 'ผ/ฝ';
    $FiledN2 = 'หมายเลขแดงที่';
    $FiledN3 = 'พศa';
    $FiledN4 = 'หมายเลขดำที่/พศ';
    $query = ConvertTIS620("SELECT [$FiledN4] FROM [$TableN1]  WHERE [$FiledN1] = '$split[0]' AND [$FiledN2] = $nexplode[1] AND [$FiledN3] = $texplode[1]");
    
    $result = $conn->prepare($query);
    $result->execute();
    $row = $result->fetchAll(PDO::FETCH_NUM);
    $resC = ArrayEncodeTH2D($row);
    echo $resC[0][0]; echo "<br><br>";





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