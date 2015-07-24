<?php

namespace Data\Device\Android;

use Data\Device\Base\Device;

class Android extends Device
{
    private $_isTablet;

    public function __construct($versionInfo, $isTablet)
    {
        parent::__construct($versionInfo);
        $this->_isTablet = $isTablet;
    }

    public function isTablet()
    {
        return $this->_isTablet;
    }
}

