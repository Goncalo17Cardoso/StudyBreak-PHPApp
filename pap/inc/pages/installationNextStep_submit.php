<?php
    defined('CONTROL') or die('Access denied');

    $name = $_POST['NameRegister'] ?? null;
    $email = $_POST['EmailRegister'] ?? null;
    $fixPhone = $_POST['fixPhoneRegister'] ?? null;
    $phone = $_POST['phoneRegister'] ?? null;
    $address = $_POST['addressRegister'] ?? null;

    if ($name == null || $email == null || $fixPhone == null || $phone == null || $address == null) {
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ?page=installationNextStep");
        exit;
    }

    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['fixPhone'] = $fixPhone;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;

    if ($_SESSION['name'] == null || $_SESSION['email'] == null || $_SESSION['fixPhone'] == null || $_SESSION['phone'] == null || $_SESSION['address'] == null) {
        $_SESSION['error'] = 'Erro ao armazenar informações!';
        header("Location: ?page=installationNextStep");
        exit;
    } else {
        header("Location: ?page=installationNextNextStep");
        exit;
    }
?>