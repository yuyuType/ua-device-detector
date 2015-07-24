<?php

namespace Data\Device;

use Data\Device\Android\Android;
use Data\Device\Android\Kindle;
use Data\Device\Base\Device;
use Data\Device\BlackBerry\BlackBerry;
use Data\Device\BlackBerry\BB10;
use Data\Device\BlackBerry\PlayBook;
use Data\Device\PC\PC;
use Data\Device\WindowsPhone\WindowsPhone;
use Data\Device\PC\Macintosh;
use Data\Device\PC\Windows;
use Data\Device\iOS\iOS;
use Data\Device\iOS\iPhone;
use Data\Device\iOS\iPad;
use Data\Device\iOS\iPod;

class Detector
{
    public static function isAndroid(Device $device)
    {
        return $device instanceof Android;
    }

    public static function isKindle(Device $device)
    {
        return $device instanceof Kindle;
    }

    public static function isBlackBerry(Device $device)
    {
        return $device instanceof BlackBerry;
    }

    public static function isBB10(Device $device)
    {
        return $device instanceof BB10;
    }

    public static function isPlayBook(Device $device)
    {
        return $device instanceof PlayBook;
    }

    public static function isWindowsPhone(Device $device)
    {
        return $device instanceof WindowsPhone;
    }

    public static function isPC(Device $device)
    {
        return $device instanceof PC;
    }

    public static function isMacintosh(Device $device)
    {
        return $device instanceof Macintosh;
    }

    public static function isWindows(Device $device)
    {
        return $device instanceof Windows;
    }

    public static function isiOS(Device $device)
    {
        return $device instanceof iOS;
    }

    public static function isiPhone(Device $device)
    {
        return $device instanceof iPhone;
    }

    public static function isiPad(Device $device)
    {
        return $device instanceof iPad;
    }

    public static function isiPod(Device $device)
    {
        return $device instanceof iPod;
    }

   public static function isSmartPhone(Device $device)
    {
        // iPod tuch はスマートフォンとして判定してません。
        // スマートフォンとして扱うのであればココに判定を追加して下さい。
        return (self::isiPhone($device) || self::isAndroid($device) || self::isBlackBerry($device) || self::isWindowsPhone($device))
            && $device->isTablet() === false;
    }

    public static function isMobile(Device $device)
    {
        return (self::isiOS($device) || self::isAndroid($device) || self::isBlackBerry($device) || self::isWindowsPhone($device))
            && $device->isTablet() === false;
    }

    public static function isTablet(Device $device)
    {
        return $device->isTablet();
    }

    public static function makeDevice($userAgent)
    {
        if (preg_match('/Windows Phone\s+(?:OS\s+)?((\d+)(?:\.\d+){1,2})/', $userAgent, $matches) === 1) {
            return new WindowsPhone($matches);
        } elseif (preg_match('/iPhone;\s+(?:U;\s+)?CPU\s+(?:iPhone\s+OS\s+((\d+)(?:\_\d+){1,2})\s+)?/', $userAgent, $matches) === 1) {
            return new iPhone($matches);
        } elseif (preg_match('/iPod(?: touch)?;\s+(?:U;\s+)?CPU\s+(?:iPhone\s+OS\s+((\d+)(?:\_\d+){1,2})\s+)?/', $userAgent, $matches) === 1) {
            return new iPod($matches);
        } elseif (preg_match('/iPad;\s+(?:U;\s+)?CPU\s+(?:OS\s+((\d+)(?:\_\d+){1,2})\s+)?/', $userAgent, $matches) === 1) {
            return new iPad($matches);
        } elseif (preg_match('/Android ?((\d+)(?:\.\d+){1,2})?(-[a-z0-9]+)?;/', $userAgent, $matches) === 1) {
            return new Android($matches, strpos($userAgent, 'Mobile') === false);
        } elseif (strpos($userAgent, 'Kindle') !== false || strpos($userAgent, 'Silk') !== false) {
            // Kindle Mobile view is a Android
            return new Kindle(null, true);
        } elseif (strpos($userAgent, 'PlayBook') !== false) {
            return new PlayBook(null);
        } elseif (strpos($userAgent, 'BlackBerry') !== false) {
            return new BlackBerry(null);
        } elseif (preg_match('/BB10;.*Version\/((\d+)(?:\.\d+){1,3})/', $userAgent, $matches) === 1) {
            return new BB10($matches);
        } elseif (preg_match('/Win(dows )?/', $userAgent, $matches) === 1) {
            return new Windows($matches);
        } elseif (preg_match('/Mac|PPC/', $userAgent, $matches) === 1) {
            return new Macintosh($matches);
        }
        return new PC(null);
    }

    public static function makeDeviceFromUserAgent()
    {
        return self::makeDevice(getenv('HTTP_USER_AGENT'));
    }
}
