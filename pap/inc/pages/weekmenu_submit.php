<?php
    defined('CONTROL' or die('Access denied'));

    $date = $_GET['date'] ?? null;
    $menuSoup = $_POST['menuSoup'] ?? null;
    $menuFood = $_POST['menuFood'] ?? null;
    $menuDessert = $_POST['menuDessert'] ?? null;
    $menuDrink = $_POST['menuDrink'] ?? null;
    $menuPrice = $_POST['menuPrice'] ?? null;

    $db = new database();

    if($date == null || $menuSoup == null || $menuFood == null || $menuDessert == null || $menuDrink == null || $menuPrice == null) {
        $_SESSION['error'] = 'Preencha todos os campos para alterar um menu!';
        header('Location: ?page=weekmenu_admin');
        exit;
    }

    $verify = $db->verifyMenuDate($date);

    if(!$verify['affectedRows'] == 1) {
        $result = $db->newMenu($date, $menuSoup, $menuFood, $menuDessert, $menuDrink, $menuPrice);
        $_SESSION['success'] = "Menu de $date adicionado com sucesso!";
        header('Location: ?page=weekmenu_admin');
        exit;
    } else {
        $result = $db->updateMenu($date, $menuSoup, $menuFood, $menuDessert, $menuDrink, $menuPrice);
        $_SESSION['success'] = "Menu de $date alterado com sucesso!";
        header('Location: ?page=weekmenu_admin');
        exit;
    }
?>