<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$resultUsers = $db->allUsers();

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
            <div class="col-12 col-md-10 d-flex">
                <button type="button" class="btn-direction-add-users rounded px-5 py-2 my-3" data-bs-toggle="modal" data-bs-target="#addUsers">
                    Adicionar Utilizador
                </button>
                <div class="modal fade" id="addUsers" tabindex="-1" aria-labelledby="addUsersLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addUsersLabel">Adicionar Utilizadores</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="?page=add_users" method="post">
                                    <div class="mb-3">
                                        <label for="UserName" class="form-label"><b>Nome completo</b></label>
                                        <input type="text" class="form-control" id="UserName" name="UserName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="UserEmail" class="form-label"><b>Email</b></label>
                                        <input type="email" class="form-control" id="UserEmail" name="UserEmail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="UserPass" class="form-label"><b>Palavra-Passe</b></label>
                                        <input type="password" class="form-control" id="UserPass" name="UserPass">
                                    </div>
                                    <div class="mb-3">
                                        <label for="UserPhone" class="form-label"><b>Número Telemóvel</b></label>
                                        <input type="text" class="form-control" id="UserPhone" name="UserPhone" maxlength="9">
                                    </div>
                                    <div class="mb-3">
                                        <label for="UserType" class="form-label">Tipo de Utilizador</label>
                                        <select class="form-select form-select mb-3" name="UserType" id="UserType">
                                            <option selected value="Aluno">Aluno</option>
                                            <option value="Professor/Funcionario">Professor/Funcionario</option>
                                            <option value="Administrador">Adminstrador</option>
                                            <option value="Direcao">Direção</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="UserNIF" class="form-label"><b>NIF</b></label>
                                        <input type="text" class="form-control" id="UserNIF" name="UserNIF" maxlength="9">
                                    </div>
                                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Adicionar Utilizador</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                <?php
                if ($resultUsers['affectedRows'] == 0) {
                    echo "<p> Não Existem Utilizadores Registados... </p>";
                }

                $i = 0;
                while ($i != $resultUsers['affectedRows']) {
                ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <b><?= $resultUsers['data'][$i]->nome ?> - <?= $resultUsers['data'][$i]->tipoUtilizador ?></b>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>Id do Utilizador: <?= $resultUsers['data'][$i]->idUtilizador ?> | Email: <?= $resultUsers['data'][$i]->email ?></p>
                                <p>Contacto: <?= $resultUsers['data'][$i]->contacto ?> | NIF: <?= $resultUsers['data'][$i]->nif ?></p>
                                <div class="d-flex">
                                    <form action="?page=edit_user&id=<?= $resultUsers['data'][$i]->idUtilizador ?>" method="post">
                                        <button type="submit" class="btn-direction-add-users rounded px-5 py-2">Editar Utilizador</button>
                                    </form>
                                    <form action="?page=delete_user_submit&id=<?= $resultUsers['data'][$i]->idUtilizador ?>" method="post">
                                        <button type="submit" class="btn-direction-add-users rounded px-5 py-2 mx-1">Eliminar Utilizador</button>
                                    </form>    
                                </div>       
                            </blockquote>
                        </div>
                    </div>
                <?php
                    $i++;
                }
                ?>
            </div>
            <div class="col-12 col-md-1"></div>
        </div>
    </div>
</main>