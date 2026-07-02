<?php
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Midtrans needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Midtrans needs the JSON PHP extension.');
}

require_once dirname(__FILE__) . '/Midtrans/Config.php';
require_once dirname(__FILE__) . '/Midtrans/Transaction.php';
require_once dirname(__FILE__) . '/Midtrans/ApiRequestor.php';
require_once dirname(__FILE__) . '/Midtrans/Notification.php';
require_once dirname(__FILE__) . '/Midtrans/CoreApi.php';
require_once dirname(__FILE__) . '/Midtrans/Snap.php';
require_once dirname(__FILE__) . '/Midtrans/Sanitizer.php';

\Midtrans\Config::$serverKey = 'Mid-server-UqYnyd6IXBhHcEx0Kam5NaDz';
\Midtrans\Config::$clientKey = 'Mid-client-ZAH23nQTyOltvYnK';

\Midtrans\Config::$isProduction = false;

\Midtrans\Config::$isSanitized = true;

\Midtrans\Config::$is3ds = true;