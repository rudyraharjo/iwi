<?php

class FileManager
{
    public function createFile($filename)
    {
        if (file_exists($filename)) {
            throw new Exception("File already exists.");
        } else {
            $file = fopen($filename, 'w');
            fclose($file);
            echo "File '$filename' successfully created.";
        }
    }
}

$fileManager = new FileManager();

try {
    $fileManager->createFile('example.txt'); // Ganti dengan nama file yang Anda inginkan
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
