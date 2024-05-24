<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$dateToday = date("Y-m-d");
$hourNOW = date("H:i");
$selectedSnack = $_POST['selectSnack'] ?? null;
$date = $_POST['date'] ?? null;
$hour = $_POST['hours'] ?? null;

if ($date == NULL || $hour == NULL) {
    header("Location: ?page=snack_student");
    $_SESSION['error'] = 'Selecione uma data e hora para a sua reserva!';
    exit;
}

if ($selectedSnack == null) {
    header("Location: ?page=snack_student");
    $_SESSION['error'] = 'Selecione o produto desejado para a sua reserva!';
    exit;
}

if (date("Y-m-d") >= $date && $hourNOW >= $hour) {
    header("Location: ?page=snack_student");
    $_SESSION['error'] = 'O horário selecionado já não está disponível!';
    exit;
}

$ResultProductPrice = $db->getProductPrice($selectedSnack);
$productPrice = $ResultProductPrice['data']['0']->preco;

$result = $db->newReservationSnack($_SESSION['id'], $selectedSnack, $date, $hour, $productPrice);

if ($result['status'] == 'success') {
    header("Location: ?page=snack_student");
    $_SESSION['success'] = 'Produto adicionado ao carrinho!';
    exit;
} else {
    header("Location: ?page=snack_student");
    $_SESSION['error'] = 'Erro ao reservar!';
    exit;
}
?>