<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();
    
    $instagram = $_POST['appInstagram'] ?? null;
    $facebook = $_POST['appFacebook'] ?? null;
    $linkedin = $_POST['appLinkedIn'] ?? null;
    $whatsapp = $_POST['appWhatsapp'] ?? null;
    $youtube = $_POST['appYoutube'] ?? null;

    $result = $db->editSocial($instagram, $facebook, $linkedin, $whatsapp, $youtube);

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