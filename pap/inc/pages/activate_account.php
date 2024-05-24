<?php

defined('CONTROL') or die('Access denied');

$activation_code = $_GET['code'];

$db = new database();
$result = $db->validateEmailLink($activation_code);

if($result['affectedRows'] == '1') {
    $_SESSION['warning'] = 'Conta verificada com sucesso!';
    header("Location: ?page=login");
} else {
    $_SESSION['error'] = 'Erro ao verificar conta!';
    header("Location: ?page=register");
}

?>