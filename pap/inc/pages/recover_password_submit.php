<?php
defined('CONTROL') or die('Access denied');

$db = new database();

$password_recover = $_POST['passwordrecover'] ?? null;
$password_recover_confirmation = $_POST['passwordrecoverconfirmation'] ?? null;
$recover_code = $_GET['code'];

if($recover_code == null) {
    header("Location: ?page=main");
    exit;
}

if (empty($password_recover) || empty($password_recover_confirmation)) {
    $_SESSION['error'] = 'Preencha os campos!';
    header("Location: ?page=recover_password&code=$recover_code");
    exit;
}

if($password_recover != $password_recover_confirmation) {
    $_SESSION['error'] = 'As palavras-passes não coincidem!';
    header("Location: ?page=recover_password&code=$recover_code");
    exit;
} else {
    $result = $db->recoverPassword($password_recover, $recover_code);~
    $_SESSION['warning'] = 'A sua palavra-passe foi alterada!';
    header("Location: ?page=login");
    exit;
}
