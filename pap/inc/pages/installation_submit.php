<?php
    defined('CONTROL') or die('Access denied');

    $db = new database();

    $name = $_POST['NameRegister'] ?? null;
    $email = $_POST['EmailRegister'] ?? null;
    $pass = $_POST['PassRegister'] ?? null;
    $passConfirm = $_POST['PassRegisterConfirmation'] ?? null;

    if ($name == null || $email == null || $pass == null || $passConfirm == null) {
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ?page=installation");
        exit;
    }

    if ($pass != $passConfirm) {
        $_SESSION['error'] = 'As palavras-passes não coincidem!';
        header("Location: ?page=installation");
        exit;
    }

    $result = $db->installationUserRegister($name, $email, $pass);

    if ($result['affectedRows'] == 1) {
        header("Location: ?page=installationNextStep");
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao criar conta!';
        header("Location: ?page=installation");
        exit;
    }
?>