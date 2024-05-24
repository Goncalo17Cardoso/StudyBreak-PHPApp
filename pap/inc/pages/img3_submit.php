<?php
    defined('CONTROL' or die('Access denied'));

    $logoFooter = $_FILES['logoFooter'];

    $logoFooterHelp = explode('.', $logoFooter['name']);

        if ($logoFooterHelp[sizeof($logoFooterHelp)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $logoFooter['name'] = 'logo_footer' . '.png';
            move_uploaded_file($logoFooter['tmp_name'], '../inc/img/footer/'.$logoFooter['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }