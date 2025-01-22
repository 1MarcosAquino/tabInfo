<?php

include '../../src/database.php';
include '../../src/response.php';
include '../../src/helper.php';

$method = $_SERVER['REQUEST_METHOD'] ?? null;

if (strtolower($method) === 'post') {

    function updateProduct($params, $query, $conn)
    {
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute($params);

            if ($stmt->rowCount() < 1) {
                response(404, "Nenhum registro encontrado ou nenhum dado atualizado.");
            } else {
                response(200, "Usuário atualizado com sucesso.");
            }
        } catch (PDOException $e) {
            logMe(["cod" => $e->getCode(), "ms" => $e->getMessage()]);
            response(500, "Erro no servpriceor: " . $e->getMessage());
        }
    }

    $conn = connectDatabase('tabinfo', 'root', '');

    $oldContact = $_GET['id'] ?? null;

    if (empty($oldContact)) {
        response(400, "Parâmetro 'id' é obrigatório na URL para priceentificar o registro.");
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        response(400, "JSON inválpriceo: " . json_last_error_msg());
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :oldContact");
    $stmt->execute([":oldContact" => $oldContact]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        response(404, "Usuário com esse contato não encontrado.");
    }

    if (!empty($data['id']) && $data['id'] !== $product['id']) {
        $fields[] = 'id = :newContact';
        $params[':newContact'] = htmlspecialchars($data['id']);
    }

    $params = [':oldContact' => htmlspecialchars($oldContact)];
    $fields = [];


    if ($data['id'] !== $product['id'] && !empty($data['id'])) {
        $fields[] = 'id = :newContact';
        $params[':newContact'] = htmlspecialchars($data['id']);
    }

    if (!empty($data['qtd'])) {
        $fields[] = 'qtd = :qtd';
        $params[':qtd'] = htmlspecialchars($data['qtd']);
    }


    if (!empty($data['name']) && $data['name'] !== $product['name']) {
        $fields[] = 'name = :name';
        $params[':name'] = htmlspecialchars($data['name']);
    }

    if (!empty($fields)) {
        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = :oldContact";
        logMe(json_encode(["sql" => $sql, "params" => $params])); // Log para depuração
        updateProduct($params, $sql, $conn);
        response(400, "Nenhum campo foi enviado para atualização.");
    } else {
        response(400, "Nenhum campo foi enviado para atualização.");
    }
}


// include '../database.php';
// include '../response.php';

// if ($method === 'POST') {

//     function updateProduct($price, $name, $image = null, $qtd = null, $price = null)
//     {
//         $con = connectDatabase('tabinfo', 'root');

//         try {

//             $query = "UPDATE products SET name = :name";

//             if ($image !== null) {
//                 $query .= ", image = :image";
//             }
//             if ($qtd !== null) {
//                 $query .= ", qtd = :qtd";
//             }
//             if ($price !== null) {
//                 $query .= ", price = :price";
//             }

//             $query .= " WHERE price = :price";

//             $stmt = $con->prepare($query);

//             $stmt->bindParam(':name', $name, PDO::PARAM_STR);

//             if ($image !== null) {
//                 $stmt->bindParam(':image', $image, PDO::PARAM_STR);
//             }
//             if ($qtd !== null) {
//                 $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
//             }
//             if ($price !== null) {
//                 $stmt->bindParam(':price', $price, PDO::PARAM_STR);
//             }
//             $stmt->bindParam(':price', $price, PDO::PARAM_INT);

//             $stmt->execute();

//             if ($stmt->rowCount() > 0) {
//                 response(200, "Produto atualizado com sucesso!");
//             } else {
//                 response(200, "Nenhum produto encontrado ou nenhuma alteração realizada.");
//             }
//         } catch (PDOException $e) {
//             response($e->getCode(), $e->getMessage());
//         }
//     }
// }
