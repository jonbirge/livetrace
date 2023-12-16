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
    <link rel="stylesheet" type="text/css" href="styles.css?version=0.7">
    <title>Trace from server</title>

    <script>
        function runPing() {
        const uniqueId = Math.random().toString(36).substr(2, 9);
        const pingDiv = document.getElementById('ping');
        const runButton = document.getElementById('run-button');
        let pingPollInterval;

        function pollPingServer() {
            fetch('pollping.php?id=' + uniqueId)
                .then(response => response.text())
                .then(data => {
                    if (data.indexOf("END_OF_FILE") !== -1) {
                        clearInterval(pingPollInterval);
                        pingDiv.innerHTML = data;
                        fetch('cleanping.php?id=' + uniqueId);
                        pingDiv.innerHTML += "<p><button class='modern-button' onclick='runPing()'>Run ping again</button></p>";
                    } else {
                        pingDiv.innerHTML = data;
                    }
                });
        }

        // Start the ping bash script and polling
        fetch('startping.php?id=' + uniqueId)
            .then(response => {
                pingDiv.innerHTML = "<p><b>Starting ping...</b></p>";
                if (response.ok) {
                    pingPollInterval = setInterval(pollPingServer, 1000);
                } else {
                    pingDiv.innerHTML = '<p>Error starting ping script</p>';
                }
            });
        };

        function runTrace() {
        const uniqueId = Math.random().toString(36).substr(2, 9);
        const traceDiv = document.getElementById('trace');
        const runButton = document.getElementById('trace-button');
        let tracePollInterval;

        function pollTraceServer() {
            fetch('polltrace.php?id=' + uniqueId)
                .then(response => response.text())
                .then(data => {
                    if (data.indexOf("END_OF_FILE") !== -1) {
                        clearInterval(tracePollInterval);
                        traceDiv.innerHTML = data;
                        fetch('cleantrace.php?id=' + uniqueId);
                        traceDiv.innerHTML += "<p><button class='modern-button' onclick='runTrace()'>Run trace again</button></p>";
                    } else {
                        traceDiv.innerHTML = data;
                    }
                });
        }

        // Start the ping bash script and polling
        fetch('starttrace.php?id=' + uniqueId)
            .then(response => {
                traceDiv.innerHTML = "<p><b>Starting traceroute...</b></p>";
                if (response.ok) {
                    tracePollInterval = setInterval(pollTraceServer, 1000);
                } else {
                    traceDiv.innerHTML = '<p>Error starting traceroute</p>';
                }
            });
        };

        function runAll()
        {
            runPing();
            runTrace();
        }
    </script>

</head>

<body>
<div class="container">
    <h1>Network info</h1>
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
        <button class="modern-button" onclick="runAll()">Run all...</button>
    </div>
    <h2>ping</h2>
    <div id="ping">
        <button class="modern-button" onclick="runPing()">Run ping test</button>
    </div>
    <h2>traceroute</h2>
    <div id="trace">
        <button class="modern-button" onclick="runTrace()">Run traceroute</button>
    </div>
</div>
</body>
</html>
