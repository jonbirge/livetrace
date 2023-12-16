<?php

$uniqueId = $_GET['id'] ?? '';
$tempFile = "/tmp/trace_output_" . $uniqueId . ".txt";
$lockFile = "/tmp/trace_output_" . $uniqueId . ".lock";

// Check for the existence of the lock file
if (!file_exists($lockFile)) {
    echo "<!-- END_OF_FILE -->";
}

// Check if the text file exists
if (file_exists($tempFile)) {
    // Open the file for reading
    $handle = fopen($tempFile, "r");
    
    // Start the HTML table
    echo "<table>";

    // Read each line of the CSV file
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        echo "<tr>";
        foreach ($data as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }

    // Close the HTML table
    echo "</table>";

    // Close the file handle
    fclose($handle);
}

?>
