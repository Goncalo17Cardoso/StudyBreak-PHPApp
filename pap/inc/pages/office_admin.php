<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$d=strtotime("today");
$ActualMonthObjective = date("m", $d);

$showObjective = $db->showObjective($_SESSION['id']);
$totalMoneyMonth = $db->actualMoneyMonthObjective();
$lastReservations = $db->lastReservationsAdmin();

$calc = ($totalMoneyMonth['data']['0']->total / $showObjective['data']['0']->objetivo) * 100;
$progressBar = round($calc, 2);
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="text-greetings-admin mx-5 mt-5 mb-3">
                    <?php if (date("H") <= 12) : ?>
                        <b>Bom dia, <br><?= $_SESSION['name'] ?></b>
                    <?php elseif (date("H") <= 19) : ?>
                        <b>Boa tarde, <br><?= $_SESSION['name'] ?></b>
                    <?php else : ?>
                        <b>Boa noite, <br><?= $_SESSION['name'] ?></b>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="month-objective-admin mx-5 my-3">
                    <b>Objetivo mensal - <?= $showObjective['data']['0']->objetivo ?>€</b>
                    <div class="progress my-2" role="progressbar">
                        <div class="progress-bar bg-warning text-dark" style="width: <?=$progressBar?>%"></div>
                        <b><?=$progressBar?>%</b>
                    </div>
                </div>
                <button type="button" class="mx-5 my-1 btn-admin-edit-objective rounded p-2" data-bs-toggle="modal" data-bs-target="#editObjective">
                    Editar Objetivo
                </button>
                <div class="modal fade" id="editObjective" tabindex="-1" aria-labelledby="editObjectiveLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editObjectiveLabel">Alterar Objetivo Mensal</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="?page=objective_submit" method="post">
                                    <input type="number" id="newObjective" name="newObjective" class="form-control" placeholder="Qual vai ser o seu objetivo deste mês">
                                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar novo objetivo</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="title-office-last-reservations text-center mt-5 my-3">
                    <b>Últimas Reservas</b>
                </div>
                <?php
                if ($lastReservations['affectedRows'] == 0) {
                    echo "Ainda não foram feitas reservas...";
                }
                $i = 0;
                if ($lastReservations['affectedRows'] != 0) {
                    echo '<div class="overflow-auto" style="max-height: 300px;">';
                while($lastReservations['affectedRows'] != $i) {
                ?>
                <div class="mx-5 mb-3">
                    <div class="card my-2">
                        <div class="card-header">
                            <?=$lastReservations['data'][$i]->tipoMarcacao . " - " . $lastReservations['data'][$i]->dataCompleta . " - " . $lastReservations['data'][$i]->hora?>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                            <?php
                            if ($lastReservations['data'][$i]->tipoMarcacao == 'menu') {
                                echo "<b><h6> Menu" . $lastReservations['data'][$i]->total . "€</h6></b>";
                            } else if ($lastReservations['data'][$i]->tipoMarcacao == 'almoco') {
                                echo "<b><h6>Almoço - " . $lastReservations['data'][$i]->total . "€</h6></b>";
                                echo "<b><h6>Sopa: </b>" . $lastReservations['data'][$i]->nomeSopa . "</h6>";
                                echo "<b><h6>Prato: </b>" . $lastReservations['data'][$i]->nomePrato . "</h6>";
                                echo "<b><h6>Bebida: </b>" . $lastReservations['data'][$i]->nomeBebida . "</h6>";
                                echo "<b><h6>Sobremesa: </b>" . $lastReservations['data'][$i]->nomeSobremesa . "</h6>";
                            } else {
                                echo "<b><h6> Lanche/Bebida - " . $lastReservations['data'][$i]->total . "€</b></h6>";
                                echo "<h6>" . $lastReservations['data'][$i]->nomeProdutoLanche . "</h6>";
                            } ?>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
                } 
                echo "</div>";
            }?>
            </div>
        </div>
    </div>
</main>