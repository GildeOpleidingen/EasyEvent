<?php

require_once __DIR__ . '/../src/Conn.php';

function checkRateLimit(PDO $pdo, string $ip, string $email = '', int $limit = 5, int $window = 900, string $message = "Too many attempts. Please try again later.") {
    $now = time();

    // oude entries weg
    $cleanup = $pdo->prepare("DELETE FROM rate_limit_attempts WHERE request_time < ?");
    $cleanup->execute([$now - $window]);

    // tellen proberen
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM rate_limit_attempts WHERE ip=? AND request_time > ?");
    $stmt->execute([$ip, $now - $window]);
    $ipCount = (int)$stmt->fetchColumn();

    $emailCount = 0;
    if ($email !== '') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rate_limit_attempts WHERE email=? AND request_time > ?");
        $stmt->execute([$email, $now - $window]);
        $emailCount = (int)$stmt->fetchColumn();
    }


    if ($ipCount >= $limit || $emailCount >= $limit) {
        http_response_code(429);
        die($message);
    }

    // Login
    $stmt = $pdo->prepare("INSERT INTO rate_limit_attempts (ip, email, request_time) VALUES (?, ?, ?)");
    $stmt->execute([$ip, $email, $now]);
}
