<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $confirm_cart = $db->confirmCart($_SESSION['id']);

    if ($confirm_cart['status'] == 'success') {
        header("Location: ?page=office_student");
        exit;
    } else {
        header("Location: ?page=404");
    }
?>