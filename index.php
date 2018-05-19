<?php

namespace Reddingsmonitor;

try {
    /* Require load */
    require_once 'load.php';

    /* Check if config variable not exists */
    if (empty($config)) {
        header('HTTP/1.0 500 Internal Server Error');
        exit;
    }

    /* Check if global server variable is empty */
    if (empty($_SERVER) || empty($_SERVER['REMOTE_ADDR'])) {
        header('HTTP/1.0 405 Method Not Allowed');
        exit;
    }

    /* Check if remote IP is not allowed */
    $remoteIP = $_SERVER['REMOTE_ADDR'];
    if (!$config->allowIP($remoteIP)) {
        header('HTTP/1.0 405 Method Not Allowed');
        exit;
    }

    /* Create token */
    $token = $auth->createToken();
} catch (\Exception $e) {
    header('HTTP/1.0 500 Internal Server Error');
    exit;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Reddingsmonitor</title>
        <link href="styles/main.css" media="all" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="header">
            <div class="container">
                <div id="logo">Reddings<span>monitor</span></div>
                <div id="darkmode">
                    <div id="lastupdate"></div>
                    <input id="checkbox_darkmode" type="checkbox" value="1" onchange="triggerDarkMode(this.checked)" />
                    <label for="checkbox_darkmode">Dark mode</label>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="map"></div>
            <div id="sidebar"></div>
        </div>
        <script src="<?= $config->createScriptURL($token); ?>"></script>
        <script src="<?= $config->createGoogleMapsURL(); ?>"></script>
    </body>
</html>
