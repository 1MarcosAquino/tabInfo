<?php

include '../../src/database.php';
include '../../src/response.php';
include '../../src/helper.php';

$method = $_SERVER['REQUEST_METHOD'] ?? null;

if (strtolower($method) === 'post') {

    function updateUser($params, $query, $conn)
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
            response(500, "Erro no servidor: " . $e->getMessage());
        }
    }

    $conn = connectDatabase('tabinfo', 'root', '');

    $oldContact = $_GET['contact'] ?? null;

    if (empty($oldContact)) {
        response(400, "Parâmetro 'contact' é obrigatório na URL para identificar o registro.");
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        response(400, "JSON inválido: " . json_last_error_msg());
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE contact = :oldContact");
    $stmt->execute([":oldContact" => $oldContact]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        response(404, "Usuário com esse contato não encontrado.");
    }

    if (!empty($data['contact']) && $data['contact'] !== $user['contact']) {
        $fields[] = 'contact = :newContact';
        $params[':newContact'] = htmlspecialchars($data['contact']);
    }

    $params = [':oldContact' => htmlspecialchars($oldContact)];
    $fields = [];


    if ($data['contact'] !== $user['contact'] && !empty($data['contact'])) {
        $fields[] = 'contact = :newContact';
        $params[':newContact'] = htmlspecialchars($data['contact']);
    }

    if (!empty($data['pass'])) {
        $fields[] = 'pass = :pass';
        $params[':pass'] = htmlspecialchars($data['pass']);
    }


    if (!empty($data['name']) && $data['name'] !== $user['name']) {
        $fields[] = 'name = :name';
        $params[':name'] = htmlspecialchars($data['name']);
    }

    if (!empty($fields)) {
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE contact = :oldContact";
        logMe(json_encode(["sql" => $sql, "params" => $params])); // Log para depuração
        updateUser($params, $sql, $conn);
        response(400, "Nenhum campo foi enviado para atualização.");
    } else {
        response(400, "Nenhum campo foi enviado para atualização.");
    }
}
