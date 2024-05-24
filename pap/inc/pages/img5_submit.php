<?php
    defined('CONTROL' or die('Access denied'));

    $backgroudGeneral = $_FILES['backgroudGeneral'];

    $backgroudGeneralHelp = explode('.', $backgroudGeneral['name']);

        if ($backgroudGeneralHelp[sizeof($backgroudGeneralHelp)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $backgroudGeneral['name'] = 'office_design' . '.png';
            move_uploaded_file($backgroudGeneral['tmp_name'], '../inc/img/office/'.$backgroudGeneral['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }