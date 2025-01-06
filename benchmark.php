<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST["task"];
    $iterations = intval($_POST["iterations"]);

    // Ensure valid input
    if ($iterations < 1) {
        die("Iterations must be greater than zero.");
    }

    // Benchmark function
    function benchmarkTask($task, $iterations) {
        $startTime = microtime(true);

        switch ($task) {
            case "loop":
                for ($i = 0; $i < $iterations; $i++) {
                    // Simple loop task
                }
                break;

            case "sorting":
                $array = range(1, $iterations);
                shuffle($array);
                // Bubble sort (inefficient, but useful for testing)
                for ($i = 0; $i < count($array); $i++) {
                    for ($j = 0; $j < count($array) - $i - 1; $j++) {
                        if ($array[$j] > $array[$j + 1]) {
                            $temp = $array[$j];
                            $array[$j] = $array[$j + 1];
                            $array[$j + 1] = $temp;
                        }
                    }
                }
                break;

            case "matrix":
                $matrixA = array_fill(0, $iterations, array_fill(0, $iterations, rand(1, 10)));
                $matrixB = array_fill(0, $iterations, array_fill(0, $iterations, rand(1, 10)));
                $resultMatrix = array();

                for ($i = 0; $i < $iterations; $i++) {
                    for ($j = 0; $j < $iterations; $j++) {
                        $sum = 0;
                        for ($k = 0; $k < $iterations; $k++) {
                            $sum += $matrixA[$i][$k] * $matrixB[$k][$j];
                        }
                        $resultMatrix[$i][$j] = $sum;
                    }
                }
                break;

            default:
                die("Invalid task selected.");
        }

        $endTime = microtime(true);
        return $endTime - $startTime;
    }

    // Run the benchmark and display the result
    $executionTime = benchmarkTask($task, $iterations);

    echo "<div style='text-align: center; padding: 20px;'>";
    echo "<h1>Benchmark Result</h1>";
    echo "<p>Task: <strong>$task</strong></p>";
    echo "<p>Iterations: <strong>$iterations</strong></p>";
    echo "<p>Execution Time: <strong>" . number_format($executionTime, 6) . " seconds</strong></p>";
    echo "<a href='index.html'>Run Another Benchmark</a>";
    echo "</div>";
} else {
    die("Invalid request method.");
}
?>
