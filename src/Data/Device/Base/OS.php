<?php

namespace Data\Device\Base;

class OS
{
    private $_name;
    private $_version;

    public function __construct($name, $versionInfo)
    {
        $this->_name = $name;
        $this->_version = new Version($versionInfo);
    }

    public function name()
    {
        return $this->_name;
    }

    public function version()
    {
        return $this->_version;
    }
}

