<?php
    defined('CONTROL' or die('Access denied'));

    $productType = $_POST['productType'] ?? null;

    $db = new database();

    if ($productType == null) {
        $_SESSION['error1'] = 'Preencha todos os campos para adicionar um novo produto!';
        header('Location: ?page=addproducts_admin');
        exit;
    }

    $result = $db->addProductsType($productType);

    if($result['status'] == 'success') {
        header('Location: ?page=addproducts_admin');
        $_SESSION['success1'] = 'Tipo de produto adicionado!';
        exit;
    } else {
        header('Location: ?page=addproducts_admin');
        $_SESSION['error1'] = 'Falha ao adicionar o tipo de produto';
        exit;
    }
?>