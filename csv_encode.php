<?php 
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');

$fpread = fopen('test.csv', 'r');
$fpwrite = fopen('write.txt', 'w');
$max_line = 2000;
$delimiter = ",";
if ($fpread !== FALSE){
    while ($data = fgetcsv($fpread,$max_line,$delimiter)) {
    
        $num = count($data);
        $row++;  
        if($row != 1 ){
            for ($c=0; $c < $num; $c++) {
                fwrite($fpwrite,$data[$c]);
                fwrite($fpwrite,"\n");
            }
            $json = json_encode($data);
            array_walk_recursive($data, function(&$value, $key) {
                if(is_string($value)) {
                    $value = urlencode($value);
                }
            });
            $json = urldecode(json_encode($data));
            print_r($json);
            print_r("\n");
        }
    }
}


fclose($fpread);
fclose($fpwrite);
?>