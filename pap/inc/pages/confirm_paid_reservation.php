<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $reservationId = $_GET['reservationId'];

    $confirm_reservation = $db->confirmReservation($reservationId);

    header("Location: ?page=reservations_admin");
    exit;
?>