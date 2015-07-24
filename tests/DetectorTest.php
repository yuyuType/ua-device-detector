<?php

use Data\Device\Detector;

class DetectorTest extends PHPUnit_Framework_TestCase
{
    public function testMakeDeviceFromUserAgent()
    {
        $device = Detector::makeDeviceFromUserAgent();
        $this->assertFalse(is_null($device));
    }

    public function testMakeWindows()
    {
        $device = Detector::makeDevice("Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36 Edge/12.0");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        $device = Detector::makeDevice("Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        // Windows 7 の IE11
        $device = Detector::makeDevice("Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        // 64 ビット版 Windows 8.1 Update の IE11
        $device = Detector::makeDevice("Mozilla/5.0 (Windows NT 6.3; Win64, x64; Trident/7.0; Touch; rv:11.0) like Gecko");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        // 64 ビット版 Windows 8.1 Update のデスクトップ用 IE11
        $device = Detector::makeDevice("Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        // 64 ビット版 Windows 8.1 Update のデスクトップ用 IE11 (エンタープライズ モードが有効)
        $device = Detector::makeDevice("Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; Tablet PC 2.0)");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");

        // 64 ビット版 Windows 8.1 Update のデスクトップ用 IE11 (互換表示が有効)
        $device = Detector::makeDevice("Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.3; Trident/7.0; Touch)");
        $this->assertTrue(Detector::isPC($device));
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");
    }

    public function testMakeWindowsPhone()
    {
        // Windows Phone 8.1 Update の Internet Explorer
        $device = Detector::makeDevice("Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11; IEMobile/11.0) like Android 4.1.2; compatible) like iPhone OS 7_0_3 Mac OS X WebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari /537.36");
        $this->assertTrue(Detector::isWindowsPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8.1");
        $this->assertSame($device->name(), "WindowsPhone");

        // Windows Phone 8.1 を搭載した Lumia 928 の IE11 (モバイル バージョン)
        $device = Detector::makeDevice("Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11; IEMobile/11.0; NOKIA; Lumia 928) like Gecko");
        $this->assertTrue(Detector::isWindowsPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8.1");
        $this->assertSame($device->name(), "WindowsPhone");

        // Windows Phone 8.0 を搭載した Lumia 920 の IE (モバイル バージョン)
        $device = Detector::makeDevice("Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; rv:11; NOKIA; Lumia 920) like Gecko");
        $this->assertTrue(Detector::isWindowsPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8.0");
        $this->assertSame($device->name(), "WindowsPhone");

        // Windows Phone 8.0 を搭載した Lumia 920 の IE (デスクトップ バージョン)
        // デスクトップバージョンはPC扱い
        $device = Detector::makeDevice("Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; ARM; Touch; WPDesktop)");
        $this->assertTrue(Detector::isWindows($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Windows");
    }

    public function testMakeiOS5()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; U; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9A334 Safari/7534.48.3");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "5");
        $this->assertSame($device->OS()->version()->full(), "5_0");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "5");
        $this->assertSame($device->OS()->version()->full(), "5_0_1");
        $this->assertSame($device->name(), "iPad");
    }

    public function testMakeiOS6()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X; ja-jp) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "6");
        $this->assertSame($device->OS()->version()->full(), "6_0");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X; ja-jp) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "6");
        $this->assertSame($device->OS()->version()->full(), "6_0");
        $this->assertSame($device->name(), "iPad");
    }

    public function testMakeiOS7_0()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0");
        $this->assertSame($device->name(), "iPad");

        // iPod tuch
        $device = Detector::makeDevice("Mozilla/5.0 (iPod touch; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPod($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0");
        $this->assertSame($device->name(), "iPod");
    }

