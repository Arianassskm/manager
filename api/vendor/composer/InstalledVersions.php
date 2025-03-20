<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;








class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '1.0.0+no-version-set',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => '1.0.0+no-version-set',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'amphp/amp' => 
    array (
      'pretty_version' => 'v2.6.4',
      'version' => '2.6.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ded3d9be08f526089eb7ee8d9f16a9768f9dec2d',
    ),
    'amphp/byte-stream' => 
    array (
      'pretty_version' => 'v1.8.2',
      'version' => '1.8.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '4f0e968ba3798a423730f567b1b50d3441c16ddc',
    ),
    'amphp/file' => 
    array (
      'pretty_version' => 'v2.0.4',
      'version' => '2.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'be639a9b1f579d3fe847ca0dcc17c7a7f5168910',
    ),
    'amphp/parallel' => 
    array (
      'pretty_version' => 'v1.4.3',
      'version' => '1.4.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '3aac213ba7858566fd83d38ccb85b91b2d652cb0',
    ),
    'amphp/parser' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f83e68f03d5b8e8e0365b8792985a7f341c57ae1',
    ),
    'amphp/process' => 
    array (
      'pretty_version' => 'v1.1.9',
      'version' => '1.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '55b837d4f1857b9bd7efb7bb859ae6b0e804f13f',
    ),
    'amphp/serialization' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '693e77b2fb0b266c3c7d622317f881de44ae94a1',
    ),
    'amphp/sync' => 
    array (
      'pretty_version' => 'v1.4.2',
      'version' => '1.4.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '85ab06764f4f36d63b1356b466df6111cf4b89cf',
    ),
    'bacon/bacon-qr-code' => 
    array (
      'pretty_version' => '2.0.8',
      'version' => '2.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => '8674e51bb65af933a5ffaf1c308a660387c35c22',
    ),
    'dasprid/enum' => 
    array (
      'pretty_version' => '1.0.6',
      'version' => '1.0.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '8dfd07c6d2cf31c8da90c53b83c026c7696dda90',
    ),
    'endroid/qr-code' => 
    array (
      'pretty_version' => '3.9.7',
      'version' => '3.9.7.0',
      'aliases' => 
      array (
      ),
      'reference' => '94563d7b3105288e6ac53a67ae720e3669fac1f6',
    ),
    'evenement/evenement' => 
    array (
      'pretty_version' => 'v3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '0a16b0d71ab13284339abb99d9d2bd813640efbc',
    ),
    'fig/http-message-util' => 
    array (
      'pretty_version' => '1.1.5',
      'version' => '1.1.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '9d94dc0154230ac39e5bf89398b324a86f63f765',
    ),
    'khanamiryan/qrcode-detector-decoder' => 
    array (
      'pretty_version' => '1.0.6',
      'version' => '1.0.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '45326fb83a2a375065dbb3a134b5b8a5872da569',
    ),
    'myclabs/php-enum' => 
    array (
      'pretty_version' => '1.8.5',
      'version' => '1.8.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e7be26966b7398204a234f8673fdad5ac6277802',
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.1',
      'version' => '1.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cb6ce4845ce34a8ad9e68117c10ee90a29919eba',
    ),
    'react/cache' => 
    array (
      'pretty_version' => 'v1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd47c472b64aa5608225f47965a484b75c7817d5b',
    ),
    'react/dns' => 
    array (
      'pretty_version' => 'v1.13.0',
      'version' => '1.13.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'eb8ae001b5a455665c89c1df97f6fb682f8fb0f5',
    ),
    'react/event-loop' => 
    array (
      'pretty_version' => 'v1.5.0',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bbe0bd8c51ffc05ee43f1729087ed3bdf7d53354',
    ),
    'react/http' => 
    array (
      'pretty_version' => 'v1.11.0',
      'version' => '1.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8db02de41dcca82037367f67a2d4be365b1c4db9',
    ),
    'react/promise' => 
    array (
      'pretty_version' => 'v3.2.0',
      'version' => '3.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8a164643313c71354582dc850b42b33fa12a4b63',
    ),
    'react/socket' => 
    array (
      'pretty_version' => 'v1.16.0',
      'version' => '1.16.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '23e4ff33ea3e160d2d1f59a0e6050e4b0fb0eac1',
    ),
    'react/stream' => 
    array (
      'pretty_version' => 'v1.4.0',
      'version' => '1.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1e5b0acb8fe55143b5b426817155190eb6f5b18d',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.5.4',
      'version' => '2.5.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '605389f2a7e5625f273b53960dc46aeaf9c62918',
    ),
    'symfony/options-resolver' => 
    array (
      'pretty_version' => 'v5.4.45',
      'version' => '5.4.45.0',
      'aliases' => 
      array (
      ),
      'reference' => '74e5b6f0db3e8589e6cfd5efb317a1fc2bb52fb6',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a3cc8b044a6ea513310cbd48ef7333b384945638',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b9123926e3b7bc2f98c02ad54f6a4b02b91a8abe',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3833d7255cc303546435cb650316bff708a1c75c',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '85181ba99b2345b0ef10ce42ecac37612d9fd341',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f68c03565dcaaf25a890667542e8bd75fe7e5bb',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '60328e362d4c2c802a54fcbf04f9d3fb892b4cf8',
    ),
    'symfony/property-access' => 
    array (
      'pretty_version' => 'v5.4.45',
      'version' => '5.4.45.0',
      'aliases' => 
      array (
      ),
      'reference' => '111e7ed617509f1a9139686055d234aad6e388e0',
    ),
    'symfony/property-info' => 
    array (
      'pretty_version' => 'v5.4.48',
      'version' => '5.4.48.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a0396295ad585f95fccd690bc6a281e5bd303902',
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v5.4.47',
      'version' => '5.4.47.0',
      'aliases' => 
      array (
      ),
      'reference' => '136ca7d72f72b599f2631aca474a4f8e26719799',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}

if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}








public static function getRawData()
{
@trigger_error('getRawData only returns the first dataset loaded, which may not be what you expect. Use getAllRawData() instead which returns all datasets for all autoloaders present in the process.', E_USER_DEPRECATED);

return self::$installed;
}







public static function getAllRawData()
{
return self::getInstalled();
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}





private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
