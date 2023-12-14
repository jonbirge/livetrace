document.addEventListener('DOMContentLoaded', function() {
    const uniqueId = Math.random().toString(36).substr(2, 9);
    const pingDiv = document.getElementById('ping');
    let pollingInterval; // Define pollingInterval in a broader scope

    function pollServer() {
        fetch('poll.php?id=' + uniqueId)
            .then(response => response.text())
            .then(data => {
                if (data.indexOf("END_OF_FILE") !== -1) {
                    clearInterval(pollingInterval); // Now it can access pollingInterval
                    pingDiv.innerHTML = data.replace("END_OF_FILE", "");
                    pingDiv.innerHTML += "<p><b>Execution complete</b></p>";
                } else {
                    pingDiv.innerHTML = data;
                }
            });
    }

    // Start the Bash script and polling
    fetch('start.php?id=' + uniqueId)
        .then(response => {
			pingDiv.innerHTML = "<p>Starting ping process...</p>";
            if (response.ok) {
                pollingInterval = setInterval(pollServer, 1000);
            } else {
                console.error('Error starting ping script...');
            }
        });
});
