<?php 
		$ch = curl_init(); 
                // set url สำหรับดึงข้อมูล 
                curl_setopt($ch, CURLOPT_URL, "https://www.namo.xyz/lineben/myfile.json"); 
                //return the transfer as a string 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                // ตัวแปร $output เก็บข้อมูลทั้งหมดที่ดึงมา 
                $output = curl_exec($ch); 
                    
                // output ออกไปครับ
                $obj = json_decode($output,true);
                foreach ($obj as $row){
		echo $row['Buil']." ";
		echo $row['ID']." ";
		echo $row['room']." ";
		echo $row['Devision']." ";
		echo $row['tel']." ";
		echo "<br>";}
			
		// ปิดการเชื่อต่อ
                curl_close($ch);
