<?php
    defined('CONTROL') or die('Access denied');

    $DomainOneRegister = $_POST['DomainOneRegister'] ?? null;
    $DomainTwoRegister = $_POST['DomainTwoRegister'] ?? null;
    $DomainThreeRegister = $_POST['DomainThreeRegister'] ?? null;
    $DomainFourRegister = $_POST['DomainFourRegister'] ?? null;

    if ($DomainOneRegister == null) {
        $_SESSION['error'] = 'Preencha pelo menos a primeira variante!';
        header("Location: ?page=installationNextNextStep");
        exit;
    }

    $_SESSION['DomainOneRegister'] = $DomainOneRegister;
    $_SESSION['DomainTwoRegister'] = $DomainTwoRegister;
    $_SESSION['DomainThreeRegister'] = $DomainThreeRegister;
    $_SESSION['DomainFourRegister'] = $DomainFourRegister;

    if ($_SESSION['DomainOneRegister'] == null) {
        $_SESSION['error'] = 'Erro ao armazenar informações!';
        header("Location: ?page=installationNextNextStep");
        exit;
    } else {
        header("Location: ?page=installationNextNextNextStep");
        exit;
    }
?>