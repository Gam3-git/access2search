<?php
        // $_GET["caseT"] = "อ1/64"; 
        // $_GET["caseRT"] = "อ.1/60"; 

            $json = file_get_contents('court.json');
            $dataj = json_decode($json, true);
            $db = $dataj['dbA'];
            $driverdb = $dataj['driverA'];
            $conn = new PDO($driverdb."Dbq=$db", null, null);
            $TableN1 = 'แผนกรับฟ้อง';
            $TableN2 = 'Tsarabob';
            $CaseT = array();

            if(isset($_GET["caseT"]) && $_GET["caseT"]!=""){
                $CaseT = $_GET["caseT"];
            } else if (isset($_GET["caseRT"]) && $_GET["caseRT"]!="") {
                // if (!preg_match('/^[ก-ฮ]+[0-9]+[/]+[0-9]+$/',$_GET["caseRT"])){
                //     $CaseT = ""; } 
                // else {
                $CaseRT = $_GET["caseRT"];
                $texplode = explode("/",$CaseRT);
                $split = preg_split('/[0-9]/',$texplode[0]);
                $nexplode = explode($split[0], $texplode[0]);
                // echo "$split[0] ++++   $nexplode[1]+++   $texplode[1]";

                $FiledN1 = 'ผ/ฝ';
                $FiledN2 = 'หมายเลขแดงที่';
                $FiledN3 = 'พศa';
                $FiledN4 = 'หมายเลขดำที่/พศ';
                $queryRT = ConvertTIS620("SELECT [$FiledN4] FROM [$TableN1] WHERE [$FiledN1] = '$split[0]' AND [$FiledN2] = $nexplode[1] AND [$FiledN3] = $texplode[1]");
                $resultRT = $conn -> prepare($queryRT);
                $resultRT -> execute();
                $rowRT = $resultRT->fetchAll(PDO::FETCH_NUM);
                $resRT = ArrayEncodeTH2D($rowRT);

                // print_r ($resRT);  echo $resRT[0][0]."<br><br>";

                if(!empty($resRT)) { $CaseT = $resRT[0][0];
                } else { $CaseT = ""; }
            // }
          
            } else { $CaseT = ""; }

            if(isset($CaseT)) {

            $TextV = '[แผนกรับฟ้อง].[หมายเลขดำที่/พศ],[แผนกรับฟ้อง].[ผ/ฝ],[แผนกรับฟ้อง].[หมายเลขแดงที่],[แผนกรับฟ้อง].[พศa],
            [แผนกรับฟ้อง].[วันเดือนปีรับฟ้อง],[แผนกรับฟ้อง].[วันเดือนปีที่ตัดสิน],[แผนกรับฟ้อง].[ความa],[แผนกรับฟ้อง].[ผู้พิพากษาเวรชี้],
            [แผนกรับฟ้อง].[ข้อหา],[แผนกรับฟ้อง].[ทุนทรัพย์],[แผนกรับฟ้อง].[ชื่อผู้พิพากษา],[แผนกรับฟ้อง].[องค์คณะ],
            [แผนกรับฟ้อง].[ผู้พิพากษาตัดสิน],[แผนกรับฟ้อง].[วันครบอุทธรณ์],[แผนกรับฟ้อง].[namework],[แผนกรับฟ้อง].[Timework],
            [แผนกรับฟ้อง].[เลขผัดฟ้อง],[Tsarabob].[สารบบคำพิพากษา]';
            $FiledN = 'หมายเลขดำที่/พศ';
            $FiledN2 = 'ความa';
            $query = ConvertTIS620("SELECT $TextV FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN] WHERE [$TableN1].[$FiledN] = '$CaseT' AND [$TableN1].[$FiledN2] IS NOT NULL");
            $result = $conn->prepare($query);
            $result->execute();
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            $resC = ArrayEncodeTH2D($row);
            // print_r ($resC); echo "<br><br>";

            $TableN2 = 'โจทก์';
            $Text1 = 'ชื่อและนามสกุลโจทก์';
            $query = ConvertTIS620("SELECT [$TableN2].[$Text1]  FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN] WHERE [$TableN1].[$FiledN] = '$CaseT'");
            $result = $conn->prepare($query);
            $result->execute();
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            $resP = ArrayEncodeTH2D($row);
            // print_r ($resP); echo "<br><br>";

            $TableN2 = 'จำเลย';
            $Text1 = 'ชื่อ และ นามสกุล';
            $Text2 = 'สถานะ';
            $query = ConvertTIS620("SELECT [$TableN2].[$Text1],[$TableN2].[$Text2]  FROM [$TableN1] LEFT JOIN [$TableN2] ON [$TableN1].[$FiledN] = [$TableN2].[$FiledN] WHERE [$TableN1].[$FiledN] = '$CaseT'");
            $result = $conn->prepare($query);
            $result->execute();
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            $resD = ArrayEncodeTH2D($row);
            for($i=0; $i<sizeof($resD); $i++){
                switch ($resD[$i]['สถานะ']){
                case "1" : $resD[$i]['สถานะ'] = "(จำเลย)"; break;
                case "2" : $resD[$i]['สถานะ'] = "(ผู้ตาย)"; break;
                case "3" : $resD[$i]['สถานะ'] = "(ผู้เสียหาย)"; break;
                case "4" : $resD[$i]['สถานะ'] = "(บุคคลสาบสูญ)"; break;
                case "5" : $resD[$i]['สถานะ'] = "(คนไร้ความสามารถ)"; break;
                case "6" : $resD[$i]['สถานะ'] = "(คนเสมือนไร้ความสามารถ)"; break;
                case "7" : $resD[$i]['สถานะ'] = "(อัยการ/ทนายโจทก์)"; break;
                case "8" : $resD[$i]['สถานะ'] = "(ทนายจำเลย)"; break;
                case "9" : $resD[$i]['สถานะ'] = "(ทนายผู้ร้อง)"; break;
                default : $resD[$i]['สถานะ'] = "(คู่ความ)";
                }}

            // print_r ($resD); echo "<br><br>";

            if(!empty($resC && $resP && $resD)){
                $i = 1;
                foreach ($resP as $row) {
                $rowValue = implode(',', $row);
                $PArray[] = $i.'). '.$rowValue.'\n';
                $i++; }
                $resP = implode($PArray);

                $i = 1;
                foreach ($resD as $row) {
                $rowValue = implode(',', $row);
                $DArray[] = $i.'). '.$rowValue.'\n';
                $i++; }
                $resD = implode($DArray);

                echo json_encode(array("valueC" => $resC, "valueP" => $resP, "valueD" => $resD));
            }else{
                $res = null;
                echo json_encode($res);
            }
        } else { $res = null; echo json_encode($res); }


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