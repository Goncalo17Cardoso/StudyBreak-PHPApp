<?php
defined('CONTROL' or die('Access denied'));

$show_error = $_SESSION['error'] ?? null;
$show_success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['success']);

$today = strtotime('today');
$weekDays = date('N', $today);
$daysSinceMonday = $weekDays - 1;
$lastMonday = strtotime("-$daysSinceMonday days", $today);
$weekDates = array();
for ($i = 0; $i < 5; $i++) {
    $weekDates[] = date('Y-m-d', strtotime("+$i days", $lastMonday));
}

$db = new database();

$resultSoup = $db->selectSoup();
$resultFood = $db->selectFoodMenu();
$resultDessert = $db->selectDessert();
$resultDrink = $db->selectDrink();

$resultMonday = $db->showMenuDate($weekDates[0]);
$resultTuesday = $db->showMenuDate($weekDates[1]);
$resultWednesday = $db->showMenuDate($weekDates[2]);
$resultThursday = $db->showMenuDate($weekDates[3]);
$resultFriday = $db->showMenuDate($weekDates[4]);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-2"></div>
        <div class="col-12 col-md-8">
            <div class="shadow p-3 my-3 bg-body-weekmenu rounded">
                <?php if (isset($show_error)) { ?>
                    <div class="alert alert-danger my-1" role="alert">
                        <div class="text-danger"><i><?= $show_error; ?></i></div>
                    </div>
                <?php } ?>
                <?php if (isset($show_success)) { ?>
                    <div class="alert alert-success my-1" role="alert">
                        <div class="text-success"><i><?= $show_success; ?></i></div>
                    </div>
                <?php } ?>
                <div class="card w-100 mt-3 mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Segunda-feira | <?= $weekDates[0]; ?></h5>
                        <hr>
                        <?php
                        if ($resultMonday['affectedRows'] == 0) {
                            echo '<div class="alert alert-danger my-1" role="alert">';
                            echo '    <div class="text-danger">Menu por preencher!</div>';
                            echo '</div>';
                        } else { ?>
                            <div class="row">
                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultMonday['data'][0]->nomeSopa ?></div>
                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultMonday['data'][0]->nomePrato ?></div>
                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultMonday['data'][0]->nomeBebida ?></div>
                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultMonday['data'][0]->nomeSobremesa ?></div>
                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultMonday['data'][0]->preco . "€" ?></div>
                            </div>
                        <?php }
                        ?>
                        <button type="button" class="btn-lunch-student rounded p-2 mt-3" data-bs-toggle="modal" data-bs-target="#selectMenuMonday">
                            Editar Menu
                        </button>
                        <div class="modal fade" id="selectMenuMonday" tabindex="-1" aria-labelledby="selectMenuMonday" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectMenuMonday">Editar menu - <?= $weekDates[0]; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=weekmenu_submit&date=<?= $weekDates[0]; ?>" method="post">
                                            <label for="soupMonday" class="form-label my-2"><b>Escolher sopa</b></label>
                                            <select class="form-select" name="menuSoup">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultSoup['affectedRows']) { ?>
                                                    <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="foodMonday" class="form-label my-2"><b>Escolher prato</b></label>
                                            <select class="form-select" name="menuFood">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultFood['affectedRows']) { ?>
                                                    <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="dessertMonday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                            <select class="form-select" name="menuDessert">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDessert['affectedRows']) { ?>
                                                    <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="drinkMonday" class="form-label my-2"><b>Escolher bebida</b></label>
                                            <select class="form-select" name="menuDrink">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDrink['affectedRows']) { ?>
                                                    <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="menuPrice" class="form-label"><b>Preço</b></label>
                                            <input type="text" class="form-control" id="menuPrice" name="menuPrice" placeholder="00.00">
                                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar menu</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Terça-feira | <?= $weekDates[1]; ?></h5>
                        <hr>
                        <?php
                        if ($resultTuesday['affectedRows'] == 0) {
                            echo '<div class="alert alert-danger my-1" role="alert">';
                            echo '    <div class="text-danger">Menu por preencher!</div>';
                            echo '</div>';
                        } else { ?>
                            <div class="row">
                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultTuesday['data'][0]->nomeSopa ?></div>
                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultTuesday['data'][0]->nomePrato ?></div>
                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultTuesday['data'][0]->nomeBebida ?></div>
                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultTuesday['data'][0]->nomeSobremesa ?></div>
                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultTuesday['data'][0]->preco . "€" ?></div>
                            </div>
                        <?php }
                        ?>
                        <button type="button" class="btn-lunch-student rounded p-2 mt-3" data-bs-toggle="modal" data-bs-target="#selectMenuTuesday">
                            Editar Menu
                        </button>
                        <div class="modal fade" id="selectMenuTuesday" tabindex="-1" aria-labelledby="selectMenuTuesday" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectMenuTuesday">Editar menu - <?= $weekDates[1]; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=weekmenu_submit&date=<?= $weekDates[1]; ?>" method="post">
                                            <label for="soupTuesday" class="form-label my-2"><b>Escolher sopa</b></label>
                                            <select class="form-select" name="menuSoup">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultSoup['affectedRows']) { ?>
                                                    <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="foodTuesday" class="form-label my-2"><b>Escolher prato</b></label>
                                            <select class="form-select" name="menuFood">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultFood['affectedRows']) { ?>
                                                    <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="dessertTuesday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                            <select class="form-select" name="menuDessert">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDessert['affectedRows']) { ?>
                                                    <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="drinkTuesday" class="form-label my-2"><b>Escolher bebida</b></label>
                                            <select class="form-select" name="menuDrink">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDrink['affectedRows']) { ?>
                                                    <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="menuPrice" class="form-label"><b>Preço</b></label>
                                            <input type="text" class="form-control" id="menuPrice" name="menuPrice" placeholder="00.00">
                                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar menu</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Quarta-feira | <?= $weekDates[2]; ?></h5>
                        <hr>
                        <?php
                        if ($resultWednesday['affectedRows'] == 0) {
                            echo '<div class="alert alert-danger my-1" role="alert">';
                            echo '    <div class="text-danger">Menu por preencher!</div>';
                            echo '</div>';
                        } else { ?>
                            <div class="row">
                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultWednesday['data'][0]->nomeSopa ?></div>
                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultWednesday['data'][0]->nomePrato ?></div>
                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultWednesday['data'][0]->nomeBebida ?></div>
                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultWednesday['data'][0]->nomeSobremesa ?></div>
                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultWednesday['data'][0]->preco . "€" ?></div>
                            </div>
                        <?php }
                        ?>
                        <button type="button" class="btn-lunch-student rounded p-2 mt-3" data-bs-toggle="modal" data-bs-target="#selectMenuWednesday">
                            Editar Menu
                        </button>
                        <div class="modal fade" id="selectMenuWednesday" tabindex="-1" aria-labelledby="selectMenuWednesday" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectMenuWednesday">Editar menu - <?= $weekDates[2]; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=weekmenu_submit&date=<?= $weekDates[2]; ?>" method="post">
                                            <label for="soupWednesday" class="form-label my-2"><b>Escolher sopa</b></label>
                                            <select class="form-select" name="menuSoup">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultSoup['affectedRows']) { ?>
                                                    <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="foodWednesday" class="form-label my-2"><b>Escolher prato</b></label>
                                            <select class="form-select" name="menuFood">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultFood['affectedRows']) { ?>
                                                    <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="dessertWednesday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                            <select class="form-select" name="menuDessert">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDessert['affectedRows']) { ?>
                                                    <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="drinkWednesday" class="form-label my-2"><b>Escolher bebida</b></label>
                                            <select class="form-select" name="menuDrink">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDrink['affectedRows']) { ?>
                                                    <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="menuPrice" class="form-label"><b>Preço</b></label>
                                            <input type="text" class="form-control" id="menuPrice" name="menuPrice" placeholder="00.00">
                                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar menu</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Quinta-feira | <?= $weekDates[3]; ?></h5>
                        <hr>
                        <?php
                        if ($resultThursday['affectedRows'] == 0) {
                            echo '<div class="alert alert-danger my-1" role="alert">';
                            echo '    <div class="text-danger">Menu por preencher!</div>';
                            echo '</div>';
                        } else { ?>
                            <div class="row">
                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultThursday['data'][0]->nomeSopa ?></div>
                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultThursday['data'][0]->nomePrato ?></div>
                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultThursday['data'][0]->nomeBebida ?></div>
                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultThursday['data'][0]->nomeSobremesa ?></div>
                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultThursday['data'][0]->preco . "€" ?></div>
                            </div>
                        <?php }
                        ?>
                        <button type="button" class="btn-lunch-student rounded p-2 mt-3" data-bs-toggle="modal" data-bs-target="#selectMenuThursday">
                            Editar Menu
                        </button>
                        <div class="modal fade" id="selectMenuThursday" tabindex="-1" aria-labelledby="selectMenuThursday" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectMenuThursday">Editar menu - <?= $weekDates[3]; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=weekmenu_submit&date=<?= $weekDates[3]; ?>" method="post">
                                            <label for="soupThursday" class="form-label my-2"><b>Escolher sopa</b></label>
                                            <select class="form-select" name="menuSoup">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultSoup['affectedRows']) { ?>
                                                    <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="foodThursday" class="form-label my-2"><b>Escolher prato</b></label>
                                            <select class="form-select" name="menuFood">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultFood['affectedRows']) { ?>
                                                    <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="dessertThursday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                            <select class="form-select" name="menuDessert">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDessert['affectedRows']) { ?>
                                                    <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="drinkThursday" class="form-label my-2"><b>Escolher bebida</b></label>
                                            <select class="form-select" name="menuDrink">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDrink['affectedRows']) { ?>
                                                    <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="menuPrice" class="form-label"><b>Preço</b></label>
                                            <input type="text" class="form-control" id="menuPrice" name="menuPrice" placeholder="00.00">
                                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar menu</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Sexta-feira | <?= $weekDates[4]; ?></h5>
                        <hr>
                        <?php
                        if ($resultFriday['affectedRows'] == 0) {
                            echo '<div class="alert alert-danger my-1" role="alert">';
                            echo '    <div class="text-danger">Menu por preencher!</div>';
                            echo '</div>';
                        } else { ?>
                            <div class="row">
                                <div class="col-12 col-md-2"><b>Sopa</b><br><?= $resultFriday['data'][0]->nomeSopa ?></div>
                                <div class="col-12 col-md-2"><b>Prato</b><br><?= $resultFriday['data'][0]->nomePrato ?></div>
                                <div class="col-12 col-md-2"><b>Bebida</b><br><?= $resultFriday['data'][0]->nomeBebida ?></div>
                                <div class="col-12 col-md-2"><b>Sobremesa</b><br><?= $resultFriday['data'][0]->nomeSobremesa ?></div>
                                <div class="col-12 col-md-4"><b>Preço</b><br><?= $resultFriday['data'][0]->preco . "€" ?></div>
                            </div>
                        <?php }
                        ?>
                        <button type="button" class="btn-lunch-student rounded p-2 mt-3" data-bs-toggle="modal" data-bs-target="#selectMenuFriday">
                            Editar Menu
                        </button>
                        <div class="modal fade" id="selectMenuFriday" tabindex="-1" aria-labelledby="selectMenuFriday" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="selectMenuFriday">Editar menu - <?= $weekDates[4]; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=weekmenu_submit&date=<?= $weekDates[4]; ?>" method="post">
                                            <label for="soupFriday" class="form-label my-2"><b>Escolher sopa</b></label>
                                            <select class="form-select" name="menuSoup">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultSoup['affectedRows']) { ?>
                                                    <option value="<?= $resultSoup['data'][$i]->idProduto; ?>"><?= $resultSoup['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="foodFriday" class="form-label my-2"><b>Escolher prato</b></label>
                                            <select class="form-select" name="menuFood">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultFood['affectedRows']) { ?>
                                                    <option value="<?= $resultFood['data'][$i]->idProduto; ?>"><?= $resultFood['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="dessertFriday" class="form-label my-2"><b>Escolher sobremesa</b></label>
                                            <select class="form-select" name="menuDessert">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDessert['affectedRows']) { ?>
                                                    <option value="<?= $resultDessert['data'][$i]->idProduto; ?>"><?= $resultDessert['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="drinkFriday" class="form-label my-2"><b>Escolher bebida</b></label>
                                            <select class="form-select" name="menuDrink">
                                                <?php
                                                $i = 0;
                                                while ($i != $resultDrink['affectedRows']) { ?>
                                                    <option value="<?= $resultDrink['data'][$i]->idProduto; ?>"><?= $resultDrink['data'][$i]->nomeProduto; ?></option>
                                                <?php $i++;
                                                } ?>
                                            </select>
                                            <label for="menuPrice" class="form-label"><b>Preço</b></label>
                                            <input type="text" class="form-control" id="menuPrice" name="menuPrice" placeholder="00.00">
                                            <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Confirmar menu</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2"></div>
    </div>
</div>