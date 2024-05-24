<?php
defined('CONTROL') or die('Access denied');

$show_error = $_SESSION['error'] ?? null;
$show_warning = $_SESSION['warning'] ?? null;
$show_last_email = $_SESSION['last_email'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['warning']);
unset($_SESSION['last_email']);

?>

<main>
    <div class="wrapper-division-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 my-3">
                    <a href="?page=main" class="btn-addproducts-admin rounded px-5 py-2 mt-3">
                        Voltar
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <div class="shadow p-3 mb-5 bg-body-login-register rounded my-5">
                        <form method="post" action="?page=login_submit">
                            <div>
                                <center>
                                    <img src="../inc/img/login_register/logo.png" class="img-fluid w-50 p-2">
                                </center>
                            </div>
                            <div class="mb-3">
                                <label for="EmailLogin" class="form-label"><b>Email</b></label>
                                <input type="email" class="form-control" id="EmailLogin" name="email" value="<?= $show_last_email ?>">
                            </div>
                            <div class="mb-3">
                                <label for="PassLogin" class="form-label"><b>Palavra-Passe</b></label>
                                <input type="password" class="form-control" id="PassLogin" name="password">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <a href="?page=register"><b>Criar uma conta!</b></a><br>
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="?page=forgot_password"><b>Esqueceu-se da Palavra-Passe?</b></a>
                                </div>
                            </div>
                            <button type="submit" class="btn-login-register rounded px-5 py-2 my-3"><b>Entrar</b></button>
                        </form>
                            <?php if (isset($show_error)) { ?>
                                <div class="alert alert-danger mx-5 text-center" role="alert">
                                    <div class="text-danger"><i><?= $show_error; ?></i></div>
                                </div>
                            <?php } ?>
                            <?php if (isset($show_warning)) { ?>
                            <div class="alert alert-warning mx-5 text-center" role="alert">
                                <div class="text-warning"><i><?= $show_warning; ?></i></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-md-3"></div>
            </div>
        </div>
    </div>
</main>