<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Trace from server</title>
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <h1>Ping from server</h1>
    <div>
        <table>
            <tr>
                <td>Server time:</td>
                <td>
                    <?php echo shell_exec('date'); ?>
                </td>
            </tr>
            <tr>
                <td>Host name:</td>
                <td>
                    <?php
                    $host_name = gethostbyaddr($user_ip);
                    if ($host_name == "") {
                        echo "No host name"; }
                    else {
                        echo $host_name; }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div id="ping"></div>
</div>
</body>
</html>
