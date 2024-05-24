<?php

defined('CONTROL') or die('Access denied');

$utils = new utils();
$db = new database();

$email_forgot_password = $_POST['emailfpass'] ?? null;

if($email_forgot_password == NULL) {
    $_SESSION['error'] = 'Preencha o email da conta que deseja recuperar a palavra-passe!';
    header("Location: ?page=forgot_password");
    exit;
}

$result = $db->recoverPasswordEmailVerification($email_forgot_password);

if($result['data'][0]->quantity == '1'){
    $email_code = $utils->generateLink();

    $result = $db->recoverPasswordCode($email_forgot_password, $email_code);

    $_SESSION['warning'] = 'Recupere a sua palavra-passe no email enviado!';
    $message = '<p>Clique <a href="http://localhost/pap/public/?page=recover_password&code=' . $email_code . '">aqui</a> para recuperar a palavra-passe da sua conta!</p>';
    $utils->sendEmail('StudyBreak eRC', GMAIL_EMAIL, '', $email_forgot_password, 'Recuperar Palavra-Passe', $message);
    header("Location: ?page=forgot_password");
} else {
    $_SESSION['error'] = 'Este email não se encontra confirmado!';
    header("Location: ?page=forgot_password");
}

