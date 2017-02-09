<?php 
/*
Author : Wuttinan
*/

class GetData
{
        public static function getIndexProvince($provinceTHName)
        {

                $province = "สำนักงาน ห้องพัก";
                $ex_province = explode(" ", $province);

                foreach ($ex_province as $key => $value) {
                       if($provinceTHName == $value){
                        return $key;
                        }
                }
        }
        public static function getDevision($province)
        {
                header ('Content-type: text/html; charset=utf-8');

                $ch = curl_init(); 
                // set url สำหรับดึงข้อมูล 
                curl_setopt($ch, CURLOPT_URL, "https://www.namo.xyz/lineben/myfile.json"); 
                //return the transfer as a string 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                // ตัวแปร $output เก็บข้อมูลทั้งหมดที่ดึงมา 
                $output = curl_exec($ch); 
                // ปิดการเชื่อต่อ
                curl_close($ch);    
                // output ออกไปครับ
                $obj = json_decode($output);
                $index = self::getIndexProvince($province);
                if(isset($index)){
                        $data_province = $obj->Stations[$index]->StationNameTh;
                        $data_Buil = $obj->Stations[$index]->Observe->Build->Value;
                        $data_ID = $obj->Stations[$index]->Observe->IDnum->Value;
                        $data_room = $obj->Stations[$index]->Observe->roomdes->Value;
                        $data_Devision = $obj->Stations[$index]->Observe->Devisiondes->Value;
                        $data_tel = $obj->Stations[$index]->Observe->telephone->Value;
                       

                        $data_array = array(
                        "province" => "{$data_province}",
                        "Buil" => "{$data_Buil}",
                        "ID" => "{$data_ID}",
                        "room" => "{$data_room}",
                        "Devision" => "{$data_Devison}",
                        "tel" => "{$data_tel}",
                        
                        "KEY" => "{$index}",
                        );

                        return $data_array;

                }else {
                        return "Province_NULL";
                }

        }

}
?>
