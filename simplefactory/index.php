<?php

use Factory\BreadStore;

include ("breadstore.php");

$store = new BreadStore;
$store->orderBread('bacon');
?>