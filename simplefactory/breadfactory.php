<?php
namespace Factory;
use Factory\createbread;
include ("createBread.php");

class BreadFactory
{
    public function createbread($type)
    {
        if ($type == 'cheese') {
            echo "=====The type is CheeseBread=====<br>";
            return new CheeseBread;
        } elseif ($type == 'bacon') {
            echo "=====The type is BaconBread=====<br>";
            return new BaconBread;
        } 
    }
}
?>