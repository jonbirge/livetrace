document.addEventListener('DOMContentLoaded', function() {
    const uniqueId = Math.random().toString(36).substr(2, 9);
    const outputDiv = document.getElementById('output');
    let pollingInterval; // Define pollingInterval in a broader scope

    function pollServer() {
        fetch('polling.php?id=' + uniqueId)
            .then(response => response.text())
            .then(data => {
                if (data.indexOf("END_OF_SCRIPT") !== -1) {
                    clearInterval(pollingInterval); // Now it can access pollingInterval
                    outputDiv.innerHTML = data.replace("END_OF_SCRIPT", "");
                    outputDiv.innerHTML += "<p>Script execution complete.</p>";
                } else {
                    outputDiv.innerHTML = data;
                }
            });
    }

    // Start the Bash script and polling
    fetch('startscript.php?id=' + uniqueId)
        .then(response => {
            if (response.ok) {
                pollingInterval = setInterval(pollServer, 1000);
            } else {
                console.error('Error starting script');
            }
        });
});

