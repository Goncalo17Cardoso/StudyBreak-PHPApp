<?php
defined('CONTROL') or die('Access denied');

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

$app = $db->emailDomain();

$resultSoup = $db->selectSoup();
$resultFood = $db->selectFood();
$resultDessert = $db->selectDessert();
$resultDrink = $db->selectDrink();

$todayDate = new DateTime();
$resultMonday = $db->showMenuDate($weekDates[0]);
$resultTuesday = $db->showMenuDate($weekDates[1]);
$resultWednesday = $db->showMenuDate($weekDates[2]);
$resultThursday = $db->showMenuDate($weekDates[3]);
$resultFriday = $db->showMenuDate($weekDates[4]);

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
                        echo "<b>Sopa: </b>" .$userCartList['data'][$i]->nomeSopa . "<br>";
                        echo "<b>Prato: </b>" .$userCartList['data'][$i]->nomePrato . "<br>";
                        echo "<b>Bebida: </b>" .$userCartList['data'][$i]->nomeBebida . "<br>";
                        echo "<b>Sobremesa: </b>" .$userCartList['data'][$i]->nomeSobremesa . "<br>";
                    } else {
                        echo "<b> Lanche/Bebida - " . $userCartList['data'][$i]->total . "€</b><br>";
                        echo $userCartList['data'][$i]->nomeProdutoLanche;
                    } ?>
                </div>
            </div>
        </div>
        <?php $i++; } ?>
        <form action="?page=confirm_cart" method="post">
            <button type="submit" class="btn-profile-student rounded p-2">Pagamento ao Balcão</button>
        </form>
    </div>
</div>

