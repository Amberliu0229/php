<?php
namespace Factory;

class BreadStore_o
{
    public function orderBread($type)
    {
        if($type == 'cheese'){
            // $this->bread = new CheeseBread;
            echo 'CheeseBread';
        } elseif ($type == 'bacon'){
            // $this -> bread = new BaconBread;
            echo 'BaconBread';
        }
        // $this->bread->getdescription();
        // $this->bread->prepare();
        // $this->bread->bake();
    }
}
?>