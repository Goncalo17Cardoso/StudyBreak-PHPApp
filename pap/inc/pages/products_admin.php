<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$search = $_GET['search'] ?? null;

if ($search == null) {
    $result = $db->selectProducts();
} else {
    $result = $db->selectProductsSearch($search);
}

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
            <div class="col-12 col-md-10">
                <form class="d-flex my-3" role="search" action="?page=products_search_submit" method="post">
                    <input class="form-control mx-1 w-25" type="search" name="search" placeholder="Procurar..." value="<?= $search ?>">
                    <button class="btn-products-admin rounded" type="submit"><i class="bi bi-search"></i></button>
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
        <hr>
        <div class="row">
            <div class="col-12 col-md-1"></div>
            <div class="col-12 col-md-10">
                <div class="shadow p-3 mb-5 bg-body-login-register rounded">
                    <?php
                    if ($result['affectedRows'] == 0) {
                        echo '<div class="text-center">Nenhum produto registado... </div>';
                    }

                    $i = 0;
                    while ($result['affectedRows'] != $i) {
                    ?>
                        <div class="card my-2">
                            <h5 class="card-header"><?= $result['data'][$i]->nomeProduto ?> | Id: <?= $result['data'][$i]->idProduto ?></h5>
                            <div class="card-body">
                                <p class="card-text">Tipo: <?= $result['data'][$i]->nome ?> <?php if ($result['data'][$i]->nome == 'Almoço') {
                                                                                                echo '| Prato Permito em Menu: ';
                                                                                                if ($result['data'][$i]->pratoDoDia == 1) {
                                                                                                    echo 'Sim';
                                                                                                } else {
                                                                                                    echo 'Não';
                                                                                                }
                                                                                            } ?> <br> Produto Criado Em: <?= $result['data'][$i]->created_at ?></p>
                                <div class="d-flex my-1">
                                    <form action="?page=edit_products&id=<?= $result['data'][$i]->idProduto ?>" method="post">
                                        <button type="submit" class="btn-direction-add-users rounded px-4 py-2 me-1">Editar Produto</button>
                                    </form>
                                    <form action="?page=delete_products_submit&id=<?= $result['data'][$i]->idProduto ?>" method="post">
                                        <button type="submit" class="btn-direction-add-users rounded px-4 py-2">Eliminar Produto</button>
                                    </form>    
                                </div>                                                            
                                
                            </div>
                        </div>
                    <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-md-1"></div>
        </div>
    </div>
</main>