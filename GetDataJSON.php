<?php 
/*
Author : Wuttinan
*/

class GetData
{
        public static function getIndexProvince($provinceTHName)
        {

                $province = "สำนักงาน ฝ่ายบริหาร";
                $ex_province = explode(" ", $province);

                foreach ($ex_province as $key => $value) {
                       if($provinceTHName == $value){
                        return $key;
                        }
                }
        }
        public static function getDevision($province)
        {
                //header ('Content-type: text/html; charset=utf-8');

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
                foreach ($obj as $row){
		echo $row['Buil']." ";
		echo $row['ID']." ";
		echo $row['room']." ";
		echo $row['Devision']." ";
		echo $row['tel']." ";
		echo "<br>";}
                $index = self::getIndexProvince($province);
                if(isset($index)){
                        $data_province = $row->stats[$index]->Devision;
                        $data_Buil = $row->stats[$index]->Buil;
                        $data_ID = $row->stats[$index]->ID;
                        $data_room = $row->stats[$index]->room;
                        $data_Devision = $row->stats[$index]->Devision;
                        $data_tel = $row->stats[$index]->tel;
                       

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
