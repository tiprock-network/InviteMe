<?php
require_once 'vendor/autoload.php'; // Composer autoloader

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$url = 'https://e1m442.api.infobip.com/sms/2/text/advanced';
$api_key = '0a1a33bcc5de12d5b11b8a3718119767-74c17902-2a25-4e58-b9f3-c38e5ab365d5'; // replace with your actual API key
$phone_numbers = ['254758885970']; // replace with the desired phone numbers

$client = new Client();

try {
    $response = $client->post($url, [
        'headers' => [
            'Authorization' => 'App ' . $api_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'messages' => array_map(function ($number) {
                return [
                    'destinations' => [
                        ['to' => $number],
                    ],
                    'from' => 'Invite Me',
                    'text' => 'Hello, This is a reminder that API Day starts in 2 hours.',
                ];
            }, $phone_numbers),
        ],
    ]);

    if ($response->getStatusCode() == 200) {
        // REPLACE WITH MESSAGE after all have been sent use a counter
        echo $response->getBody();
    } else {
        echo 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
    }
} catch (RequestException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
