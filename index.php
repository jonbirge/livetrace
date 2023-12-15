<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Trace from server</title>

    <script>
    function runPing() {
    const uniqueId = Math.random().toString(36).substr(2, 9);
    const pingDiv = document.getElementById('ping');
    let pollingInterval; // Define pollingInterval in a broader scope

    function pollServer() {
        fetch('poll.php?id=' + uniqueId)
            .then(response => response.text())
            .then(data => {
                if (data.indexOf("END_OF_FILE") !== -1) {
                    clearInterval(pollingInterval);
                    pingDiv.innerHTML = data;
                    fetch('cleanup.php?id=' + uniqueId);
                    pingDiv.innerHTML += "<p><b>Ping complete</b></p>";
                } else {
                    pingDiv.innerHTML = data;
                }
            });
    }

    // Start the Bash script and polling
    fetch('start.php?id=' + uniqueId)
        .then(response => {
            pingDiv.innerHTML = "<p>Starting ping...</p>";
            if (response.ok) {
                pollingInterval = setInterval(pollServer, 1000);
            } else {
                pingDiv.innerHTML = '<p>Error starting ping script</p>';
            }
        });
    };
    </script>

</head>

<body>
<div class="container">
    <h1>Server-side ping</h1>
    <div>
        <table>
            <tr>
                <td>Server time</td>
                <td>
                    <?php echo shell_exec('date'); ?>
                </td>
            </tr>
            <tr>
                <td>Host name</td>
                <td>
                    <?php
                    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } else {
                        $user_ip = $_SERVER['REMOTE_ADDR'];
                    }
                    $host_name = gethostbyaddr($user_ip);
                    if ($host_name == $user_ip) {
                        echo "No host name"; }
                    else {
                        echo $host_name; }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Host IP</td>
                <td>
                    <?php
                    echo $user_ip;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div id="ping">
    <button class="modern-button" onclick="runPing()">Run ping</button>
    </div>
</div>
</body>
</html>
