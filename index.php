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
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <h1>Ping from server</h1>
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
                    // Check if HTTP_X_FORWARDED_FOR is set, if not use REMOTE_ADDR
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
    <div id="ping"></div>
</div>
</body>
</html>
