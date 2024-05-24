<?php
    defined('CONTROL' or die('Access denied'));

    $productName = $_POST['productName'] ?? null;
    $productPrice = $_POST['productPrice'] ?? null;
    $lunchOfTheDay = $_POST['lunchOfTheDay'] ?? null;
    $productType = $_POST['productType'] ?? null;

    $db = new database();

    if ($productName == null || $productPrice == null || $lunchOfTheDay == null || $productType == null) {
        $_SESSION['error'] = 'Preencha todos os campos para adicionar um novo produto!';
        header('Location: ?page=addproducts_admin');
        exit;
    }

    $lunchOfTheDayInt = intval($lunchOfTheDay);

    $result = $db->addProducts($productName, $productPrice, $lunchOfTheDayInt, $productType);

    if($result['status'] == 'success') {
        header('Location: ?page=addproducts_admin');
        $_SESSION['success'] = 'Produto adicionado!';
        exit;
    } else {
        header('Location: ?page=addproducts_admin');
        $_SESSION['error'] = 'Falha ao adicionar produto';
        exit;
    }
    
?>