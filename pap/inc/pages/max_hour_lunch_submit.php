<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();
    
    $hour = $_POST['appHour'] ?? null;

    $result = $db->editLimitHour($hour);

    if($result['affectedRows'] != 0) {
        $_SESSION['success'] = 'A Hora Limite de Reserva foi Alterada!';
        header("Location: ?page=app_customize");
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao Alterar a Hora Limite de Reserva!';
        header("Location: ?page=app_customize");
        exit;
    }
?>