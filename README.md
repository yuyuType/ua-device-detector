デバイスの取得

```php
$device = Data\Device\Detector::makeDeviceFromUserAgent();
```

OS情報の取得

```php
$os = $device->OS();
```

OS名の取得

```php
$osName = $device->name(); // iPhone, iPad, Android...etc
```
or

```php
$osName = $os->name(); // iPhone, iPad, Android...etc
```

OSバージョン情報の取得

```php
$version = $os->version();
```

OSフルバージョンの取得

```php
// if iOS
$fullVersion = $version->full(); // 8_0_1

// if Android
$fullVersion = $version->full(); // 4.0.4
```

OSメジャーバージョン情報の取得

```php
// if iOS
$majorVersion = $version->major(); // 8

// if Android
$majorVersion = $version->major(); // 4
```

ダブレットかの判定

```php
// if Tablet
$isTablet = $device->isTablet(); // true

// if Not Tablet
$isTablet = $device->isTablet(); // false
```

どのデバイスかの判定

```php
// if iPhone, iPod, iPad
Data\Device\Detector::isiOS($device); // true

// if Not iPhone, iPod, iPad
Data\Device\Detector::isiOS($device); // false
```
判定メソッド一覧

```php
    public static function isAndroid(Device $device)
    public static function isKindle(Device $device)
    public static function isBlackBerry(Device $device)
    public static function isBB10(Device $device)
    public static function isPlayBook(Device $device)
    public static function isWindowsPhone(Device $device)
    public static function isPC(Device $device)
    public static function isMacintosh(Device $device)
    public static function isWindows(Device $device)
    public static function isiOS(Device $device)
    public static function isiPhone(Device $device)
    public static function isiPad(Device $device)
    public static function isiPod(Device $device)
    public static function isSmartPhone(Device $device)
    public static function isMobile(Device $device)
    public static function isTablet(Device $device)
```
