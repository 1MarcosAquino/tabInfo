<?php

include __DIR__ . '/../../src/database.php';
include __DIR__ . '/../../src/response.php';

if ($method === 'POST') {
    function registerUser($name, $pass, $contact)
    {
        $conn = connectDatabase('tabinfo', 'root', '');

        try {
            $stmt = $conn->prepare('INSERT INTO users (name, pass, contact) VALUES (:name, :pass, :contact)');
            $stmt->execute([
                ':name' => $name,
                ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                ':contact' => $contact,
            ]);
            response(201, ["email" => "$contact"]);
        } catch (PDOException $e) {

            response($e->getCode(), $e->getMessage());
        }
    }
    $data =  json_decode((file_get_contents("php://input")));

    registerUser($data->name, $data->pass, $data->contact);
}
