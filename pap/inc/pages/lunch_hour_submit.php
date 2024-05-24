<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();
    
    $lunch1 = $_POST['appLunch1'] ?? null;
    $lunch2 = $_POST['appLunch2'] ?? null;

    $result = $db->editLunchs($lunch1, $lunch2);

    if($result['affectedRows'] != 0) {
        $_SESSION['success'] = 'As Horas de Almoço foram Alteradas!';
        header("Location: ?page=app_customize");
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao Alterar as Horas de Almoço!';
        header("Location: ?page=app_customize");
        exit;
    }
?>