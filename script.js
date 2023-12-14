document.addEventListener('DOMContentLoaded', function() {
    const uniqueId = Math.random().toString(36).substr(2, 9);
    const outputDiv = document.getElementById('output');
    let pollingInterval; // Define pollingInterval in a broader scope

    function pollServer() {
        fetch('poll.php?id=' + uniqueId)
            .then(response => response.text())
            .then(data => {
                if (data.indexOf("END_OF_FILE") !== -1) {
                    clearInterval(pollingInterval); // Now it can access pollingInterval
                    outputDiv.innerHTML = data.replace("END_OF_FILE", "");
                    outputDiv.innerHTML += "<p><b>Execution complete</b></p>";
                } else {
                    outputDiv.innerHTML = data;
                }
            });
    }

    // Start the Bash script and polling
    fetch('start.php?id=' + uniqueId)
        .then(response => {
			outputDiv.innerHTML = "<p>Starting remote server process...</p>";
            if (response.ok) {
                pollingInterval = setInterval(pollServer, 1000);
            } else {
                console.error('Error starting script');
            }
        });
});

