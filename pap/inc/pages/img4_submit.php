<?php
    defined('CONTROL' or die('Access denied'));

    $logoLoginRegister = $_FILES['logoLoginRegister'];

    $logoLoginRegisterHelp = explode('.', $logoLoginRegister['name']);

        if ($logoLoginRegisterHelp[sizeof($logoLoginRegisterHelp)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $logoLoginRegister['name'] = 'logo' . '.png';
            move_uploaded_file($logoLoginRegister['tmp_name'], '../inc/img/login_register/'.$logoLoginRegister['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }