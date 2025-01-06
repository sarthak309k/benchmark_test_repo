<?php
// network_benchmark.php

function fibonacci($n) {
    if ($n <= 1) return $n;
    return fibonacci($n - 1) + fibonacci($n - 2);
}

function isPrime($n) {
    if ($n <= 1) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

function simpleLoop($iterations) {
    $sum = 0;
    for ($i = 0; $i < $iterations; $i++) {
        $sum += $i;
    }
    return $sum;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $operation = $data['operation'] ?? 'loop';
    $iterations = intval($data['iterations'] ?? 1000);

    $start_time = microtime(true);

    switch ($operation) {
        case 'fibonacci':
            for ($i = 0; $i < $iterations; $i++) {
                fibonacci(10); // Calculate Fibonacci(10) repeatedly
            }
            break;

        case 'prime_check':
            for ($i = 1; $i <= $iterations; $i++) {
                isPrime($i); // Check if numbers up to iterations are prime
            }
            break;

        case 'loop':
        default:
            simpleLoop($iterations); // Run a simple loop
            break;
    }

    $end_time = microtime(true);
    $processing_time = round(($end_time - $start_time) * 1000, 2);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'operation' => $operation,
        'iterations' => $iterations,
        'processing_time' => $processing_time,
    ]);
    exit;
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are supported.',
    ]);
    exit;
}
?>
