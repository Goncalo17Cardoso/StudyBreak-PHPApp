<?php
defined('CONTROL' or die('access denied'));

$db = new database();

$lastReservations = $db->lastReservationsAdmin();
$forDelivery = $db->reservationForDelivery();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="shadow p-3 my-4 mx-4 bg-body-reservations rounded">
                <div class="text-title-reservations-admin text-center">
                    <b>Reservas</b>
                </div>
                <hr class="titles-underline-admin mx-auto mb-3">
                <div class="overflow-auto" style="max-height: 300px;">
                    <?php
                    if ($lastReservations['affectedRows'] == 0) {
                        echo '<div class="text-center"> Nenhuma reserva por feita... </div>';
                    }

                    $i = 0;
                    if ($lastReservations['affectedRows'] != 0) {
                        echo '<div class="overflow-auto" style="max-height: 300px;">';
                        while ($lastReservations['affectedRows'] != $i) {
                    ?>
                            <div class="mb-3">
                                <div class="card my-2">
                                    <div class="card-header">
                                        <?= $lastReservations['data'][$i]->tipoMarcacao . " - " . $lastReservations['data'][$i]->dataCompleta . " - " . $lastReservations['data'][$i]->hora ?>
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
                    } ?>
                </div>
                <!-- <button type="button" class="mx-1 mt-4 btn-admin-edit-objective rounded p-2" data-bs-toggle="modal" data-bs-target="#addReservation">
                    Adicionar Reserva
                </button>
                <div class="modal fade" id="addReservation" tabindex="-1" aria-labelledby="addReservationLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addReservationLabel">Adicionar Reserva</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="?page=addreservation_submit" method="post">
                                    <div class="mb-3">
                                        <label for="addReservation-email" class="form-label">Nome do Utilizador</label>
                                        <input type="email" class="form-control" id="addReservation-email" value="<?= $_SESSION['name'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addReservation-email" class="form-label">Nome do Utilizador</label>
                                        <input type="email" class="form-control" id="addReservation-email" value="<?= $_SESSION['name'] ?>" disabled>
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar novo objetivo</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <?php
            if ($lastReservations['affectedRows'] == 0) {
            ?>
                <a href="?page=temp2">Inserir dados</a>
            <?php
            }
            ?>
        </div>
        <div class="col-12 col-md-6">
            <div class="shadow p-3 my-4 mx-4 bg-body-reservations rounded">
                <div class="text-title-reservations-admin text-center">
                    <b>Confirmar Reserva</b>
                </div>
                <hr class="titles-underline-admin mx-auto mb-3">
                <div class="overflow-auto" style="max-height: 300px;">
                    <?php
                    if ($forDelivery['affectedRows'] == 0) {
                        echo '<div class="text-center"> Nenhuma reserva por confirmar... </div>';
                    }

                    $i = 0;
                    while ($i != $forDelivery['affectedRows']) {
                    ?>
                        <div class="card my-2">
                            <div class="card-body mb-4">
                                <h5 class="card-title"><?= $forDelivery['data'][$i]->dataCompleta ?> | <?= $forDelivery['data'][$i]->hora ?> | <?= $forDelivery['data'][$i]->nomeUtilizador ?> - <a href="?page=delete_reservation&reservationId=<?= $forDelivery['data'][$i]->idMarcacao ?>"><i class="bi bi-trash3-fill"></i></a> | <a href="?page=confirm_delivery_reservation&reservationId=<?= $forDelivery['data'][$i]->idMarcacao ?>"><i class="bi bi-check-circle-fill"></i></a> </h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <?php
                                        if ($forDelivery['data'][$i]->tipoMarcacao == 'menu') {
                                            echo "<b> Menu - " . $forDelivery['data'][$i]->total . "€</b>";
                                        } else if ($forDelivery['data'][$i]->tipoMarcacao == 'almoco') {
                                            echo "<b> Almoço - " . $forDelivery['data'][$i]->total . "€</b> <br>";
                                            echo "<b>Sopa: </b>" . $forDelivery['data'][$i]->nomeSopa . "<br>";
                                            echo "<b>Prato: </b>" . $forDelivery['data'][$i]->nomePrato . "<br>";
                                            echo "<b>Bebida: </b>" . $forDelivery['data'][$i]->nomeBebida . "<br>";
                                            echo "<b>Sobremesa: </b>" . $forDelivery['data'][$i]->nomeSobremesa . "<br>";
                                        } else {
                                            echo "<b> Lanche/Bebida - " . $forDelivery['data'][$i]->total . "€</b><br>";
                                            echo $forDelivery['data'][$i]->nomeProdutoLanche;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
                    } ?>
                </div>
            </div>
        </div>