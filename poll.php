<?php

$uniqueId = $_GET['id'] ?? '';
$tempFile = "/tmp/test_output_" . $uniqueId . ".txt";
$lockFile = "/tmp/test_output_" . $uniqueId . ".lock";

// Check for the existence of the lock file
if (!file_exists($lockFile)) {
    echo "<!-- END_OF_FILE -->";
}

// Check if the text file exists
if (file_exists($tempFile)) {
    // Start the HTML table
    echo "<table>";

    echo "<tr><td>";
    $lines = file($tempFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (count($lines) >= 2) {
        $lastLine = $lines[count($lines) - 1];
        echo $lastLine;
    } else {
        echo "Waiting...";
    }
    echo "</td></tr>";

    // Close the HTML table
    echo "</table>";
}

?>
