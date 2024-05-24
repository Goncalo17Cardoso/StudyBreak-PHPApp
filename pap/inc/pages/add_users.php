<?php
    defined('CONTROL') or die('Access denied');

    $db = new database();

    $name = $_POST['UserName'] ?? null;
    $email = $_POST['UserEmail'] ?? null;
    $pass = $_POST['UserPass'] ?? null;
    $phone = $_POST['UserPhone'] ?? null;
    $type = $_POST['UserType'] ?? null;
    $nif = $_POST['UserNIF'] ?? null;

    if ($name == null || $email == null || $pass == null || $phone == null || $type == null || $nif == null) {
        $_SESSION['error'] = 'Preencha todos os campos para adicionar um Utilizador!';
        header('Location: ?page=users');
        exit;
    }

    $result = $db->addUser($name, $email, $pass, $phone, $type, $nif);

    if($result['status'] == 'success') {
        header('Location: ?page=users');
        $_SESSION['success'] = 'Utilizador adicionado!';
        exit;
    } else {
        header('Location: ?page=users');
        $_SESSION['error'] = 'Falha ao adicionar um novo utilizador!';
        exit;
    }

?>