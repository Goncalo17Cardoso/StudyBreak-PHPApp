<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$id = $_GET['id'] ?? null;

$resultUsers = $db->editUsersSearch($id);

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
                <form action="?page=edit_users_submit&id=<?=$id?>" method="post">
                    <div class="mb-3">
                        <label for="UserName" class="form-label"><b>Nome completo</b></label>
                        <input type="text" class="form-control" id="UserName" name="UserName" value="<?= $resultUsers['data']['0']->nome ?>">
                    </div>
                    <div class="mb-3">
                        <label for="UserEmail" class="form-label"><b>Email</b></label>
                        <input type="email" class="form-control" id="UserEmail" value="<?= $resultUsers['data']['0']->email ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="UserPhone" class="form-label"><b>Número Telemóvel</b></label>
                        <input type="text" class="form-control" id="UserPhone" name="UserPhone" maxlength="9" value="<?= $resultUsers['data']['0']->contacto ?>">
                    </div>
                    <div class="mb-3">
                        <label for="UserType" class="form-label">Tipo de Utilizador</label>
                        <select class="form-select form-select mb-3" name="UserType" id="UserType">
                            <option selected value="Aluno">Aluno</option>
                            <option value="Professor/Funcionario">Professor/Funcionario</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Direcao">Direção</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="UserNIF" class="form-label"><b>NIF</b></label>
                        <input type="text" class="form-control" id="UserNIF" name="UserNIF" maxlength="9" value="<?= $resultUsers['data']['0']->nif ?>">
                    </div>
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Editar Utilizador</b></button>
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