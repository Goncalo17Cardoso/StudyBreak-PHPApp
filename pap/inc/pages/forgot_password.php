<?php
defined('CONTROL') or die('Access denied');

$show_warning = $_SESSION['warning'] ?? null;
$show_error = $_SESSION['error'] ?? null;
unset($_SESSION['warning']);
unset($_SESSION['error']);

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
                            <form method="post" action="?page=forgot_password_submit">
                                <div>
                                    <center>
                                        <img src="../inc/img/login_register/logo.png" class="img-fluid w-50 p-2">
                                    </center>
                                </div>
                                <div class="mb-3">
                                    <label for="EmailLogin" class="form-label"><b>Email da conta</b></label>
                                    <input type="email" class="form-control" id="EmailLogin" name="emailfpass">
                                </div>
                                <button type="submit" class="btn-login-register rounded px-5 py-2 my-3"><b>Recuperar Palavra-Passe</b></button>
                            </form>  
                            <?= $show_warning ?>
                            <?= $show_error ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-3"></div>
                </div>
            </div>
        </div>
    </main>
