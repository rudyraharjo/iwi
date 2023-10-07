<?php

class DataFetcher
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function fetchData()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}

$url = 'http://jsonplaceholder.typicode.com/users';
$dataFetcher = new DataFetcher($url);
$response = $dataFetcher->fetchData();

$users = json_decode($response, true);

if ($users && count($users) > 0) {
    foreach ($users as $user) {
        echo "<pre>";
        echo "Name: {$user['name']}, Email: {$user['email']}\n";
    }
}
