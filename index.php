<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Parse input JSON
    $input = json_decode(file_get_contents('php://input'), true);
    $testType = $input['testType'] ?? 'math';
    $iterations = intval($input['iterations'] ?? 1000);

    // Benchmark logic
    $startTime = microtime(true);
    $resultHash = '';

    switch ($testType) {
        case 'math':
            $result = 0;
            for ($i = 0; $i < $iterations; $i++) {
                $result += sqrt($i) * log($i + 1);
            }
            $resultHash = md5($result);
            break;

        case 'string':
            $string = '';
            for ($i = 0; $i < $iterations; $i++) {
                $string .= chr(($i % 26) + 65);
            }
            $resultHash = md5($string);
            break;

        case 'array':
            $array = [];
            for ($i = 0; $i < $iterations; $i++) {
                $array[] = $i * $i;
            }
            $resultHash = md5(json_encode($array));
            break;

        default:
            echo json_encode(['error' => 'Invalid test type']);
            exit;
    }

    $executionTime = microtime(true) - $startTime;

    // Return response
    echo json_encode([
        'executionTime' => $executionTime,
        'iterations' => $iterations,
        'resultHash' => $resultHash
    ]);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
}
