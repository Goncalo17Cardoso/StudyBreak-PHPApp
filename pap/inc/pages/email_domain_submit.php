<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$domain1 = $_POST['emailDomain1'] ?? null;
$domain2 = $_POST['emailDomain2'] ?? null;
$domain3 = $_POST['emailDomain3'] ?? null;
$domain4 = $_POST['emailDomain4'] ?? null;

$result = $db->editEmailDomains($domain1, $domain2, $domain3, $domain4);

if($result['affectedRows'] != 0) {
    $_SESSION['success'] = 'Dominios de Email Editados!';
    header("Location: ?page=app_customize");
    exit;
} else {
    $_SESSION['error'] = 'Erro ao Editar os Dominios de Email!';
    header("Location: ?page=app_customize");
    exit;
}

?>