<?php
$uniqueId = $_GET['id'] ?? '';
$tempFile = "/tmp/test_output_" . $uniqueId . ".txt";
$lockFile = "/tmp/test_output_" . $uniqueId . ".lock";

// Read and return the file contents
if (file_exists($tempFile)) {
    echo nl2br(file_get_contents($tempFile));
}

// Check for the existence of the lock file
if (!file_exists($lockFile)) {
    echo "END_OF_SCRIPT"; // Or any unique identifier
}
?>

