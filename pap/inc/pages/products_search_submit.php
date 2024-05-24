<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $productSearch =  $_POST['search'] ?? null;

    if ($productSearch == null) {
        header('Location: ?page=products_admin');
        exit;
    } else {
        header("Location: ?page=products_admin&search=$productSearch");
        exit;
    }
?>