<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function gen_id()
{
    $output = substr((float) microtime() * 1000000 . rand(10001,99999), 0, 10);

    return (int) $output;
}

function gen_uuid() {
    $uuid = sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );

    return $uuid;
}

function hash_password($password)
{
    $secret_key = 'kms#!';

    $output = hash('sha256', $secret_key . $password);

    return $output;
}

function gen_otp($n = 6)
{

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $output = "";

    for ($i = 1; $i <= $n; $i++) {
        $output .= substr($generator, (rand()%(strlen($generator))), 1);
    }

    // Return result
    return $output;
}

function random_password()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = []; //remember to declare $pass as an array
    $alpha_length = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alpha_length);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

function xml_to_array($xml_object)
{
    $xml = simplexml_load_string($xml_object, "SimpleXMLElement", LIBXML_NOCDATA);

    $arr = [];
    $output = json_decode(json_encode(simplexml_load_string($xml)), true);

    return $output;
}

function parse_headers(array $headers, $header = null)
{
    $output = array();

    if ('HTTP' === substr($headers[0], 0, 4)) {
        list(, $output['status'], $output['status_text']) = explode(' ', $headers[0]);
        unset($headers[0]);
    }

    foreach ($headers as $v) {
        $h = preg_split('/:\s*/', $v);
        $output[$h[0]] = $h[1];
    }

    if (null !== $header) {
        if (isset($output[strtolower($header)])) {
            return $output[strtolower($header)];
        }

        return;
    }

    return $output;
}

function number_to_roman($number)
{
    $map = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    ];

    $output = '';

    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $output .= $roman;
                break;
            }
        }
    }

    return $output;
}


function currency_format($number = '')
{
    $symbol = 'Rp';

    $output = $symbol . number_format($number, 0, ',', '.');

    $output;
}

function get_os() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform  = 'Unknown';

    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    $output = $os_platform;

    return $output;
}

function get_ip_info($field = '')
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json?token=83dbd8b118d5dc"));

    if ($field) {
        $output = $data->$field;
    } else {
        $output = $data;
    }

    return $output;
}
