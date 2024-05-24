<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$productId = $_GET['id'] ?? null;

$resultType = $db->addProductsSelectType();

$result = $db->selectProductsById($productId);

$show_error = $_SESSION['error'] ?? null;
$show_warning = $_SESSION['warning'] ?? null;
$show_success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['warning']);
unset($_SESSION['success']);
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-1"></div>
            <div class="col-12 col-md-10 my-3">
                <form action="?page=edit_products_submit&id=<?= $productId ?>" method="post">
                    <div class="mb-3">
                        <label for="ProductName" class="form-label"><b>Nome do Produto</b></label>
                        <input type="text" class="form-control" id="ProductName" name="ProductName" value="<?= $result['data']['0']->nomeProduto ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ProductType" class="form-label"><b>Tipo de Produto</b></label><br>
                        <select class="form-select" name="ProductType">
                            <?php
                            $i = 0;
                            while ($i != $resultType['affectedRows']) { ?>
                                <option value="<?= $resultType['data'][$i]->idTipoProduto; ?>"><?= $resultType['data'][$i]->nome; ?></option>
                            <?php $i++;
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ProductMenu" class="form-label"><b>Prato Permitido em Menu</b></label><br>
                        <input type="radio" class="btn-check" name="ProductMenu" id="ProductMenuYes" value="1" autocomplete="off">
                        <label class="btn btn-light" for="ProductMenuYes">Sim</label>
                        <input type="radio" class="btn-check" name="ProductMenu" id="ProductMenuNo" value="0" autocomplete="off">
                        <label class="btn btn-light" for="ProductMenuNo">Não</label>
                    </div>
                    <div class="mb-3">
                        <label for="ProductPrice" class="form-label"><b>Preço</b></label>
                        <input type="text" class="form-control" id="ProductPrice" name="ProductPrice" maxlength="5" value="<?= $result['data']['0']->preco ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Editar Produto</b></button>
                </form>
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
            <div class="col-12 col-md-1"></div>
        </div>
    </div>
</main>