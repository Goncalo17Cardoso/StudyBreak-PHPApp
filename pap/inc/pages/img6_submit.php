<?php
    defined('CONTROL' or die('Access denied'));

    $faviconGeneral = $_FILES['faviconGeneral'];

    $faviconGeneralHelp = explode('.', $faviconGeneral['name']);

        if ($faviconGeneralHelp[sizeof($faviconGeneral)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $faviconGeneral['name'] = 'favicon' . '.png';
            move_uploaded_file($faviconGeneral['tmp_name'], '../inc/img/'.$faviconGeneral['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }