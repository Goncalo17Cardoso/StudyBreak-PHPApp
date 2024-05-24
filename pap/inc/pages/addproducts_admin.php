<?php
defined('CONTROL' or die('Access denied'));

$show_error = $_SESSION['error'] ?? null;
$show_error1 = $_SESSION['error1'] ?? null;
$show_success = $_SESSION['success'] ?? null;
$show_success1 = $_SESSION['success1'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['error1']);
unset($_SESSION['success']);
unset($_SESSION['success1']);

$db = new database();

$result = $db->addProductsSelectType();

$tempProducts = $db->tempProducts();

//echo"<pre>";
//die(print_r($result))
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="text-title-add-products-admin text-center mt-3">
                    <b>Adicionar produtos</b>
                </div>
                <hr class="titles-underline-admin mx-auto">
                <form action="?page=addproducts_submit" method="post">
                    <div class="my-3 mx-3">
                        <label for="productName" class="form-label"><b>Nome do Produto</b></label>
                        <input type="text" class="form-control" id="productName" name="productName">
                    </div>
                    <div class="my-3 mx-3">
                        <label for="productPrice" class="form-label"><b>Preço</b></label>
                        <input type="text" class="form-control" id="productPrice" name="productPrice" placeholder="00.00">
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="my-3 mx-3">
                                <label for="productName" class="form-label"><b>Prato Permitido em Menu</b></label><br>
                                <input type="radio" class="btn-check" name="lunchOfTheDay" id="lunchOfTheDayYes" value="1" autocomplete="off">
                                <label class="btn btn-light" for="lunchOfTheDayYes">Sim</label>
                                <input type="radio" class="btn-check" name="lunchOfTheDay" id="lunchOfTheDayNo" value="0" autocomplete="off">
                                <label class="btn btn-light" for="lunchOfTheDayNo">Não</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="my-3 mx-3">
                                <label for="productName" class="form-label"><b>Tipo de Produto</b></label><br>
                                <select class="form-select" name="productType">
                                    <?php
                                    $i = 0;
                                    while ($i != $result['affectedRows']) { ?>
                                        <option value="<?= $result['data'][$i]->idTipoProduto; ?>"><?= $result['data'][$i]->nome; ?></option>
                                    <?php $i++;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mx-3"><b>Adicionar</b></button>
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
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-title-add-products-admin text-center mt-3">
                    <b>Adicionar tipos de produtos</b>
                </div>
                <hr class="titles-underline-admin mx-auto">
                <form action="?page=addproductstype_submit" method="post">
                    <div class="my-3 mx-3">
                        <label for="productType" class="form-label"><b>Tipo de Produto</b></label>
                        <input type="text" class="form-control" id="productType" name="productType">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mx-3"><b>Adicionar</b></button>
                    </div>
                </form>
                <?php if (isset($show_error1)) { ?>
                    <div class="alert alert-danger my-1" role="alert">
                        <div class="text-danger"><i><?= $show_error1; ?></i></div>
                    </div>
                <?php } ?>
                <?php if (isset($show_success1)) { ?>
                    <div class="alert alert-success my-1" role="alert">
                        <div class="text-success"><i><?= $show_success1; ?></i></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>