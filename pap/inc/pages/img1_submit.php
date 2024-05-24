<?php
    defined('CONTROL' or die('Access denied'));

    $backgroudMain = $_FILES['backgroundMain'];

        $backgroudMainHelp = explode('.', $backgroudMain['name']);

        if ($backgroudMainHelp[sizeof($backgroudMainHelp)-1] != 'png') {
            $_SESSION['error'] = 'Erro ao editar imagem';
            header("Location: ?page=app_customize");
            exit;
        } else {
            $backgroudMain['name'] = 'main_index' . '.png';
            move_uploaded_file($backgroudMain['tmp_name'], '../inc/img/index/'.$backgroudMain['name']);
            $_SESSION['success'] = 'Imagem Editada';
            header("Location: ?page=app_customize");
            exit;
        }
?>