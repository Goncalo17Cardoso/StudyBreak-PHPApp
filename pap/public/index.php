<?php
    define('CONTROL', true);

    session_start();

    $page = $_GET['page'] ?? null;
    $routes = [];

    if(isset($_SESSION['id'])) {
        $routes = require_once('../inc/routes/routes_logged_in.php');
    } else {
        $routes = require_once('../inc/routes/routes_logged_out.php');
    }

    if (!isset($_SESSION['id']) && !in_array($page, $routes)) {
        $page = "main";
    }

    if (isset($_SESSION['id']) && !in_array($page, $routes)) {
        if($_SESSION['type'] == 'Aluno' || $_SESSION['type'] == 'Professor/Funcionario') {
            $page = "office_student";
        } else if ($_SESSION['type'] == 'Adminstrador') {
            $page = "office_admin";
        } else if ($_SESSION['type'] == 'Direcao') {
            $page = "app_customize";
        }
    }

    require_once "../inc/db/config.php";
    require_once "../inc/db/database.php";

    require_once "../inc/utils/functions.php";

    require_once('../inc/content/head.php');
    if(isset($_SESSION['id'])) {
        require_once('../inc/content/header.php');
    }
    require_once("../inc/pages/$page.php");
    require_once('../inc/content/footer.php');

?>