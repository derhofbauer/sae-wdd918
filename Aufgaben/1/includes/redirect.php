<?php
/**
 * Starte eine Session
 */
session_start();

/**
 * Definiere die Liste an Links
 */
$links = [
    "google" => "http://google.com",
    "sae" => "http://sae.edu",
    "nasa" => "http://nasa.gov",
    "orf" => "http://orf.at"
];

if (isset($_GET['url']) && isset($_GET['page']) && $_GET['page'] === 'links') {
    $url = urldecode($_GET['url']);

    if (in_array($url, $links)) {
        if (array_key_exists($url, $_SESSION['links'])) {
            $_SESSION['links'][$url]++;
        } else {
            $_SESSION['links'][$url] = 1;
        }
        if (!isset($_GET['html_redirect']) || $_GET['html_redirect'] != 'true') {
            header("Location: $url");
            exit;
        }
    }
}

?>