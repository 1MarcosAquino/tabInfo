<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="/src/styles/home.css" />
    <link rel="stylesheet" href="/src/styles/styles.css" />
    <link rel="stylesheet" href="/src/styles/card-style.css" />
    <link rel="stylesheet" href="/src/styles/form-style.css" />

    <title>Dashboard</title>

    <script>
        const urlBase = 'http://localhost:3000/';
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/src/scripts/scripts.js"></script>

</head>

<body>
    <aside>
        <h2>Dashboard</h2>
        <ul>
            <li><a class="button default" href="/creat_user">Novo Usuario</a></li>
            <li><a class="button default" href="/list_users">Listar Usuarios</a></li>
            <li><a class="button default" href="/creat_proct">Novo Produto</a></li>
            <li><a class="button default" href="/list_roducts">Listar Produtos</a></li>
        </ul>
    </aside>

    <section>
        <div class="products">
            <?php
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $method = parse_url($_SERVER['REQUEST_METHOD'], PHP_URL_PATH);

            switch ([strtolower($uri), strtolower($method)]) {

                case ['/list_users', 'get']:

                    include __DIR__ . DIRECTORY_SEPARATOR . '../html/list_users.html';

                    break;

                case ['/creat_user', 'get']:

                    include __DIR__ . DIRECTORY_SEPARATOR . '../html/creat_user.html';

                    break;

                case ['/creat_proct', 'get']:

                    include __DIR__ . DIRECTORY_SEPARATOR . '../html/creat_proct.html';

                    break;

                case ['/list_roducts', 'get']:

                    include __DIR__ . DIRECTORY_SEPARATOR . '../html/list_roducts.html';

                    break;

                default:

                    echo '';

                    break;
            }
            ?>
        </div>
    </section>
</body>

</html>