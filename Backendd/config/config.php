<?php
require_once 'database.php';

// JWT Secret Key
define('JWT_SECRET', 'your_secret_key_here');
define('JWT_ISSUER', 'absensi_api');
define('JWT_AUD', 'absensi_app');

// CORS Configuration
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Timezone
date_default_timezone_set('Asia/Jakarta');
?>