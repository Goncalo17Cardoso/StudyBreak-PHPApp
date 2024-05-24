<?php 
    defined('CONTROL') or die('Access denied');

    $db = new database();

    $emails = $db->emailDomain();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ?p=404');
        exit;
    }

    $name = $_POST['NameRegister'] ?? null;
    $email = $_POST['EmailRegister'] ?? null;
    $password = $_POST['PassRegister'] ?? null;
    $passwordConfirm = $_POST['PassRegisterConfirmation'] ?? null;
    $phone = $_POST['PhoneRegister'] ?? null;
    $typeUser = $_POST['TypeUser'] ?? null;
    $nif = $_POST['NIFRegister'] ?? null;

    if (empty($email) || empty($name) || empty($password) || empty($passwordConfirm) || empty($phone)
       || empty($typeUser)) {
        $_SESSION['error'] = 'Por favor, preencha todos os campos!';
        header('Location: ?page=register');
        exit;
    }

    $email_confirms = [
        $emails['data']['0']->emailSufixoUm,
        $emails['data']['0']->emailSufixoDois,
        $emails['data']['0']->emailSufixoTres,
        $emails['data']['0']->emailSufixoQuatro,
    ];

    $email_domain = explode("@",$_POST['EmailRegister'])[1];

    $ruizcosta_confirmed = in_array($email_domain,$email_confirms);
    if ($ruizcosta_confirmed == false) {
        $_SESSION['error'] = 'Este email não pertence à instituição registada!';
        header('Location: ?page=register');
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['error'] = "A palavras-passe tem que ter no mínimo 8 caracteres!";
        header('Location: ?page=register');
        exit;
    }

    if ($password != $passwordConfirm) {
        $_SESSION['error'] = "As palavras-passes não coincidem!";
        header('Location: ?page=register');
        exit;
    }

    if(strlen($phone) < 9) {
        $_SESSION['error'] = "O número de telemóvel deve ter pelo menos 9 digitos!";
        header('Location: ?page=register');
        exit;
    }
    
    if ($nif != null) {
        if(strlen($nif) < 9) {
            $_SESSION['error'] = "O seu NIF deve ter pelo menos 9 digitos!";
            header('Location: ?page=register');
            exit;
        }    
    } else {
        $nif = 0;
    }

    $db = new database();   
    $utils = new utils();

    $email_link = $utils->generateLink();

    $result = $db->signup($email, $name, $password, $phone, $typeUser, $nif, $email_link);

    if ($result['status'] == 'error') {
        $_SESSION['error'] = "Erro ao Registar! Tente novamente.";
        header('Location: ?page=register');
        exit();
    } else {
        $_SESSION['warning'] = "Confirme a sua conta no seu email!";
        $message = '<p>Clique <a href="http://localhost/pap/public/?page=activate_account&code=' . $email_link . '">aqui</a> para ativar a sua conta!</p>';
        $utils->sendEmail('StudyBreak eRC', GMAIL_EMAIL, $name, $email, 'Ativar Conta', $message);
        header('Location: ?page=login');
        exit();
    }
?>