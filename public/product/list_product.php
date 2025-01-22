<?php

include __DIR__ . '/../../src/database.php';
include __DIR__ . '/../../src/response.php';

if ($method === 'GET') {
    function listProducts($page = 1, $limit = 20)
    {
        $con = connectDatabase('tabinfo', 'root');

        try {
            $offset = ($page - 1) * $limit;

            $stmt = $con->prepare('SELECT * FROM products LIMIT :limit OFFSET :offset');

            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            response(200, $products);
        } catch (PDOException $e) {

            response($e->getCode(), $e->getMessage());
        }
    }

    $id = $_GET['id'] ?? null;

    $page = htmlspecialchars($_GET['page'] ?? 1);
    $offset = htmlspecialchars($_GET['offset'] ?? 20);

    if (isset($id)) {
        getProductById(htmlspecialchars($id));
    }

    listProducts($page, $offset);
} else {
    echo response(200, "Use GET!");
}
