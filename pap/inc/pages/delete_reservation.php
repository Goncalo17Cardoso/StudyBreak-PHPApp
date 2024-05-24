<?php 
    defined('CONTROL' or die('Access denied!'));

    $db = new database();

    $reservationId = $_GET['reservationId'];

    $delete_reservation = $db->deleteReservation($reservationId);

    header("Location: ?page=reservations_admin");
    exit;
?>