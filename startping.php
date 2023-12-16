<pre>
<?php
if (isset($_SERVER['HTTP_X_REAL_IP'])) {
  $user_ip = $_SERVER['HTTP_X_REAL_IP'];
} else {
  $user_ip = $_SERVER['REMOTE_ADDR'];
}
$uniqueId = $_GET['id'] ?? '';
$command = "./runping.sh " . escapeshellarg($uniqueId) . " " . escapeshellarg($user_ip) . " > /dev/null 2>&1 &";
echo("Starting server command: " . $command . "\n");
exec($command);
echo("Done.\n");
?>
</pre>
