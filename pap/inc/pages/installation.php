<?php
    defined('CONTROL') or die('Access denied');

    $show_error = $_SESSION['error'] ?? null;

    unset($_SESSION['error']);
?>

<main>
    <div class="wrapper-division-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 my-3">
                </div>
                <div class="col-12 col-md-6">
                    <div class="shadow p-3 mb-5 bg-body-login-register rounded my-5">
                        <form method="post" action="?page=installation_submit">
                            <div class="mb-3">
                                <h4><b>Instalação - 1/4</b></h4>
                                <p> Vamos começar por criar a primeira conta da aplicação. <br>
                                    Esta mesma conta vai ser a responsável pela configuração TOTAL da aplicação.  <br>
                                    <b>ATENÇÃO: O email e palavra-passe desta mesma conta NÃO PODEM SER ALTERADOS!</b></p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="NameRegister" class="form-label"><b>Nome completo</b></label>
                                <input type="text" class="form-control" id="NameRegister" name="NameRegister">
                            </div>
                            <div class="mb-3">
                                <label for="EmailRegister" class="form-label"><b>Email</b></label>
                                <input type="email" class="form-control" id="EmailRegister" name="EmailRegister">
                            </div>
                            <div class="mb-3">
                                <label for="PassRegister" class="form-label"><b>Palavra-Passe</b></label>
                                <input type="password" class="form-control" id="PassRegister" name="PassRegister">
                            </div>
                            <div class="mb-3">
                                <label for="PassRegister2" class="form-label"><b>Confirmar Palavra-Passe</b></label>
                                <input type="password" class="form-control" id="PassRegisterConfirmation" name="PassRegisterConfirmation">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn-login-register rounded px-5 py-2 my-2"><b>Registar</b></button>
                            </div>
                        </form>
                        <?php if (isset($show_error)) { ?>
                            <div class="alert alert-danger mx-5 text-center" role="alert">
                                <div class="text-danger"><i><?= $show_error; ?></i></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-md-3"></div>
            </div>
        </div>
    </div>
</main>