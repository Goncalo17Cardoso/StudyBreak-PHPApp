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
                        <form method="post" action="?page=installationNextNextNextStep_submit">
                            <div class="mb-3">
                                <h4><b>Instalação - 4/4</b></h4>
                                <p> Já está quase a acabar! Por fim, falta apenas inserir a hora de começo de todos os intervalos, almoços e também a hora limite em que um utilizador/aluno pode fazer a uma reserva de algum almoço. <br>
                                <i>Exemplo: 10:30</i></p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="PauseOne" class="form-label"><b>1º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseOne" name="PauseOne" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseTwo" class="form-label"><b>2º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseTwo" name="PauseTwo" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseThree" class="form-label"><b>3º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseThree" name="PauseThree" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseFour" class="form-label"><b>4º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseFour" name="PauseFour" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseFive" class="form-label"><b>5º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseFive" name="PauseFive" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseSix" class="form-label"><b>6º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseSix" name="PauseSix" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="PauseSeven" class="form-label"><b>7º Intervalo</b></label>
                                <input type="text" class="form-control" id="PauseSeven" name="PauseSeven" maxlength="5">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="LunchOne" class="form-label"><b>1ª Hora de Almoço</b></label>
                                <input type="text" class="form-control" id="LunchOne" name="LunchOne" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="LunchTwo" class="form-label"><b>2ª Hora de Almoço</b></label>
                                <input type="text" class="form-control" id="LunchTwo" name="LunchTwo" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <label for="LunchLimit" class="form-label"><b>Hora Limite de Marcação</b></label>
                                <input type="text" class="form-control" id="LunchLimit" name="LunchLimit" maxlength="5">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn-login-register rounded px-5 py-2 my-2"><b>Finalizar</b></button>
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