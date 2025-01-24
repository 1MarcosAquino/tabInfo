<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>

    <style>
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
    <div class="container">



        <?php
        $mysqli = new mysqli("localhost", "root", "", "tabinfo");

        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }

        $sql = "SELECT * FROM products";

        $result = $mysqli->query($sql);
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

</body>

</html>