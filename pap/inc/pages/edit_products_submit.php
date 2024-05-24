<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $productId = $_GET['id'] ?? null;

    $name = $_POST['ProductName'] ?? null;
    $type = $_POST['ProductType'] ?? null;
    $menu = $_POST['ProductMenu'] ?? null;
    $price = $_POST['ProductPrice'] ?? null;

    if ($productId == null || $name == null || $type == null || $menu == null || $price == null) {
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ?page=edit_products&id=$productId");
        exit;
    }

    $result = $db->editProducts($productId, $name, $type, $menu, $price);

    if ($result['affectedRows'] == 1) {
        $_SESSION['success'] = 'Produto Editado!';
        header("Location: ?page=products_admin");
        exit;
    } else {
        $_SESSION['warning'] = 'O Produto não foi Editado!';
        header("Location: ?page=products_admin");
        exit;
    }
?>