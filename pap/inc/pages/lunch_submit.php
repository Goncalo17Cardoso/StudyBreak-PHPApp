<?php
defined('CONTROL' or die('Access denied!'));

$db = new database();

$date = $_POST['date'] ?? null;
$hour = $_POST['hours'] ?? null;

$selectedSoup = $_POST['selectSoup'] ?? null;
$selectedFood = $_POST['selectFood'] ?? null;
$selectedDrink = $_POST['selectDrink'] ?? null;
$selectedDessert = $_POST['selectDessert'] ?? null;

$chooseMenuYN = $_POST['chooseMenuYN'] ?? null;

if ($date == NULL || $hour == NULL) {
    header("Location: ?page=lunch_student");
    $_SESSION['error'] = 'Selecione uma data e hora para a sua reserva!';
    exit;
}

if($selectedSoup == NULL && $selectedFood == NULL && $selectedDessert == NULL && $selectedDrink == NULL && $chooseMenuYN == NULL) {
    $_SESSION['error'] = 'Selecione o tipo de almoço desejado!';
    header("Location: ?page=lunch_student");
    exit;
}

if (isset($chooseMenuYN) && ($selectedSoup == NULL && $selectedFood == NULL && $selectedDessert == NULL && $selectedDrink == NULL)) {
    $available = $db->verifyMenuDateAvailable($date);

    if ($available['affectedRows'] == 0) {
        $_SESSION['error'] = 'O menu para o dia selecionado não está disponível de momento!';
        header("Location: ?page=lunch_student");
        exit;
    } else {    
        $confirm = $db->verifyUserReservation($_SESSION['id'], $date);
        if ($confirm['affectedRows'] == '1') {
            $_SESSION['error'] = "Você já tem um almoço reservado para essa data!";
            header("Location: ?page=lunch_student");
            exit;
        }
        $menuId = $available['data'][0]->idMenuDiario;
        $price = $available['data'][0]->preco;
        $result = $db->newReservationMenu($_SESSION['id'], $menuId, $date, $hour, $price);

        if ($result['status'] == 'success') {
            $_SESSION['success'] = "Menu adicionado ao carrinho!";
            header("Location: ?page=lunch_student");
            exit;
        } else {
            $_SESSION['error'] = 'Erro ao reservar menu!';
            header("Location: ?page=lunch_student");
            exit;
        }
    }
} else if ((isset($selectedSoup) || isset($selectedFood) || isset($selectedDessert) || isset($selectedDrink)) && $chooseMenuYN == NULL) {
    $confirm = $db->verifyUserReservation($_SESSION['id'], $date);
    if ($confirm['affectedRows'] == '1') {
        $_SESSION['error'] = "Você já tem um almoço reservado para essa data!";
        header("Location: ?page=lunch_student");
        exit;
    }
    if ($selectedSoup == '') {
        $selectedSoup = null;
    }
    if ($selectedFood == '') {
        $selectedFood = null;
    }
    if ($selectedDrink == '') {
        $selectedDrink = null;
    }
    if ($selectedDessert == '') {
        $selectedDessert = null;
    }

    $resultSoup = $db->getProductPrice($selectedSoup);
    $resultFood = $db->getProductPrice($selectedFood);
    $resultDrink = $db->getProductPrice($selectedDrink);
    $resultDessert = $db->getProductPrice($selectedDessert);

    $priceSoup = $resultSoup['data']['0']->preco ?? null;
    $priceFood = $resultFood['data']['0']->preco ?? null;
    $priceDrink = $resultDrink['data']['0']->preco ?? null;
    $priceDessert = $resultDessert['data']['0']->preco ?? null;
    
    $total = $priceSoup + $priceFood + $priceDrink + $priceDessert;

    $result = $db->newReservationLunch($_SESSION['id'], $selectedSoup, $selectedFood, $selectedDrink, $selectedDessert, $date, $hour, $total);

    if($result['status'] == 'success') {
        $_SESSION['success'] = "Almoço adicionado ao carrinho!";
        header("Location: ?page=lunch_student");
        exit;
    } else {
        $_SESSION['error'] = "Erro ao reservar almoço!";
        header("Location: ?page=lunch_student");
        exit;
    }
} else {
    $_SESSION['error'] = 'Selecione apenas um tipo de almoço!';
    header("Location: ?page=lunch_student");
    exit;
}  