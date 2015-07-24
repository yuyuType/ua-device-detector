<?php

namespace Data\Device\Base;

class Version
{
    private $_full;
    private $_major;

    public function __construct($versionInfo)
    {
        if (isset($versionInfo[1]) && isset($versionInfo[2])) {
            $this->_full = $versionInfo[1];
            $this->_major = $versionInfo[2];
        } else {
            $this->_full = null;
            $this->_major = null;
        }
    }

    public function full()
    {
        return $this->_full;
    }

    public function major()
    {
        return $this->_major;
    }
}