<main>
    <div class="container-fluid">
        <form action="?page=lunch_submit" method="post">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mx-5 my-5 text-center text-lunch-student">
                                Qual vai <br>
                                ser <b>o seu <br>
                                    almoço? </b><i class="bi bi-stars"></i>
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
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mx-5 my-2 text-center text-date-lunch-student">
                                Para quando deseja reservar o almoço? <i class="bi bi-calendar3"></i>
                            </div>
                            <div class="mx-5 my-3 text-center">
                                <input type="radio" class="btn-check" name="date" id="date1" value="<?= $weekDates[0]; ?>" autocomplete="off" <?php if (date("Y-m-d") >= $weekDates[0] && $hourNOW >= $app['data'][0]->horaLimite) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                } ?>>
                                <label class="btn btn-light" for="date1"><?= $weekDatesShow[0]; ?></label>
                                <input type="radio" class="btn-check" name="date" id="date2" value="<?= $weekDates[1]; ?>" autocomplete="off" <?php if (date("Y-m-d") >= $weekDates[1] && $hourNOW >= $app['data'][0]->horaLimite) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                } ?>>
                                <label class="btn btn-light" for="date2"><?= $weekDatesShow[1]; ?></label>
                                <input type="radio" class="btn-check" name="date" id="date3" value="<?= $weekDates[2]; ?>" autocomplete="off" <?php if (date("Y-m-d") >= $weekDates[2] && $hourNOW >= $app['data'][0]->horaLimite) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                } ?>>
                                <label class="btn btn-light" for="date3"><?= $weekDatesShow[2]; ?></label>
                                <input type="radio" class="btn-check" name="date" id="date4" value="<?= $weekDates[3]; ?>" autocomplete="off" <?php if (date("Y-m-d") >= $weekDates[3] && $hourNOW >= $app['data'][0]->horaLimite) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                } ?>>
                                <label class="btn btn-light" for="date4"><?= $weekDatesShow[3]; ?></label>
                                <input type="radio" class="btn-check" name="date" id="date5" value="<?= $weekDates[4]; ?>" autocomplete="off" <?php if (date("Y-m-d") >= $weekDates[4] && $hourNOW >= $app['data'][0]->horaLimite) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                } ?>>
                                <label class="btn btn-light" for="date5"><?= $weekDatesShow[4]; ?></label>
                            </div>
                            <div class="mx-5 my-3 text-center">
                                <input type="radio" class="btn-check" name="hours" id="hours1" value="<?=$app['data']['0']->horaAlmocoUm ?>" autocomplete="off">
                                <label class="btn btn-light" for="hours1"><?=$app['data']['0']->horaAlmocoUm ?></label>
                                <input type="radio" class="btn-check" name="hours" id="hours2" value="<?=$app['data']['0']->horaAlmocoDois ?>" autocomplete="off">
                                <label class="btn btn-light" for="hours2"><?=$app['data']['0']->horaAlmocoDois ?></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mx-5 my-3 text-center text-date-lunch-student">
                        Hora de escolher o que vai almoçar <i class="bi bi-bookmarks-fill"></i>
                    </div>
                    <div class="mx-5 my-3">
                        <div class="text-center">
                            <button type="button" class="btn-lunch-student rounded p-2" data-bs-toggle="modal" data-bs-target="#selectLunch">
                                Selecionar almoço
                            </button>
                        </div>
                        <div class="modal fade" id="selectLunch" tabindex="-1" aria-labelledby="selectLunchLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectLunchLabel">Selecione o seu almoço</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="d-inline-flex gap-1">
                                            <button class="btn-addproducts-admin rounded p-2" type="button" data-bs-toggle="collapse" data-bs-target="#chooseLunch" aria-expanded="false" aria-controls="collapseExample">
                                                Almoço à escolha
                                            </button>
                                            <button class="btn-addproducts-admin rounded p-2" type="button" data-bs-toggle="collapse" data-bs-target="#chooseMenu" aria-expanded="false" aria-controls="collapseExample">
                                                Menu
                                            </button>
                                        </p>
                                        <div class="collapse" id="chooseLunch">
                                            <div class="card card-body">
                                                <label for="soupMonday" class="form-label my-2"><b>Escolher sopa</b></label>
                                                <select class="form-select" name="selectSoup">
                                                    <option value="" selected>Não Desejo</option>
                                                    <?php
                                                    $i = 0;
                                                    while ($i != $resultSoup['affectedRows']) { ?>
                                                        <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                    <?php $i++;
                                                    } ?>
                                                </select>
                                                <label for="foodMonday" class="form-label my-2"><b>Escolher prato</b></label>
                                                <select class="form-select" name="selectFood">
                                                    <option value="" selected>Não Desejo</option>
                                                    <?php
                                                    $i = 0;
                                                    while ($i != $resultFood['affectedRows']) { ?>
                                                        <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                    <?php $i++;
                                                    } ?>
                                                </select>
                                                <label for="dessertMonday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                                <select class="form-select" name="selectDessert">
                                                    <option value="" selected>Não Desejo</option>
                                                    <?php
                                                    $i = 0;
                                                    while ($i != $resultDessert['affectedRows']) { ?>
                                                        <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                    <?php $i++;
                                                    } ?>
                                                </select>
                                                <label for="drinkMonday" class="form-label my-2"><b>Escolher bebida</b></label>
                                                <select class="form-select" name="selectDrink">
                                                    <option value="" selected>Não Desejo</option>
                                                    <?php
                                                    $i = 0;
                                                    while ($i != $resultDrink['affectedRows']) { ?>
                                                        <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                    <?php $i++;
                                                    } ?>
                                                </select>
                                                <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Adicionar ao carrinho</b></button>
                                            </div>
                                        </div>
                                        <div class="collapse" id="chooseMenu">
                                            <div class="card card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="chooseMenuYN" name="chooseMenuYN">
                                                    <label class="form-check-label" for="chooseMenuYN"><b>Desejo o menu</b></label>
                                                </div>
                                                <div class="card w-100 mt-3 mb-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Segunda-feira | <?= $weekDates[0]; ?></h5>
                                                        <hr>
                                                        <?php
                                                        if ($resultMonday['affectedRows'] == 0) {
                                                            echo '<div class="alert alert-danger my-1" role="alert">';
                                                            echo '    <div class="text-danger">Menu indisponível de momento!</div>';
                                                            echo '</div>';
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultMonday['data'][0]->nomeSopa ?></div>
                                                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultMonday['data'][0]->nomePrato ?></div>
                                                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultMonday['data'][0]->nomeBebida ?></div>
                                                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultMonday['data'][0]->nomeSobremesa ?></div>
                                                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultMonday['data'][0]->preco . "€" ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="card w-100 mt-3 mb-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Terça-feira | <?= $weekDates[1]; ?></h5>
                                                        <hr>
                                                        <?php
                                                        if ($resultTuesday['affectedRows'] == 0) {
                                                            echo '<div class="alert alert-danger my-1" role="alert">';
                                                            echo '    <div class="text-danger">Menu indisponível de momento!</div>';
                                                            echo '</div>';
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultTuesday['data'][0]->nomeSopa ?></div>
                                                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultTuesday['data'][0]->nomePrato ?></div>
                                                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultTuesday['data'][0]->nomeBebida ?></div>
                                                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultTuesday['data'][0]->nomeSobremesa ?></div>
                                                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultTuesday['data'][0]->preco . "€" ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="card w-100 mt-3 mb-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Quarta-feira | <?= $weekDates[2]; ?></h5>
                                                        <hr>
                                                        <?php
                                                        if ($resultWednesday['affectedRows'] == 0) {
                                                            echo '<div class="alert alert-danger my-1" role="alert">';
                                                            echo '    <div class="text-danger">Menu indisponível de momento!</div>';
                                                            echo '</div>';
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultWednesday['data'][0]->nomeSopa ?></div>
                                                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultWednesday['data'][0]->nomePrato ?></div>
                                                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultWednesday['data'][0]->nomeBebida ?></div>
                                                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultWednesday['data'][0]->nomeSobremesa ?></div>
                                                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultWednesday['data'][0]->preco . "€" ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="card w-100 mt-3 mb-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Quinta-feira | <?= $weekDates[3]; ?></h5>
                                                        <hr>
                                                        <?php
                                                        if ($resultThursday['affectedRows'] == 0) {
                                                            echo '<div class="alert alert-danger my-1" role="alert">';
                                                            echo '    <div class="text-danger">Menu indisponível de momento!</div>';
                                                            echo '</div>';
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultThursday['data'][0]->nomeSopa ?></div>
                                                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultThursday['data'][0]->nomePrato ?></div>
                                                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultThursday['data'][0]->nomeBebida ?></div>
                                                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultThursday['data'][0]->nomeSobremesa ?></div>
                                                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultThursday['data'][0]->preco . "€" ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="card w-100 mt-3 mb-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Sexta-feira | <?= $weekDates[4]; ?></h5>
                                                        <hr>
                                                        <?php
                                                        if ($resultFriday['affectedRows'] == 0) {
                                                            echo '<div class="alert alert-danger my-1" role="alert">';
                                                            echo '    <div class="text-danger">Menu indisponível de momento!</div>';
                                                            echo '</div>';
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultFriday['data'][0]->nomeSopa ?></div>
                                                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultFriday['data'][0]->nomePrato ?></div>
                                                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultFriday['data'][0]->nomeBebida ?></div>
                                                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultFriday['data'][0]->nomeSobremesa ?></div>
                                                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultFriday['data'][0]->preco . "€" ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Adicionar ao carrinho</b></button>
                                            </div>
                                        </div>
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