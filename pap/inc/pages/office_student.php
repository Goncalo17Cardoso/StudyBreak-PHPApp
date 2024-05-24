<?php
defined('CONTROL') or die('Access denied');

$db = new database();

$lastReservations = $db->lastReservationsUser($_SESSION['id']);
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
                            echo "<b> Almoço - " . $userCartList['data'][$i]->total . "€ <br></b>";
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

<main class="h-100">
    <div id="wrapper-main-office-part1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="text-greetings-office mx-5 my-5">
                        <?php if (date("H") <= 12) : ?>
                            <b>Bom dia, <br><?= $_SESSION['name'] ?></b>
                        <?php elseif (date("H") <= 19) : ?>
                            <b>Boa tarde, <br><?= $_SESSION['name'] ?></b>
                        <?php else : ?>
                            <b>Boa noite, <br><?= $_SESSION['name'] ?></b>
                        <?php endif; ?>
                        <br>Faça a sua reserva
                        <br><br><br>
                        <h1 id="clock"></h1>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="title-office-last-reservations text-center mt-5 my-3">
                        <b>Últimas Reservas</b> <br>
                    <?php  
                        if ($lastReservations['affectedRows'] == 0) {
                            echo "Nenhuma reserva feita ainda...";
                        } 
                    echo '</div>';
                        if ($lastReservations['affectedRows'] != 0) {
                            echo '<div class="overflow-auto" style="max-height: 200px;">';
                    ?>
                        <div class="list-office-last-reservations mx-5 mb-5">
                            <ul class="list-group">
                                <?php
                                for ($i = 0; $i < $lastReservations['affectedRows']; $i++) {
                                ?>
                                    <li class="list-group-item"><?= $lastReservations['data'][$i]->tipoMarcacao ?> | <?= $lastReservations['data'][$i]->dataCompleta ?> - <?= $lastReservations['data'][$i]->hora ?> - <?= $lastReservations['data'][$i]->total ?>€</li>
                                <?php
                                } 
                                echo "</div>";
                                } ?>
                            </ul>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>