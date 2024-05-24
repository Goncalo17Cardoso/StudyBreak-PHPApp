<?php
    defined('CONTROL' or die('Access denied'));

    $newObjective = $_POST['newObjective'] ?? null;
    $userId = $_SESSION['id'];

    $db = new database();

    if ($newObjective == null) {
        header("Location: ?page=office_admin");
        exit;
    }

    if ($newObjective < 100) {
        header("Location: ?page=office_admin");
        exit;
    }

    $result = $db->newObjective($userId, $newObjective);

    header("Location: ?page=office_admin");
?>