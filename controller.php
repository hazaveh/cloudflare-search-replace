<?php
/**
 * Developed by: Mahdi Hazaveh <mahdi@hazaveh.net>
 * Date: 8/19/16
 * Time: 11:34 AM
 */
ini_set("memory_limit", "-1");
set_time_limit(0);

require_once 'includes.php';
use Cocur\BackgroundProcess\BackgroundProcess;

// Initiation of the class.
$cloudflare = new CloudFlareController(EMAIL,API_KEY);

// Dry run

if (isset($_REQUEST['dry-run']) && $_REQUEST['dry-run'] == 1) {
    if (isset($_REQUEST['originalIP']) && isset($_REQUEST['newIP'])) {
        $cloudflare->getDNS($cloudflare->zones, $_REQUEST['originalIP'], $_REQUEST['newIP']);
    }
}

if (isset($_REQUEST['live-run']) && $_REQUEST['live-run'] == 1) {
    if (isset($_REQUEST['originalIP']) && isset($_REQUEST['newIP'])) {

        $controller = new BackgroundProcess($cloudflare->doReplace($cloudflare->zones, $_REQUEST['originalIP'], $_REQUEST['newIP'], getcwd()));
        $controller->run();
            header('Content-Type: application/json');
            echo json_encode(['result' => 'success']);

    }
}