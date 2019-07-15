<?php 
$fpread = fopen('test.csv', 'r');
$fpwrite = fopen('write.csv', 'w');
$max_line = 2000;
$delimiter = ",";
if ($fpread !== FALSE){
    while ($data = fgetcsv($fpread,$max_line,$delimiter)) {
        $num = count($data);
        $row++;  
        if($row != 1 ){
            for ($c=0; $c < $num; $c++) {
                // fwrite($fpwrite,$data[$c]);
                // fwrite($fpwrite,"\n");
                $s = serialize($data[$c]);
                // print($s);
                $str = str_replace(array('[',']'),array('',''),$s);
                $newstr = explode(",",$str);
                $json = json_encode($newstr);
                printf($json); 
                // print("\n");
                // $unserialized_data = unserialize($newstr);
                fwrite($fpwrite,$json);
                fwrite($fpwrite,"\n");
            }
            // print_r($data);
            // $json = json_encode($data,JSON_UNESCAPED_UNICODE);
            // print_r($json);
            // print_r("\n");
            $data_json_url = json_decode($json,true);
        }
    }
}else{
    printf("CSV D.N.E");
}
function _removeBOM($str = '') {
    if (substr($str, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
        $str = substr($str, 3);
    }
    return $str;
}
fclose($fpread);
fclose($fpwrite);
?>