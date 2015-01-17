<?php

namespace Package2;

use Package1\Pack1;

/**
 *
 **/
class Pack2
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $pack1 = new Pack1();
    }
}

