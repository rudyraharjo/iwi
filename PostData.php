<?php
class PostData
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function createUser($name, $email)
    {
        try {
            $data = json_encode(array(
                'name' => $name,
                'email' => $email
            ));

            $ch = curl_init($this->url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode != 200) {
                throw new Exception("Error: Unexpected HTTP status code - $httpCode");
            }

            curl_close($ch);

            return json_encode(array('message' => 'User created successfully', 'response' => $response));
        } catch (Exception $e) {
            http_response_code(500); // Atur kode status HTTP ke 500 (Internal Server Error)
            return json_encode(array('error' => $e->getMessage()));
        }
    }
}

$apiUrl = 'https://api.example.com/create-user';
$postData = new PostData($apiUrl);

try {
    $name = $_POST['name'] ?? "Rudy Raharjo";
    $email = $_POST['email'] ?? "rraharjo.rudy@gmail.com";
    $response = $postData->createUser($name, $email);
    echo $response;
} catch (Exception $e) {
    echo $e->getMessage();
}
