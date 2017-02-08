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
                        $data_temp_current = $obj->Stations[$index]->Observe->Temperature->Value;
                        $data_temp_max = $obj->Stations[$index]->Observe->MaxTemperature->Value;
                        $data_temp_min = $obj->Stations[$index]->Observe->MinTemperature->Value;
                        $data_relativeHumidity = $obj->Stations[$index]->Observe->RelativeHumidity->Value;
                        $data_windSpeed = $obj->Stations[$index]->Observe->WindSpeed->Value;
                       

                        $data_array = array(
                        "province" => "{$data_province}",
                        "temperature_current" => "{$data_temp_current}",
                        "temperature_max" => "{$data_temp_max}",
                        "temperature_min" => "{$data_temp_min}",
                        "relativeHumidity" => "{$data_relativeHumidity}",
                        "windSpeed" => "{$data_windSpeed}",
                        
                        "KEY" => "{$index}",
                        );

                        return $data_array;

                }else {
                        return "Province_NULL";
                }

        }

}
?>
