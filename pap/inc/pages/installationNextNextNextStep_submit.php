<?php
    defined('CONTROL') or die('Access denied');

    $db = new database();

    $PauseOne = $_POST['PauseOne'] ?? null;
    $PauseTwo = $_POST['PauseTwo'] ?? null;
    $PauseThree = $_POST['PauseThree'] ?? null;
    $PauseFour = $_POST['PauseFour'] ?? null;
    $PauseFive = $_POST['PauseFive'] ?? null;
    $PauseSix = $_POST['PauseSix'] ?? null;
    $PauseSeven = $_POST['PauseSeven'] ?? null;
    $LunchOne = $_POST['LunchOne'] ?? null;
    $LunchTwo = $_POST['LunchTwo'] ?? null;
    $LunchLimit = $_POST['LunchLimit'] ?? null;

    if ($PauseOne == null || $PauseTwo == null || $PauseThree == null || $PauseFour == null || $PauseFive == null || $PauseSix == null || $PauseSeven == null || $LunchOne == null || $LunchTwo == null || $LunchLimit == null) {
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ?page=installationNextNextNextStep");
        exit;
    }

    $name = $_SESSION['name'] ?? null;
    $email = $_SESSION['email'] ?? null;
    $fixPhone = $_SESSION['fixPhone'] ?? null;
    $phone = $_SESSION['phone'] ?? null;
    $address = $_SESSION['address'] ?? null;
    $domainOne = $_SESSION['DomainOneRegister'] ?? null;
    $domainTwo = $_SESSION['DomainTwoRegister'] ?? null;
    $domainThree = $_SESSION['DomainThreeRegister'] ?? null;
    $domainFour = $_SESSION['DomainFourRegister'] ?? null;

    if ($name == null || $email == null || $fixPhone == null || $phone == null || $address == null || $domainOne == null) {
        $_SESSION['error'] = 'Erro ao armazenar informação!';
        header("Location: ?page=installationNextNextNextStep");
        exit;
    }

    $result = $db->installationSchoolRegister($name, $email, $fixPhone, $phone, $address, $domainOne, $domainTwo, $domainThree, $domainFour, $PauseOne, $PauseTwo, $PauseThree, $PauseFour, $PauseFive, $PauseSix, $PauseSeven, $LunchOne, $LunchTwo, $LunchLimit);

    if ($result['affectedRows'] == 0) {
        $_SESSION['error'] = 'Erro ao armazenar informações!';
        header("Location: ?page=installationNextNextNextStep");
        exit;
    } else {
        header("Location: ?page=main");
        exit;
    }
?>