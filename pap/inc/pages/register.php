<?php
defined('CONTROL') or die('Access denied');

$show_error = $_SESSION['error'] ?? null;

unset($_SESSION['error']);
?>

<script>
    function permitirApenasNumeros(event) {
        const keyCode = event.keyCode;
        if ((keyCode < 48 || keyCode > 57) && keyCode !== 8 && keyCode !== 9 && keyCode !== 37 && keyCode !== 39) {
            event.preventDefault();
        }
    }
</script>
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
                        <form method="post" action="?page=register_submit">
                            <div>
                                <center>
                                    <img src="../inc/img/login_register/logo.png" class="img-fluid w-50 p-2">
                                </center>
                            </div>
                            <div class="mb-3">
                                <label for="NameRegister" class="form-label"><b>Nome completo <i class="text-danger">*</i></b></label>
                                <input type="text" class="form-control" id="NameRegister" name="NameRegister">
                            </div>
                            <div class="mb-3">
                                <label for="EmailRegister" class="form-label"><b>Email <i class="text-danger">*</i></b></label>
                                <input type="email" class="form-control" id="EmailRegister" name="EmailRegister">
                            </div>
                            <div class="mb-3">
                                <label for="PassRegister" class="form-label"><b>Palavra-Passe <i class="text-danger">*</i></b></label>
                                <input type="password" class="form-control" id="PassRegister" name="PassRegister">
                            </div>
                            <div class="mb-3">
                                <label for="PassRegister2" class="form-label"><b>Confirmar Palavra-Passe <i class="text-danger">*</i></b></label>
                                <input type="password" class="form-control" id="PassRegisterConfirmation" name="PassRegisterConfirmation">
                            </div>
                            <div class="mb-3">
                                <label for="PhoneRegister" class="form-label"><b>Número Telemóvel <i class="text-danger">*</i></b></label>
                                <input type="text" class="form-control" id="PhoneRegister" name="PhoneRegister" maxlength="9" onkeypress="permitirApenasNumeros(event)">
                            </div>
                            <div class="mb-3">
                                <label for="TypeRegister" class="form-label"><b>Tipo de Utilizador <i class="text-danger">*</i></b></label> <br>
                                <input type="radio" class="btn-check" name="TypeUser" id="aluno" value="Aluno" autocomplete="off">
                                <label class="btn btn-light" for="aluno">Aluno</label>
                                <input type="radio" class="btn-check" name="TypeUser" id="prof-func" value="Professor/Funcionario" autocomplete="off">
                                <label class="btn btn-light" for="prof-func">Professor/Funcionário</label>
                            </div>
                            <div class="mb-3">
                                <label for="NIFRegister" class="form-label"><b>NIF</b></label>
                                <input type="text" class="form-control" id="NIFRegister" name="NIFRegister" maxlength="9" onkeypress="permitirApenasNumeros(event)">
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