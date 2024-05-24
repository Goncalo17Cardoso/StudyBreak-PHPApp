<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $id = $_GET['id'] ?? null;

    $name = $_POST['UserName'] ?? null;
    $phone = $_POST['UserPhone'] ?? null;
    $type = $_POST['UserType'] ?? null;
    $nif = $_POST['UserNIF'] ?? null;

    if ($id == null || $name == null || $phone == null || $type == null || $nif == null) {
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ?page=edit_user&id=$id");
        exit;
    }

    $result = $db->editUsers($id, $name, $phone, $type, $nif);

    if ($result['affectedRows'] == 1) {
        $_SESSION['success'] = 'Utilizador Editado!';
        header("Location: ?page=users");
        exit;
    } else {
        $_SESSION['warning'] = 'Utilizador não foi Editado!';
        header("Location: ?page=users");
        exit;
    }
?>