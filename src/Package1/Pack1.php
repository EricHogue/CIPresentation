<?php

namespace Package1;

use Package2\Pack2;

/**
 *
 **/
class Pack1
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $pack2 = new Pack2();
    }
}


