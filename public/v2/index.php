<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>

    <style>
        .sideBar {
            height: 100dvh;
            width: 250px;

            color: white;
            background-color: #00508B;
            position: fixed;
            top: 0;
            left: 0;
        }

        .content {
            margin-left: 250px;
        }

        header {
            height: 80px;
            border: 1px solid #00508B;
            margin-bottom: 1rem;
        }

        button[type="button"] {
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;

            font-size: 1rem;
        }

        button[type="button"] img {
            width: 20px;
        }

        .flex {
            display: flex;
        }

        .flex_just-content-center {
            display: flex;
            justify-content: center;
        }

        .flex-align-center {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        thead tr th {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <aside class="sideBar"></aside>
    <section class="content">
        <header class="d-flex justify-content-between align-items-center p-3 bg-light">
            <div class="search d-flex align-items-center">
                <input type="text" class="form-control me-2" placeholder="Buscar">
                <button type="button" class="btn btn-primary text-white">
                    <img src="src/images/search.svg" alt="Deletar">
                </button>
            </div>

            <div class="user d-flex align-items-center">
                <div class="user_name me-3">user_name</div>
                <div class="user_avatar">
                    <img src="user_avatar_url" alt="Avatar" class="rounded-circle" width="40" height="40">
                </div>
            </div>
        </header>

        <div class=" container">
            <?php
            function mysqliConnet()
            {
                $mysqli = new mysqli("localhost", "root", "", "tabinfo");

                if ($mysqli->connect_errno) {
                    die("Failed to connect to MySQL: " . $mysqli->connect_error);
                }

                $sql = "SELECT * FROM products";

                $result = $mysqli->query($sql);
            }


            useCache('products', 'list Producst',  1);
            useCache('users', 'list users',  1);
            ?>

            <table class="table table-striped products">
                <thead>
                    <tr>
                        <th class="bg-primary" scope="col">Codigo de Barras</th>
                        <th class="bg-primary" scope="col">Nome</th>
                        <th class="bg-primary" scope="col">Quantidade</th>
                        <th class="bg-primary" scope="col">Preço</th>
                        <th class="bg-primary" scope="col"></th>
                    </tr>
                </thead>

                <tbody class="border border-primary">
                    <?php

                    $formatter = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);

                    while ($row = $result->fetch_assoc()) {


                        $price =  $formatter->formatCurrency($row['price'], 'BRL');

                        echo "<tr>";
                        echo "<td scope='row'>" . $row['id'] . "</td>";
                        echo "<td scope='row'>" . $row['name'] . "</td>";
                        echo "<td scope='row'>" . $row['qtd'] . "</td>";
                        echo "<td scope='row'>" . $price . "</td>";

                        echo '<td class="flex-align-center" scope="row">
                            <button type="button" class="btn-lg btn btn-outline-warning">
                                <img src="src/images/edit.svg" alt="Editar"><span> Editar</span>
                            </button>
                            <button type="button" class="btn-lg btn btn-outline-danger">
                                <img src="src/images/trash.svg" alt="Deletar"><span> Deletar</span>
                            </button>
                            </td>';
                        echo "</tr>";
                    }

                    $result->free_result();
                    $mysqli->close();
                    ?>

                </tbody>
            </table>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </div>
    </section>
</body>

</html>