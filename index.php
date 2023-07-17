<?php
/*
 * Plugin Name:       GC WP Enable Cors
 * Plugin URI:        https://gabecode.com
 * Description:       A simple Plugin that enables the CORS for React Front End Apps
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gabriel Coronado
 * Author URI:        https://gabecode.com
 * Text Domain:       gc-corswp
 * Domain Path:       /languages
 */



function glasseCorsEnable()
{
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, X-WP-Nonce, Content-Type, Accept, Authorization');
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

    if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
        status_header(200);
        exit();
    }
}

add_filter('rest_authentication_errors', 'rest_filter_incoming_connections');
function rest_filter_incoming_connections($errors)
{
    $request_server = $_SERVER['REMOTE_ADDR'];
    $origin = get_http_origin();
    if ($origin !== 'http://localhost:3000') return new WP_Error('forbidden_access', $origin, array(
        'status' => 403
    ));
    return $errors;
}

add_action('init', 'glasseCorsEnable');
