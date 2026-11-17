<?php
define('IN_APP', true);

require_once 'db.php';
require_once 'menu.php';
require_once 'viewer.php';

$page = $_GET['page'] ?? 'view';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?= getMenu(); ?>

<main>
    <?php
    switch ($page) {
        case 'add':
            include 'add.php';
            break;
        case 'edit':
            include 'edit.php';
            break;
        case 'delete':
            include 'delete.php';
            break;
        case 'view':
        default:
            $sort = $_GET['sort'] ?? 'id';
            $p = $_GET['p'] ?? 1;
            echo renderViewer($sort, $p);
            break;
    }
    ?>
</main>

<footer></footer>

</body>
</html>
