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

    // Read each line of the text file
    while (!feof($handle)) {
        $line = trim(fgets($handle));

        // Skip empty lines
        if ($line != '')
        {
            echo "<tr>";
            $parts = explode(' ', $line, 2);
            echo "<td>" . htmlspecialchars($parts[0]) . "</td>";
            echo "<td>" . htmlspecialchars($parts[1]) . "</td>";
            echo "</tr>";
        }
    }

    // Close the HTML table
    echo "</table>";

    // Close the file handle
    fclose($handle);
}

?>
