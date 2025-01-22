<?php

include '../../src/database.php';
include '../../src/response.php';

if (strtolower($method) === 'delete') {
    function removeProduct($id)
    {
        $con = connectDatabase('tabinfo', 'root');

        try {
            $stmt = $con->prepare('DELETE FROM products WHERE id = :id');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                response(204, 'OK');
            } else {
                response(404, "Nenhum produto encontrado com esse ID.");
            }
        } catch (PDOException $e) {
            response($e->getCode(), $e->getMessage());
        }
    }

    $id = $_GET['id'] ?? null;

    removeProduct(htmlspecialchars($id));
}
