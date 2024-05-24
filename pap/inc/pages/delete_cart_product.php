<?php 
    defined('CONTROL' or die('Access denied!'));

    $db = new database();

    $reservationId = $_GET['reservationId'];

    $deleteCartProduct = $db->deleteReservation($reservationId);

    header("Location: ?page=office_student");
    exit;
?>