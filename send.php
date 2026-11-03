<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\FormService;
use App\FormValidator;
use App\MailSender;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$handler = new FormService(
    new FormValidator(),
    new MailSender()
);

$result = $handler->handle($_POST);

if (!$result['success']) {
    $http_code = 500;

    if(isset($result['errors'])) {
        $http_code = 422;
    }

    http_response_code($http_code);
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);