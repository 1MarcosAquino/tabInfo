<?php

include __DIR__ . '/../../src/database.php';
include __DIR__ . '/../../src/response.php';

if (strtolower($method) === 'post') {
    function registerProducts($product)
    {
        $con = connectDatabase('tabinfo', 'root');

        try {
            $con->beginTransaction();

            $stmt = $con->prepare('INSERT INTO products (name, image, qtd, price, user_id) VALUES (:name, :image, :qtd, :price,:user_id)');

            $stmt->execute((array)$product);

            // $stmt->execute([
            //     ':name' => $product->name,
            //     ':image' => $product->image,
            //     ':qtd' => $product->qtd,
            //     ':price' => $product->price,
            //     ':user_id' => $product->user_id,
            // ]);

            $con->commit();

            response(201, "Produto inserido com sucesso!");
        } catch (PDOException $e) {

            $con->rollBack();

            response($e->getCode(), $e->getMessage());
        }
    }

    $id = $_GET['id'] ?? null;

    $body = file_get_contents('php://input');

    registerProducts(json_decode($body));
}
