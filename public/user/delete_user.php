<?php

include '../../src/database.php';
include '../../src/response.php';

if (strtolower($method) === 'delete') {
    function deleteUser($contact)
    {
        $con = connectDatabase('tabinfo', 'root');

        try {
            $stmt = $con->prepare('DELETE FROM users WHERE contact = :contact');
            $stmt->execute([':contact' => $contact]);

            if ($stmt->rowCount() > 0) {
                response(204, '');
            } else {
                response(404, "Nenhum produto encontrado com esse ID.");
            }
        } catch (PDOException $e) {
            response($e->getCode(), $e->getMessage());
        }
    }

    $contact = $_GET['contact'] ?? null;

    deleteUser(htmlspecialchars($contact));
}
