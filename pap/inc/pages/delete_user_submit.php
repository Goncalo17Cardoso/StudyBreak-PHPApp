<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $id = $_GET['id'] ?? null;

    $result = $db->deleteUser($id);

    if($result['affectedRows'] == 1) {
        $_SESSION['success'] = 'Utilizador Eliminado!';
        header("Location: ?page=users");
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao Eliminar Utilizador!';
        header("Location: ?page=users");
        exit;
    }