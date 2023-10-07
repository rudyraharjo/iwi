<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function registerUser($username, $password)
    {
        $salt = $this->generateSalt();
        $hashedPassword = $this->hashPassword($password, $salt);

        $stmt = $this->db->prepare("INSERT INTO users (username, password, salt) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashedPassword, $salt);
        if ($stmt->execute()) {
            $stmt->close();
            return json_encode(array('message' => 'Registration successful'));
        } else {
            $stmt->close();
            return json_encode(array('error' => 'Registration failed'));
        }
    }

    public function loginUser($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            $salt = $row['salt'];

            if ($this->verifyPassword($password, $hashedPassword, $salt)) {
                return json_encode(array('message' => 'Login successful'));
            }
        }

        return json_encode(array('error' => 'Login failed'));
    }

    private function generateSalt()
    {
        return bin2hex(random_bytes(16));
    }

    private function hashPassword($password, $salt)
    {
        return hash('sha256', $password . $salt); // result hash from password + salt
    }

    private function verifyPassword($password, $hashedPassword, $salt)
    {
        return $hashedPassword === $this->hashPassword($password, $salt);
    }
}

$db = new mysqli('localhost', 'username', 'password', 'database_name');
$userAuth = new User($db);

// User Registration
$responseRegister = $userAuth->registerUser('rraharjo', 'Password*1!');
echo $responseRegister;

// USer Singin
$responseLogin = $userAuth->loginUser('rraharjo', 'Password*1!');
echo $responseLogin;

$db->close();
