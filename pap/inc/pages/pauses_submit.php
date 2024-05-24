<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();
    
    $pause1 = $_POST['appPause1'] ?? null;
    $pause2 = $_POST['appPause2'] ?? null;
    $pause3 = $_POST['appPause3'] ?? null;
    $pause4 = $_POST['appPause4'] ?? null;
    $pause5 = $_POST['appPause5'] ?? null;
    $pause6 = $_POST['appPause6'] ?? null;
    $pause7 = $_POST['appPause7'] ?? null;

    $result = $db->editPauses($pause1, $pause2, $pause3, $pause4, $pause5, $pause6, $pause7);

if($result['affectedRows'] != 0) {
    $_SESSION['success'] = 'As Horas de Intervalos foram alteradas!';
    header("Location: ?page=app_customize");
    exit;
} else {
    $_SESSION['error'] = 'Erro ao Alterar as Horas de Intervalo!';
    header("Location: ?page=app_customize");
    exit;
}
?>