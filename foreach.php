<?php

$order_price = array();
$order_price['amazon'] = 100; 
$order_price['yahoo'] = 200;
$order_price['pchome'] = 300;
$order_price['google'] = 400;
$order_price['momo'] = 500;

$total = 0;
$sum = 0;

foreach( $order_price as $money){
    $total = $total + $money;
    echo $total."<br>";
}

foreach($order_price as $key => $money ){
    echo $key."的money：".$money."<br>";
}
echo "---------------------------<br>";
echo "Total money：" .$total;
?>