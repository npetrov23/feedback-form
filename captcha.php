<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Captcha;

$captcha = new Captcha();
$captcha->generate();

error_log('CAPTCHA SESSION: ' . session_id());
error_log('CAPTCHA CODE: ' . ($_SESSION['captcha'] ?? 'NULL'));