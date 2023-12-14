<?php
$uniqueId = $_GET['id'] ?? '';
$tempFile = "/tmp/test_output_" . $uniqueId . ".txt";
$lockFile = "/tmp/test_output_" . $uniqueId . ".lock";

// Check if the CSV file exists
if (file_exists($tempFile)) {
    // Open the file for reading
    $handle = fopen($tempFile, "r");
    
    // Start the HTML table
    echo "<table>";

    // Read each line of a CSV file and format into table
    // (Just print everything as one line for now...)
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

// Check for the existence of the lock file
if (!file_exists($lockFile)) {
    echo "END_OF_FILE"; // Or any unique identifier
}
?>

