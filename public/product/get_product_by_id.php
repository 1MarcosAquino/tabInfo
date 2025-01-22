<?php
include '../../src/database.php';
include '../../src/response.php';

if (strtolower($method) === "get") {
    function getProductById($id)
    {
        $con = connectDatabase('tabinfo', 'root');
        try {

            $stmt = $con->prepare('SELECT * FROM products WHERE id = :id');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                response(200, $products);
            } else {
                response(404, "Nenhum produto encontrado com esse ID.");
            }
        } catch (PDOException $e) {

            response($e->getCode(), $e->getMessage());
        }
    }

    $id = $_GET['id'] ?? null;

    getProductById($id);
}
