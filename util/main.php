<?php
// Get the document root
$doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$doc_root = preg_replace('/\x00|<[^>]*>?/', '', $doc_root);
$doc_root = str_replace(["'", '"'], ['&#39;', '&#34;'], $doc_root);

// Get the application path
$uri = filter_input(INPUT_SERVER, 'REQUEST_URI');

$uri = preg_replace('/\x00|<[^>]*>?/', '', $uri);
$uri = str_replace(["'", '"'], ['&#39;', '&#34;'], $uri);
$dirs = explode('/', $uri);
$app_path = '/' . $dirs[1] . '/' . $dirs[2] . '/' . $dirs[3] . '/';

// Set the include path
set_include_path($doc_root . $app_path);

// Get common code
require_once('util/tags.php');
require_once('model/database.php');
require_once('util/secure_conn.php'); // require secure connection for all pages

// Define some common functions
function display_error($error_message) {
    global $app_path;
    include 'errors/error.php';
    exit();
}

function redirect($url) {
    session_write_close();
    header("Location: " . $url);
    exit();
}

// Start session to store user and cart data
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
