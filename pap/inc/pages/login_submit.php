<?php
defined('CONTROL') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?page=404');
    exit;
}

$db = new database();

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(empty($email) || empty($password)) {
    $_SESSION['error'] = 'Preencha todos os campos!';
    header("Location: ?page=login");
    exit;
} 

$result = $db->signin($email);

if($result['status'] == 'error') {
    header("Location: ?page=login");
    $_SESSION['error'] = 'Credenciais inválidas!';
    exit;
}

if (count($result['data']) == 0) {
    header("Location: ?page=login");
    $_SESSION['error'] = 'Credenciais inválidas!';
    exit;
}

if ($result['data'][0]->email_validate == 0) {
    header("Location: ?page=login");
    $_SESSION['warning'] = 'Confirme a sua conta no seu email!';
    exit;
}

if (!password_verify($password, $result['data'][0]->palavraPasse)) {
    header("Location: ?page=login");
    $_SESSION['error'] = 'Credenciais inválidas!';
    exit;
}

$_SESSION['id'] = $result['data'][0]->idUtilizador;
$_SESSION['email'] = $result['data'][0]->email;
$_SESSION['name'] = $result['data'][0]->nome;
$_SESSION['contact'] = $result['data'][0]->contacto;
$_SESSION['type'] = $result['data'][0]->tipoUtilizador;
$_SESSION['nif'] = $result['data'][0]->nif;

if($_SESSION['type'] == 'Aluno' || $_SESSION['type'] == 'Professor/Funcionario') {
    header("Location: ?page=office_student");
    exit;
} else if ($_SESSION['type'] == 'Administrador') {
    header("Location: ?page=office_admin");
    exit;
} else if ($_SESSION['type'] == 'Direcao') {
    header("Location: ?page=office_direction");
    exit;
}
?>