Document.addEventListener('DOMContentLoaded', function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "runscript.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            var lines = xhr.responseText.split("\n");
            for (var i = 0; i < lines.length; i++) {
                if (lines[i]) {
                    var table = document.getElementById('outputTable');
                    var newRow = table.insertRow(-1);
                    var newCell = newRow.insertCell(0);
                    newCell.textContent = lines[i];
                }
            }
        }
    };

    xhr.send();
});

