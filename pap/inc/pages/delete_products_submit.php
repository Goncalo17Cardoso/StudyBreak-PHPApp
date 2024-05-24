<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $id = $_GET['id'] ?? null;

    $result = $db->deleteProducts($id);

    if($result['affectedRows'] == 1) {
        $_SESSION['success'] = 'Produto Eliminado!';
        header("Location: ?page=products_admin");
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao Eliminar Produto!';
        header("Location: ?page=products_admin");
        exit;
    }