<?php

use Factory\BreadStore_o;

include ("breadstore.php");

$mystore = new BreadStore_o;
$mystore->orderbread('cheese');
?>