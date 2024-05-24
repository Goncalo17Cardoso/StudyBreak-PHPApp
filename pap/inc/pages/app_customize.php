<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$result = $db->emailDomain();

$show_error = $_SESSION['error'] ?? null;
$show_warning = $_SESSION['warning'] ?? null;
$show_success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['warning']);
unset($_SESSION['success']);
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="mt-3">
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
                    <?php if (isset($show_success)) { ?>
                        <div class="alert alert-success mx-5 text-center" role="alert">
                            <div class="text-succes"><i><?= $show_success; ?></i></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="text-title-app-costumize text-center mt-3">
                    Dominios De Email Permitidos
                </div>
                <hr class="titles-underline-app-costumize mx-auto">
                <form action="?page=email_domain_submit" method="post" class="mx-3">
                    <label class="form-label"><b>Variante de Email 1</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="emailDomain1">@</span>
                        <input type="text" id="emailDomain1" name="emailDomain1" class="form-control" value="<?= $result['data'][0]->emailSufixoUm ?>">
                    </div>
                    <label class="form-label"><b>Variante de Email 2</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="emailDomain2">@</span>
                        <input type="text" id="emailDomain2" name="emailDomain2" class="form-control" value="<?= $result['data'][0]->emailSufixoDois ?>">
                    </div>
                    <label class="form-label"><b>Variante de Email 3</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="emailDomain3">@</span>
                        <input type="text" id="emailDomain3" name="emailDomain3" class="form-control" value="<?= $result['data'][0]->emailSufixoTres ?>">
                    </div>
                    <label class="form-label"><b>Variante de Email 4</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="emailDomain4">@</span>
                        <input type="text" id="emailDomain4" name="emailDomain4" class="form-control" value="<?= $result['data'][0]->emailSufixoQuatro ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Dominios</b></button>
                </form>
            </div>
            <div class="col-12 col-md-6 overflow-auto" style="max-height: 30rem;">
                <div class="text-title-app-costumize text-center mt-3">
                    Imagens Da Aplicação
                </div>
                <hr class="titles-underline-app-costumize mx-auto">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 27em;">
                            <img src="../inc/img/index/main_index.png" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Fundo - Página Principal</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>1920x1080px | 16:9</i></p>
                                <form action="?page=img1_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="backgroundMain" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 27rem;">
                            <img src="../inc/img/index/logo.png" class="card-img-top w-50 mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Logo - Página Principal</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>500x500px | 1:1</i></p>
                                <form action="?page=img2_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="logoMain" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 25rem;">
                            <img src="../inc/img/footer/logo_footer.png" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Logo - Footer</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>250x150px</i></p>
                                <form action="?page=img3_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="logoFooter" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 25rem;">
                            <img src="../inc/img/login_register/logo.png" class="card-img-top w-50 mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Logo - Entrar e Registar</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>500x500px | 1:1</i></p>
                                <form action="?page=img4_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="logoLoginRegister" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 25rem;">
                            <img src="../inc/img/office/office_design.png" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Fundo - Geral</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>1920x1080px | 16:9</i></p>
                                <form action="?page=img5_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="backgroudGeneral" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mx-auto my-3" style="width: 16rem; min-height: 25rem;">
                            <img src="../inc/img/favicon.png" class="card-img-top w-50 mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Favicon - Geral</h5>
                                <p class="card-text">Apenas é aceite imagens <i>.png</i> e com dimensões recomendadas de <i>500x500px | 1:1</i></p>
                                <form action="?page=img6_submit" method="post" enctype="multipart/form-data" class="text-center">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="faviconGeneral" type="file" accept=".png">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-3 py-1"><b>Editar Imagem</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="text-title-app-costumize text-center mt-3">
                    Informações do Footer
                </div>
                <hr class="titles-underline-app-costumize mx-auto">
                <form action="?page=footer_submit" method="post" class="mx-3">
                    <div class="mb-3">
                        <label for="appName" class="form-label"><b>Nome da Aplicação</b></label>
                        <input type="text" class="form-control" id="appName" name="appName" value="<?= $result['data'][0]->nome ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appEmail" class="form-label"><b>Email da Aplicação</b></label>
                        <input type="email" class="form-control" id="appEmail" name="appEmail" value="<?= $result['data'][0]->email ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPhone" class="form-label"><b>Rede Fixa Nacional da Aplicação</b></label>
                        <input type="text" class="form-control" id="appPhone" name="appPhone" maxlength="9" onkeypress="permitirApenasNumeros(event)" value="<?= $result['data'][0]->telefone ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appCellphone" class="form-label"><b>Rede Móvel Nacional da Aplicação</b></label>
                        <input type="text" class="form-control" id="appCellphone" name="appCellphone" maxlength="9" onkeypress="permitirApenasNumeros(event)" value="<?= $result['data'][0]->telemovel ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appLocation" class="form-label"><b>Localização da Aplicação</b></label>
                        <input type="text" class="form-control" id="appLocation" name="appLocation" value="<?= $result['data'][0]->localizacao ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Informações</b></button>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-title-app-costumize text-center mt-3">
                    Links das Redes Sociais
                </div>
                <hr class="titles-underline-app-costumize mx-auto">
                <form action="?page=social_submit" method="post" class="mx-3">
                    <div class="mb-3">
                        <label for="appInstagram" class="form-label"><b>Instagram</b></label>
                        <input type="text" class="form-control" id="appInstagram" name="appInstagram" value="<?= $result['data'][0]->instagram ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appFacebook" class="form-label"><b>Facebook</b></label>
                        <input type="text" class="form-control" id="appFacebook" name="appFacebook" value="<?= $result['data'][0]->facebook ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appLinkedIn" class="form-label"><b>LinkedIn</b></label>
                        <input type="text" class="form-control" id="appLinkedIn" name="appLinkedIn" value="<?= $result['data'][0]->linkedIn ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appWhatsapp" class="form-label"><b>WhatsApp</b></label>
                        <input type="text" class="form-control" id="appWhatsapp" name="appWhatsapp" value="<?= $result['data'][0]->whatsapp ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appYoutube" class="form-label"><b>YouTube</b></label>
                        <input type="text" class="form-control" id="appYoutube" name="appYoutube" value="<?= $result['data'][0]->youtube ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Redes Sociais</b></button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="text-title-app-costumize text-center mt-3">
                    Intervalos entre Aulas
                </div>
                <hr class="titles-underline-app-costumize mx-auto">
                <form action="?page=pauses_submit" method="post" class="mx-3">
                    <div class="mb-3">
                        <label for="appPause1" class="form-label"><b>1º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause1" name="appPause1" value="<?= $result['data'][0]->intervaloUm ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause2" class="form-label"><b>2º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause2" name="appPause2" value="<?= $result['data'][0]->intervaloDois ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause3" class="form-label"><b>3º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause3" name="appPause3" value="<?= $result['data'][0]->intervaloTres ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause4" class="form-label"><b>4º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause4" name="appPause4" value="<?= $result['data'][0]->intervaloQuatro ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause5" class="form-label"><b>5º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause5" name="appPause5" value="<?= $result['data'][0]->intervaloCinco ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause6" class="form-label"><b>6º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause6" name="appPause6" value="<?= $result['data'][0]->intervaloSeis ?>">
                    </div>
                    <div class="mb-3">
                        <label for="appPause7" class="form-label"><b>7º Intervalo</b></label>
                        <input type="text" class="form-control" id="appPause7" name="appPause7" value="<?= $result['data'][0]->intervaloSete ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Intervalos</b></button>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="text-title-app-costumize text-center mt-3">
                            Horas de Almoço
                        </div>
                        <hr class="titles-underline-app-costumize mx-auto">
                        <form action="?page=lunch_hour_submit" method="post" class="mx-3">
                            <div class="mb-3">
                                <label for="appLunch1" class="form-label"><b>1ª Hora de Almoço</b></label>
                                <input type="text" class="form-control" id="appLunch1" name="appLunch1" value="<?= $result['data'][0]->horaAlmocoUm ?>">
                            </div>
                            <div class="mb-3">
                                <label for="appLunch2" class="form-label"><b>2ª Hora de Almoço</b></label>
                                <input type="text" class="form-control" id="appLunch2" name="appLunch2" value="<?= $result['data'][0]->horaAlmocoDois ?>">
                            </div>
                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Almoço</b></button>
                        </form>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="text-title-app-costumize text-center mt-3">
                            Limite de Horas de Reserva
                        </div>
                        <hr class="titles-underline-app-costumize mx-auto">
                        <form action="?page=max_hour_lunch_submit" method="post" class="mx-3">
                            <div class="mb-3">
                                <label for="appHour" class="form-label"><b>Hora de Almoço</b></label>
                                <input type="text" class="form-control" id="appHour" name="appHour" value="<?= $result['data'][0]->horaLimite ?>">
                            </div>
                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 my-3"><b>Editar Almoço</b></button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>