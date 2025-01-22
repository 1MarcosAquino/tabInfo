<?php

include '../database.php';
include '../response.php';

if ($method === 'POST') {

    function listUsers($contact)
    {
        $con = connectDatabase('your_database_name', 'root', '');

        try {
            $stmt = $con->prepare('SELECT contact FROM users WHERE contact = :contact');

            $stmt->bindParam(':contact', $contact, PDO::PARAM_INT);

            $stmt->execute();

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                response(200, $user);
            } else {
                response(404, "Nenhum produto encontrado com esse ID.");
            }

            echo json_encode($users);
        } catch (PDOException $e) {
            echo "Erro ao listar usuários: " . $e->getMessage();
        }
    }
}
