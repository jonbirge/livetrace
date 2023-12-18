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
<link rel="stylesheet" type="text/css" href="styles.css?version=0.8">
<title>Trace from server</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Loading Chart.js from CDN -->
<script>
    function runPing()
    {
        const uniqueId = Math.random().toString(36).substr(2, 9);
        const pingDiv = document.getElementById('ping-button');
        const pingCanvas = document.getElementById('ping-chart');
        const runButton = document.getElementById('run-button');
        let pingPollInterval;

        // Add canvas to page
        pingCanvas.innerHTML = '<canvas id="pingChart" width="320" height="180"></canvas>';
        var ctx = document.getElementById('pingChart').getContext('2d');
        var pingChart = new Chart(ctx, {
            type: 'line', // You can change this to 'bar' if you prefer a bar chart
            data: {
                labels: [], // Empty labels
                datasets: [{
                    label: 'Ping Time (ms)',
                    data: [], // Empty data
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function pollPingServer()
        {
            fetch('pollping.php?id=' + uniqueId)
                .then(response => response.text())
                .then(data => {
                    // Parsing JSON data
                    var pingData = JSON.parse(data);
                    var pingDone = false;

                    // Check to see if the last element is -1, and if it is, remove it
                    if (pingData[pingData.length - 1] === -1)
                    {
                        pingData.pop();
                        pingDone = true;
                        console.log("Ping done!");
                    }

                    // Preparing labels for each data point (assuming sequential labels)
                    var labels = pingData.map((_, index) => `Ping ${index + 1}`);

                    // Updating chart with new data
                    pingChart.data.labels = labels;
                    pingChart.data.datasets[0].data = pingData;
                    pingChart.update();

                    if (pingDone)
                    {
                        clearInterval(pingPollInterval);
                        fetch('cleanping.php?id=' + uniqueId);
                        pingDiv.innerHTML = "<p><button class='modern-button' onclick='runPing()'>Run ping again</button></p>";
                    }
                });
        }

        fetch('startping.php?id=' + uniqueId)
            .then(response => {
                pingDiv.innerHTML = "<p>Running ping...</p>";
                if (response.ok) {
                    pingPollInterval = setInterval(pollPingServer, 1000);
                } else {
                    pingDiv.innerHTML = '<p>Error starting ping script!</p>';
                }
            });
    }

    function runTrace()
    {
        const uniqueId = Math.random().toString(36).substr(2, 9);
        const traceDiv = document.getElementById('trace');
        const runButton = document.getElementById('trace-button');
        let tracePollInterval;

        function pollTraceServer()
        {
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

        fetch('starttrace.php?id=' + uniqueId)
            .then(response => {
                traceDiv.innerHTML = "<p>Starting traceroute...</p>";
                if (response.ok) {
                    tracePollInterval = setInterval(pollTraceServer, 1000);
                } else {
                    traceDiv.innerHTML = '<p>Error starting traceroute</p>';
                }
            });
    }

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
                <td>Client address</td>
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
                <td>Client IP</td>
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
    <div id="ping-button">
        <button class="modern-button" onclick="runPing()">Run ping test</button>
    </div>
    <div id="ping-chart" style="width: 600px; margin-left: 0; margin-right: auto;">
        <!-- This is where the chart will go -->
    </div>
    <h2>traceroute</h2>
    <div id="trace">
        <button class="modern-button" onclick="runTrace()">Run traceroute</button>
    </div>
</div>
</body>

</html>
