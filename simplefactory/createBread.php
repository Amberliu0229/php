<?php
namespace Factory;

class CheeseBread
{
    public function description()
    {
        echo "CheeseBread<br>";
    }
    public function prepare()
    {
        echo "prepare cheese and flour<br>"; 
    }
    public function bake()
    {
        echo "send into the oven<br>";
    }
}
class BaconBread
{
    public function description()
    {
        echo "BaconBread<br>";
    }
    public function prepare()
    {
        echo "prepare bacon and flour<br>";
    }
    public function bake()
    {
        echo "send into the oven<br>";
    }
}
?>