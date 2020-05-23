<?php
/* Enable cors starts */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    die("");
}
/* Enable cors end */
define('ROOT', __DIR__ . '/../');
require(ROOT . 'bootstrap.php');
$bootstrap = new Bootstrap();
$bootstrap->run();
?>