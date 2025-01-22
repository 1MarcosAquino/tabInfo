<?php
include 'database.php';

$quantity = 100; // QUantidade de Productos 

$connet = connectDatabase('tabinfo', 'root');

function generateProducts($quantity, $call)
{
    foreach (range(0, $quantity) as $product) {
        $newProdcut = new stdClass();
        $newProdcut->name = "Product" . $product;
        $newProdcut->image = "Foto do produto " . $product;
        $newProdcut->qtd = rand(10, 1000);
        $newProdcut->price = round(mt_rand() / mt_getrandmax() * (500.0 - 5.0) + 5.0, 2);
        $newProdcut->user_id = '1';

        $call($newProdcut);
    }
}

function registerProducts($product)
{
    $con = connectDatabase('tabinfo', 'root');

    try {
        $con->beginTransaction();

        $stmt = $con->prepare('INSERT INTO products (name, image, qtd, price,user_id) VALUES (:name, :image, :qtd, :price,:user_id)');

        $stmt->execute((array)$product);

        $con->commit();
        echo "Produto inserido com sucesso!\n";
    } catch (PDOException $e) {

        $con->rollBack();
        echo "Erro ao inserir produto: " . $e->getMessage();
    }
}

$connet->prepare("DROP TABLE IF EXISTS products")->execute();
$connet->prepare("DROP TABLE IF EXISTS users")->execute();

$connet->prepare("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    contact VARCHAR(50) UNIQUE
)")->execute();

$connet->prepare("CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    qtd INT DEFAULT 1,
    price DECIMAL(10, 2),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
)")->execute();

$user = new stdClass();
$user->name = 'Marcos';
$user->pass = '123';
$user->contact = 'marcos@mail.com';

$stmt = $connet->prepare('INSERT INTO users (name,pass,contact) VALUES (:name,:pass,:contact)');

$stmt->execute((array)$user);

generateProducts($quantity, 'registerProducts');
