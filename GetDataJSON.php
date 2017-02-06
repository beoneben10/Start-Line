<?php 
/*
Author : Wuttinan
*/

class GetData
{
        public static function getIndexProvince($provinceTHName)
        {

                $province = "แม่ฮ่องสอน แม่สะเรียง เชียงราย เชียงราย พะเยา ดอยอ่างขาง เชียงใหม่ ลำปาง เถิน ลำปาง ลำพูน แพร่ น่าน น่าน ท่าวังผา ทุ่งช้าง อุตรดิตถ์ หนองคาย เลย เลย อุดรธานี สกลนคร สกลนคร นครพนม นครพนม หนองบัวลำภู สุโขทัย ศรีสำโรง ตาก แม่สอด เขื่อนภูมิพล ดอยมูเซอร์ อุ้มผาง พิษณุโลก เพชรบูรณ์ หล่มสัก วิเชียรบุรี กำแพงเพชร ขอนแก่น ท่าพระ มุกดาหาร พิจิตร มหาสารคาม กาฬสินธุ์ นครสวรรค์ ตากฟ้า ชัยนาท ชัยภูมิ ร้อยเอ็ด ร้อยเอ็ด อุบลราชธานี อุบลราชธานี ศรีสะเกษ พระนครศรีอยุธยา ปทุมธานี ฉะเชิงเทรา ราชบุรี สุพรรณบุรี อู่ทอง ลพบุรี บัวชุม นำร่อง สมุทรปราการ สนามบินสุวรรณภูมิ ปราจีนบุรี กบินทร์บุรี นครราชสีมา ปากช่อง โชคชัย สุรินทร์ สุรินทร์ ท่าตูม บุรีรัมย์ นางรอง อรัญประเทศ สระแก้ว กาญจนบุรี ทองผาภูมิ นครปฐม กรุงเทพมหานคร กรุงเทพฯท่าเรือคลองเตย กรุงเทพฯบางนา สนามบินดอนเมือง ชลบุรี เกาะสีชัง พัทยา สัตหีบ เพชรบุรี ระยอง ห้วยโป่ง จันทบุรี พลิ้ว ประจวบคีรีขันธ์ หัวหิน หนองพลับ ตราด ชุมพร สวี ระนอง สุราษฎร์ธานี เกาะสมุย สุราษฎร์ธานี นครศรีธรรมราช นครศรีธรรมราช ฉวาง พัทลุง ตะกั่วป่า ภูเก็ต ภูเก็ต เกาะลันตา กระบี่ ตรัง คอหงษ์ สะเดา สงขลา หาดใหญ่ สตูล ปัตตานี ยะลา นราธิวาส";
                $ex_province = explode(" ", $province);

                foreach ($ex_province as $key => $value) {
                       if($provinceTHName == $value){
                        return $key;
                        }
                }
        }
        public static function getWeatherToday($province)
        {
                header ('Content-type: text/html; charset=utf-8');

                $ch = curl_init(); 
                // set url สำหรับดึงข้อมูล 
                curl_setopt($ch, CURLOPT_URL, "http://data.tmd.go.th/api/WeatherToday/V1/"); 
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
                        $data_rainfall = $obj->Stations[$index]->Observe->Rainfall->Value;

                        $data_array = array(
                        "province" => "{$data_province}",
                        "temperature_current" => "{$data_temp_current}",
                        "temperature_max" => "{$data_temp_max}",
                        "temperature_min" => "{$data_temp_min}",
                        "relativeHumidity" => "{$data_relativeHumidity}",
                        "windSpeed" => "{$data_windSpeed}",
                        "rainfall" => "{$data_rainfall}",
                        "KEY" => "{$index}",
                        );

                        return $data_array;

                }else {
                        return "Province_NULL";
                }

        }

}
?>