<?php
defined('CONTROL') or die('Access denied');

$recover_code = $_GET['code'];
?>     
    
    <main>
        <div class="wrapper-division-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <a href="?page=main" class="btn">
                            Voltar
                        </a>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="shadow p-3 mb-5 bg-body-login-register rounded my-5">
                            <form method="post" action="?page=recover_password_submit&code=<?= $recover_code?>">
                                <div>
                                    <center>
                                        <img src="../inc/img/login_register/logo.png" class="img-fluid w-50 p-2">
                                    </center>
                                </div>
                                <div class="mb-3">
                                    <label for="PasswordRecover" class="form-label"><b>Palavra-Passe de recuperação</b></label>
                                    <input type="password" class="form-control" id="PasswordRecover" name="passwordrecover">
                                </div>
                                <div class="mb-3">
                                    <label for="PasswordRecoverConfirmation" class="form-label"><b>Confirme a Palavra-Passe</b></label>
                                    <input type="password" class="form-control" id="PasswordRecoverConfirmation" name="passwordrecoverconfirmation">
                                </div>
                                <button type="submit" class="btn-login-register rounded px-5 py-2 my-3"><b>Recuperar Palavra-Passe</b></button>
                            </form>  
                        </div>
                    </div>
                    <div class="col-12 col-md-3"></div>
                </div>
            </div>
        </div>
    </main>
