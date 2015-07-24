<?php

namespace Data\Device;

use Data\Device\BlackBerry\BlackBerry;

class PlayBook extends BlackBerry
{
    public function isTablet()
    {
        return true;
    }
}

