<?php
/** * Check PHP version.
 */
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Midtrans needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Midtrans needs the JSON PHP extension.');
}

// Configurations & Midtrans API Resources (Menggunakan absolute path agar aman)
require_once dirname(__FILE__) . '/Midtrans/Config.php';
require_once dirname(__FILE__) . '/Midtrans/Transaction.php';
require_once dirname(__FILE__) . '/Midtrans/ApiRequestor.php';
require_once dirname(__FILE__) . '/Midtrans/Notification.php';
require_once dirname(__FILE__) . '/Midtrans/CoreApi.php';
require_once dirname(__FILE__) . '/Midtrans/Snap.php';
require_once dirname(__FILE__) . '/Midtrans/Sanitizer.php';

// =========================================================================
// KONFIGURASI API KEY MIDTRANS SANDBOX
// =========================================================================
\Midtrans\Config::$serverKey = 'Mid-server-UqYnyd6IXBhHcEx0Kam5NaDz';
\Midtrans\Config::$clientKey = 'Mid-client-ZAH23nQTyOltvYnK';

// Set ke false karena masih menggunakan mode simulasi/pengujian (Sandbox)
\Midtrans\Config::$isProduction = false;

// Aktifkan sanitasi otomatis untuk data transaksi agar inputan aman
\Midtrans\Config::$isSanitized = true;

// Aktifkan 3-D Secure untuk transaksi kartu kredit
\Midtrans\Config::$is3ds = true;