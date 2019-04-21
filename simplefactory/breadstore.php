<?php
namespace Factory;

use Factory\BreadFactory;

include ("breadfactory.php");

class BreadStore
{
    public $bread;

    public function orderBread($type)
    {
        echo "======Order Bread=====<br>";
        $factory = new BreadFactory;
        $this->bread = $factory->createbread($type);
        $this->bread -> description();
        $this->bread->prepare();
        $this->bread->bake();
    }
}
?>
