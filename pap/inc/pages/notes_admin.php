<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$result = $db->notes($_SESSION['id']) ?? null;

$show_error = $_SESSION['error'] ?? null;
$show_success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<div class="container-fluid">
    <form action="?page=notes_submit" method="post">
        <div class="shadow p-3 my-4 mx-4 bg-body-notes rounded">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="form">
                        <textarea class="form-control" placeholder="As suas notas..." name="notes" id="floatingTextarea" rows="12"><?= $result['data']['0']->apontamentos ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn-addproducts-admin rounded px-5 py-2 mt-3"><b>Guardar</b></button>
                </div>
                <div class="col-12 col-md-9">
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
            </div>
        </div>
    </form>
</div>