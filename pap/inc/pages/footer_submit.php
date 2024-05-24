<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();
    
    $appName = $_POST['appName'] ?? null;
    $appEmail = $_POST['appEmail'] ?? null;
    $appPhone = $_POST['appPhone'] ?? null;
    $appCellphone = $_POST['appCellphone'] ?? null;
    $appLocation = $_POST['appLocation'] ?? null;

    $result = $db->editFooter($appName, $appEmail, $appPhone, $appCellphone, $appLocation);

if($result['affectedRows'] != 0) {
    $_SESSION['success'] = 'Informações do Footer Alteradas!';
    header("Location: ?page=app_customize");
    exit;
} else {
    $_SESSION['error'] = 'Erro ao Editar Informações do Footer!';
    header("Location: ?page=app_customize");
    exit;
}
?>