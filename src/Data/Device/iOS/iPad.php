<?php

namespace Data\Device\iOS;

use Data\Device\iOS\iOS;

class iPad extends iOS
{
    public function isTablet()
    {
        return true;
    }
}

