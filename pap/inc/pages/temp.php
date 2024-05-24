<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $tempOne = $db->tempOne();
    $tempTwo = $db->tempTwo();
    $tempThree = $db->tempThree();
    $tempFour = $db->tempFour();
    $tempFive = $db->tempFive();
    $tempSix = $db->tempSix();
    $tempSeven = $db->tempSeven();
    $tempEight = $db->tempEight();

    header("Location: ?page=add_products");
    exit;