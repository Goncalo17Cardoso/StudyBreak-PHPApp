<?php
defined('CONTROL') or die('Access denied');

$firstDay = strtotime("Monday");
$secondDay = strtotime("Tuesday");
$thirdDay = strtotime("Wednesday");
$fourthDay = strtotime("Thursday");
$fifthDay = strtotime("Friday");

$today = strtotime('today');
$weekDays = date('N', $today);
$daysSinceMonday = $weekDays - 1;
$lastMonday = strtotime("-$daysSinceMonday days", $today);
$weekDates = array();
$weekDatesShow = array();
for ($i = 0; $i < 5; $i++) {
    $weekDates[] = date('Y-m-d', strtotime("+$i days", $lastMonday));
    $weekDatesShow[] = date('d M', strtotime("+$i days", $lastMonday));
}

$hourNOW = date("H:i");

$db = new database();

$resultSnack = $db->selectSnackProducts();

$app = $db->emailDomain();

$show_error = $_SESSION['error'] ?? null;
$show_success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="userCart" aria-labelledby="userCart">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="userCart"><i class="bi bi-cart4"></i> Carrinho</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        $userCartList = $db->userCart($_SESSION['id']);

        $i = 0;
        while ($i != $userCartList['affectedRows']) {
        ?>
            <div class="card-body mb-4">
                <h5 class="card-title"><?= $userCartList['data'][$i]->dataCompleta ?> | <?= $userCartList['data'][$i]->hora ?> - <a href="?page=delete_cart_product&reservationId=<?= $userCartList['data'][$i]->idMarcacao ?>"><i class="bi bi-trash3-fill"></i></a></h5>
                <hr>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <?php
                        if ($userCartList['data'][$i]->tipoMarcacao == 'menu') {
                            echo "<b> Menu - " . $userCartList['data'][$i]->total . "€</b>";
                        } else if ($userCartList['data'][$i]->tipoMarcacao == 'almoco') {
                            echo "<b> Almoço - " . $userCartList['data'][$i]->total . "€</b> <br>";
                            echo "<b>Sopa: </b>" . $userCartList['data'][$i]->nomeSopa . "<br>";
                            echo "<b>Prato: </b>" . $userCartList['data'][$i]->nomePrato . "<br>";
                            echo "<b>Bebida: </b>" . $userCartList['data'][$i]->nomeBebida . "<br>";
                            echo "<b>Sobremesa: </b>" . $userCartList['data'][$i]->nomeSobremesa . "<br>";
                        } else {
                            echo "<b> Lanche/Bebida - " . $userCartList['data'][$i]->total . "€</b><br>";
                            echo $userCartList['data'][$i]->nomeProdutoLanche;
                        } ?>
                    </div>
                </div>
            </div>
        <?php $i++;
        } ?>
        <form action="?page=confirm_cart" method="post">
            <button type="submit" class="btn-profile-student rounded p-2">Pagamento ao Balcão</button>
        </form>
    </div>
</div>

<main>
    <div class="container-fluid">
        <form action="?page=snack_submit" method="post">
            <div class="row">            
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mx-5 my-5 text-center text-snack-student">
                                O que deseja <b>lanchar?</b></b> <i class="bi bi-cup-hot-fill"></i>
                            </div>
                            <?php if (isset($show_error)) { ?>
                                <div class="alert alert-danger my-1" role="alert">
                                    <div class="text-danger text-center"><i><?= $show_error; ?></i></div>
                                </div>
                            <?php } ?>
                            <?php if (isset($show_success)) { ?>
                                <div class="alert alert-success my-1" role="alert">
                                    <div class="text-success text-center"><i><?= $show_success; ?></i></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mx-5 my-2 text-center text-date-snack-student">
                        Para quando deseja reservar o seu lanche? <i class="bi bi-calendar3"></i>
                    </div>
                    <div class="mx-5 my-3 text-center">
                        <input type="radio" class="btn-check" name="date" id="date1" value="<?= $weekDates[0] ?>" autocomplete="off" <?php if (date("Y-m-d") > $weekDates[0]) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                        <label class="btn btn-light" for="date1"><?= $weekDatesShow[0] ?></label>
                        <input type="radio" class="btn-check" name="date" id="date2" value="<?= $weekDates[1] ?>" autocomplete="off" <?php if (date("Y-m-d") > $weekDates[1]) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                        <label class="btn btn-light" for="date2"><?= $weekDatesShow[1] ?></label>
                        <input type="radio" class="btn-check" name="date" id="date3" value="<?= $weekDates[2] ?>" autocomplete="off" <?php if (date("Y-m-d") > $weekDates[2]) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                        <label class="btn btn-light" for="date3"><?= $weekDatesShow[2] ?></label>
                        <input type="radio" class="btn-check" name="date" id="date4" value="<?= $weekDates[3] ?>" autocomplete="off" <?php if (date("Y-m-d") > $weekDates[3]) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                        <label class="btn btn-light" for="date4"><?= $weekDatesShow[3] ?></label>
                        <input type="radio" class="btn-check" name="date" id="date5" value="<?= $weekDates[4] ?>" autocomplete="off" <?php if (date("Y-m-d") > $weekDates[4]) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                        <label class="btn btn-light" for="date5"><?= $weekDatesShow[4] ?></label>
                    </div>
                    <div class="mx-5 my-3 text-center">
                        <input type="radio" class="btn-check" name="hours" id="hours1" value="<?= $app['data']['0']->intervaloUm ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours1"><?= $app['data']['0']->intervaloUm ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours2" value="<?= $app['data']['0']->intervaloDois ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours2"><?= $app['data']['0']->intervaloDois ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours3" value="<?= $app['data']['0']->intervaloTres ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours3"><?= $app['data']['0']->intervaloTres ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours4" value="<?= $app['data']['0']->intervaloQuatro ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours4"><?= $app['data']['0']->intervaloQuatro ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours5" value="<?= $app['data']['0']->intervaloCinco ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours5"><?= $app['data']['0']->intervaloCinco ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours6" value="<?= $app['data']['0']->intervaloSeis ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours6"><?= $app['data']['0']->intervaloSeis ?></label>
                        <input type="radio" class="btn-check" name="hours" id="hours7" value="<?= $app['data']['0']->intervaloSete ?>" autocomplete="off">
                        <label class="btn btn-light" for="hours7"><?= $app['data']['0']->intervaloSete ?></label>
                    </div>
                    <hr>
                    <div class="mx-5 my-3 text-center text-date-snack-student">
                        O que vai comer? <i class="bi bi-bookmarks-fill"></i>
                    </div>
                    <div class="mx-5 mt-3 mb-5 text-center">
                        <button type="button" class="btn-snack-student rounded p-2" data-bs-toggle="modal" data-bs-target="#selectSnack">
                            Selecionar lanche
                        </button>
                        <div class="modal fade" id="selectSnack" tabindex="-1" aria-labelledby="selectSnackLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectSnackLabel">Selecione o seu lanche</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="selectSnack" class="form-label my-2"><b>Lanches/Bebidas</b></label>
                                        <select class="form-select" name="selectSnack">
                                            <option value="" selected>Escolha o seu lanche</option>
                                            <?php
                                            $i = 0;
                                            while ($i != $resultSnack['affectedRows']) { ?>
                                                <option value="<?= $resultSnack['data'][$i]->idProduto; ?>"><?= $resultSnack['data'][$i]->nomeProduto; ?></option>
                                            <?php $i++;
                                            } ?>
                                        </select>
                                        <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Adicionar ao carrinho</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>