    public function testMakeiOS7_0_1()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A470a Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0_1");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 7_0_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A470a Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0_1");
        $this->assertSame($device->name(), "iPad");

        // iPod tuch
        $device = Detector::makeDevice("Mozilla/5.0 (iPod touch; CPU iPhone OS 7_0_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A470a Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPod($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_0_1");
        $this->assertSame($device->name(), "iPod");
    }

    public function testMakeiOS7_1_1()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D201 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_1_1");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 7_1_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11D201 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_1_1");
        $this->assertSame($device->name(), "iPad");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 7_1_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) GSA/4.1.0.31802 Mobile/11D201 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_1_1");
        $this->assertSame($device->name(), "iPad");

        // iPod tuch
        $device = Detector::makeDevice("Mozilla/5.0 (iPod touch; CPU iPhone OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D201 Safari/9537.53");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPod($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "7");
        $this->assertSame($device->OS()->version()->full(), "7_1_1");
        $this->assertSame($device->name(), "iPod");
    }

    public function testMakeiOS8_2()
    {
        // iPhone
        $device = Detector::makeDevice("Mozilla/5.0 (iPhone; CPU iPhone OS 8_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12D508 Safari/600.1.4");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPhone($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8_2");
        $this->assertSame($device->name(), "iPhone");

        // iPad
        $device = Detector::makeDevice("Mozilla/5.0 (iPad; CPU OS 8_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12D508 Safari/600.1.4");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPad($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8_2");
        $this->assertSame($device->name(), "iPad");

        // iPod tuch
        $device = Detector::makeDevice("Mozilla/5.0 (iPod touch; CPU iPhone OS 8_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12D508 Safari/600.1.4");
        $this->assertTrue(Detector::isiOS($device));
        $this->assertTrue(Detector::isiPod($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "8");
        $this->assertSame($device->OS()->version()->full(), "8_2");
        $this->assertSame($device->name(), "iPod");
    }

    public function testMakeAndroid1_5()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.5; ja-jp; GDDJ-09 Build/CDB56) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.5");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroid1_6()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.6; ja-jp; IS01 Build/S3082) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.6");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.6; ja-jp; IS01 Build/SA180) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.6");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.6; ja-jp; Docomo HT-03A Build/DRD08) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.6");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.6; ja-jp; SonyEricssonSO-01B Build/R1EA029) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.6");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 1.6; ja-jp; generic Build/Donut) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "1");
        $this->assertSame($device->OS()->version()->full(), "1.6");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroid2_x()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.1-update1; ja-jp; SonyEricssonSO-01B Build/2.0.2.B.0.29) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.2.1; ja-jp; Full Android Build/MASTER) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.2.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.2.1; ja-jp; IS03 Build/S9090) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.2.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.3; ja-jp; SC-02C Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.3; ja-jp; INFOBAR A01 Build/S9081) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.3; ja-jp; 001HT Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.3; ja-jp; SonyEricssonX10i Build/3.0.1.G.0.75) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.4; ja-jp; SonyEricssonIS11S Build/4.0.1.B.0.112) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.4");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.4; ja-jp; IS05 Build/S9290) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.4");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.5; ja-jp; F-05D Build/F0001) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.5");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 2.3.5; ja-jp; T-01D Build/F0001) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.5");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroid3_x()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.0.1; ja-jp; MZ604 Build/H.6.2-20) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.0.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.1; en-us; K1 Build/HMJ37) AppleWebKit/534.13(KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.1; ja-jp; AT100 Build/HMJ37) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.1; ja-jp; Sony Tablet S Build/THMAS10000) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2; ja-jp; SC-01D Build/MASTER) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2; ja-jp; AT1S0 Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2; ja-jp; F-01D Build/F0001) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2; ja-jp; Sony Tablet S Build/THMAS11000) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2; ja-jp; A01SH Build/HTJ85B) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 3.2.1; ja-jp; Transformer TF101 Build/HTK75) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2.1");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroid4_x()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 4.0.1; ja-jp; Galaxy Nexus Build/ITL41D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.0.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 4.0.3; ja-jp; URBANO PROGRESSO Build/010.0.3000) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.0.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 4.0.3; ja-jp; Sony Tablet S Build/TISU0R0110) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.0.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 4.0.4; ja-jp; SC-06D Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.0.4");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; U; Android 4.1.1; ja-jp; Galaxy Nexus Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.1.1");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; Android 4.1.1; Nexus 7 Build/JRO03S) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "4");
        $this->assertSame($device->OS()->version()->full(), "4.1.1");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroid5_x()
    {
        // 標準ブラウザ
        $device = Detector::makeDevice("Mozilla/5.0 (Linux; Android 5.0.2; SCV31 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/3.0 Chrome/38.0.2125.102 Mobile Safari/537.36");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "5");
        $this->assertSame($device->OS()->version()->full(), "5.0.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; Android 5.0.2; SCV31 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Mobile Safari/537.36");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "5");
        $this->assertSame($device->OS()->version()->full(), "5.0.2");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Mozilla/5.0 (Linux; Android 5.0.2; SCV31 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile Safari/537.36");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertFalse(Detector::isTablet($device));
        $this->assertTrue(Detector::isSmartPhone($device));
        $this->assertTrue(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "5");
        $this->assertSame($device->OS()->version()->full(), "5.0.2");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroidOpera()
    {
        // Opera
        $device = Detector::makeDevice("Opera/9.80 (Android 2.3.3; Linux; Opera Mobi/ADR-1111101157; U; ja) Presto/2.9.201 Version/11.50");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "2");
        $this->assertSame($device->OS()->version()->full(), "2.3.3");
        $this->assertSame($device->name(), "Android");

        $device = Detector::makeDevice("Opera/9.80 (Android 3.2.1; Linux; Opera Tablet/ADR-1109081720; U; ja) Presto/2.8.149 Version/11.10");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertSame($device->OS()->version()->major(), "3");
        $this->assertSame($device->OS()->version()->full(), "3.2.1");
        $this->assertSame($device->name(), "Android");
    }

    public function testMakeAndroidFirefox()
    {
        // Opera
        $device = Detector::makeDevice("Mozilla/5.0 (Android; Linux armv7l; rv:9.0) Gecko/20111216 Firefox/9.0 Fennec/9.0");
        $this->assertTrue(Detector::isAndroid($device));
        $this->assertTrue(Detector::isTablet($device));
        $this->assertFalse(Detector::isSmartPhone($device));
        $this->assertFalse(Detector::isMobile($device));
        $this->assertNull($device->OS()->version()->major());
        $this->assertNull($device->OS()->version()->full());
        $this->assertSame($device->name(), "Android");
    }
}
