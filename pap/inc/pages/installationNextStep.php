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
                </div>
                <div class="col-12 col-md-6">
                    <div class="shadow p-3 mb-5 bg-body-login-register rounded my-5">
                        <form method="post" action="?page=installationNextStep_submit">
                            <div class="mb-3">
                                <h4><b>Instalação - 2/4</b></h4>
                                <p> Agora está na hora de preencher os diversos campos abaixo com as devidas informações pedidas.</p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="NameRegister" class="form-label"><b>Nome da Escola</b></label>
                                <input type="text" class="form-control" id="NameRegister" name="NameRegister">
                            </div>
                            <div class="mb-3">
                                <label for="EmailRegister" class="form-label"><b>Email da Escola</b></label>
                                <input type="email" class="form-control" id="EmailRegister" name="EmailRegister">
                            </div>
                            <div class="mb-3">
                                <label for="fixPhoneRegister" class="form-label"><b>Telefone fixo da Escola</b></label>
                                <input type="text" class="form-control" id="fixPhoneRegister" name="fixPhoneRegister" maxlength="9" onkeypress="permitirApenasNumeros(event)">
                            </div>
                            <div class="mb-3">
                                <label for="phoneRegister" class="form-label"><b>Telémovel da Escola</b></label>
                                <input type="text" class="form-control" id="phoneRegister" name="phoneRegister" maxlength="9" onkeypress="permitirApenasNumeros(event)">
                            </div>
                            <div class="mb-3">
                                <label for="addressRegister" class="form-label"><b>Morada da Escola</b></label>
                                <input type="text" class="form-control" id="addressRegister" name="addressRegister">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn-login-register rounded px-5 py-2 my-2"><b>Continuar</b></button>
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