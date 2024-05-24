<?php
    defined('CONTROL' or die('Access denied'));

    $db = new database();

    $result = $db->emailDomain();
?>


</body>
<!-- Footer -->
<footer class="mt-auto">
<?php if(!isset($_SESSION['id']) && $result['affectedRows'] == 1) { ?>
        <div class="container-fluid">
            <div class="row py-3">
                <div class="col-12 col-md-3">
                </div>
                <div class="col-12 col-md-2">
                    <img src="../inc/img/footer/logo_footer.png" class="w-75">
                    <br><br><b>
                    &copy; Copyright <?= date("Y");?> . <?= $result['data']['0']->nome ?> <br>
                    Politicas e Direitos <br>
                    Developed by Gonçalo Cardoso</b>
                </div>
                <div class="col-12 col-md-2 p-2">
                    <b><a href="mailto: <?= $result['data']['0']->email ?>">Enviar Email</a></b> <br>
                    <b><a href="tel:+351 <?= $result['data']['0']->telefone ?>">+351 <?= $result['data']['0']->telefone ?></a> (Rede fixa nacional) </b> <br>
                    <b><a href="tel:+351 <?= $result['data']['0']->telemovel ?>">+351 <?= $result['data']['0']->telemovel ?></a> (Rede móvel nacional) </b> <br><br>
                    <b> <?= $result['data']['0']->localizacao ?> </b>
                </div>
                <div class="col-12 col-md-2">
                    <div class="row">
                        <div class="col-12 col-md-12 text-center">
                            <a href="<?= $result['data']['0']->instagram ?>"><i class="bi bi-instagram mx-2"></i></a>
                            <a href="<?= $result['data']['0']->facebook ?>"><i class="bi bi-facebook mx-2"></i></a>
                            <a href="<?= $result['data']['0']->linkedIn ?>"><i class="bi bi-linkedin mx-2"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 text-center">
                            <a href="<?= $result['data']['0']->whatsapp ?>"><i class="bi bi-whatsapp mx-2"></i></a>
                            <a href="<?= $result['data']['0']->youtube ?>"><i class="bi bi-youtube mx-2"></i></a>
                        </div>
                    </div> 
                </div>
                <div class="col-12 col-md-3">
                </div>
            </div>
        </div>
    <?php } else if(isset($_SESSION['id']) && $result['affectedRows'] == 1) { ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4"></div>
                <div class="col-12 col-md-4 text-center p-4">
                    <b>&copy; Copyright <?= date("Y");?> . <?= $result['data']['0']->nome ?></b>
                </div>
                <div class="col-12 col-md-4"></div>
            </div>
        </div>
        <?php } ?>
    </footer> 
    <!-- Java Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- LOADING SCREEN -->
    <div class="loader"></div>
    <script src="../inc/js/loader.js"></script>
    <!-- SCROLL ANIMATION-->
    <script src="../inc/js/scroll.js"></script>
</body class="d-flex flex-column min-vh-100">
</html>