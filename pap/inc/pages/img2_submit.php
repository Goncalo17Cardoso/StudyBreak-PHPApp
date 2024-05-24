<?php
    defined('CONTROL' or die('Access denied'));

    $logoMain = $_FILES['logoMain'];

    $logoMainHelp = explode('.', $logoMain['name']);

        if ($logoMainHelp[sizeof($logoMainHelp)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $logoMain['name'] = 'logo' . '.png';
            move_uploaded_file($logoMain['tmp_name'], '../inc/img/index/'.$logoMain['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }