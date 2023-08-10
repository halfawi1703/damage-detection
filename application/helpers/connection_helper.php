<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function api_host($environment = 'production')
{
    $CI = get_instance();

    $host = $CI->config->item('api_host');

    return $host;
}

function api_request($method, $path, $payload = [])
{
    $headers = [];
    if(isset($_COOKIE['_alt_session'])) {
        $headers[] = 'Authorization: Bearer ' . $_COOKIE['_alt_session'];
    }

    $url = api_host() . $path;

    if ($method == 'GET') {
        if ($payload) {
            $query = '?' . http_build_query($payload);
            $url .= $query;
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : ""));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method == 'POST') {
        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }
    } elseif ($method == 'PUT') {
        if ($payload) {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        }
    }

    $response = curl_exec($ch);
    $error = curl_error($ch);

    $output = json_decode($response);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // http_response_code($httpcode);

    curl_close($ch);

    if (@$output->error->code == '1005') {
        http_response_code($httpcode);
    }

    return $output;
}
