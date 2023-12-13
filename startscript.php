<pre>
<?php
$uniqueId = $_GET['id'] ?? '';
$command = "./test.sh " . escapeshellarg($uniqueId) . " > /dev/null 2>&1 &";
echo("Starting server command: " . $command . "\n");
exec($command);
echo("Done.\n");
?>
</pre>

