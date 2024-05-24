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
                        <form method="post" action="?page=installationNextNextStep_submit">
                            <div class="mb-3">
                                <h4><b>Instalação - 3/4</b></h4>
                                <p> A aplicação para ser devidamente restrita à escola onde está a ser registada, é necessário que os domínios de email sejam os que a correspondem, portanto, digite o(s) domínio(s) de email que deseja que sejam permitido(s). <br>
                                    <b>ATENÇÃO: Não é necessário todos os campos estarem preenchidos, excluindo o primeiro!</b> <br>
                                    <i>Exemplo: gmail.com</i>
                                </p>
                            </div>
                            <hr>
                            <label for="DomainOneRegister" class="form-label"><b>Variante de Email 1</b></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="DomainOneRegister">@</span>
                                <input type="text" class="form-control" id="DomainOneRegister" name="DomainOneRegister">
                            </div>
                            <label for="DomainTwoRegister" class="form-label"><b>Variante de Email 2</b></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="DomainTwoRegister">@</span>
                                <input type="text" class="form-control" id="DomainTwoRegister" name="DomainTwoRegister">
                            </div>
                            <label for="DomainThreeRegister" class="form-label"><b>Variante de Email 3</b></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="DomainThreeRegister">@</span>
                                <input type="text" class="form-control" id="DomainThreeRegister" name="DomainThreeRegister">
                            </div>
                            <label for="DomainFourRegister" class="form-label"><b>Variante de Email 4</b></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="DomainFourRegister">@</span>
                                <input type="text" class="form-control" id="DomainFourRegister" name="DomainFourRegister">
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