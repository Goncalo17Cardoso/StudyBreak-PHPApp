<?php
defined('CONTROL') or die('Access denied');

$db = new database();

$verifyInstallation = $db->emailDomain();

if ($verifyInstallation['affectedRows'] == 0) {
    header("Location: ?page=installation");
    exit;
}

$today = strtotime('today');
$weekDays = date('N', $today);
$daysSinceMonday = $weekDays - 1;
$lastMonday = strtotime("-$daysSinceMonday days", $today);
$weekDates = array();
for ($i = 0; $i < 5; $i++) {
    $weekDates[] = date('Y-m-d', strtotime("+$i days", $lastMonday));
}
?>

<main>
        <div id="wrapper-division-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4 d-flex justify-content-center" id="main-logo">
                        <img src="../inc/img/index/logo.png" class="img-fluid w-75">
                    </div>
                    <div class="col-12 col-md-4"></div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3"></div>
                    <div class="col-12 col-md-3 py-4 mx-auto text-end main-buttons">
                        <a href="?page=login"><button type="button" class="btn-main rounded py-2 px-5"><b>Entrar</b></button></a>
                    </div>
                    <div class="col-12 col-md-3 py-4 mx-auto text-start main-buttons">
                        <a href="?page=register"><button type="button" class="btn-main rounded py-2 px-5"><b>Registar</b></button></a>
                    </div>
                    <div class="col-12 col-md-3"></div>
                </div>
            </div>    
        </div>
    </main>