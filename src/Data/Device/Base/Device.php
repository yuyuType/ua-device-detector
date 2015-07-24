<?php

namespace Data\Device\Base;

use Data\Device\Base\OS;

abstract class Device
{
    private $_os;

    public function __construct($versionInfo)
    {
        $className = explode('\\', get_class($this));
        $this->_os = new OS(end($className), $versionInfo);
    }

    public function OS()
    {
        return $this->_os;
    }

    public function isTablet()
    {
        return false;
    }

    public function name()
    {
        return $this->_os->name();
    }
}

