<?php
defined('CONTROL' or die('access denied'));

$db = new database();

$twoMonthsAgoLunch = $db->twoMonthsAgoLunch();
$twoMonthsAgoLunchValues = $twoMonthsAgoLunch['data']['0']->quantity;
$twoMonthsAgoMenu = $db->twoMonthsAgoMenu();
$twoMonthsAgoMenuValues = $twoMonthsAgoMenu['data']['0']->quantity;
$twoMonthsAgoSnack = $db->twoMonthsAgoSnack();
$twoMonthsAgoSnackValues = $twoMonthsAgoSnack['data']['0']->quantity;
$twoMonthsAgoGeral = $db->twoMonthsAgoGeral();
$twoMonthsAgoGeralValues = $twoMonthsAgoGeral['data']['0']->quantity;

$oneMonthAgoLunch = $db->oneMonthAgoLunch();
$oneMonthAgoLunchValues = $oneMonthAgoLunch['data']['0']->quantity;
$oneMonthAgoMenu = $db->oneMonthAgoMenu();
$oneMonthAgoMenuValues = $oneMonthAgoMenu['data']['0']->quantity;
$oneMonthAgoSnack = $db->oneMonthAgoSnack();
$oneMonthAgoSnackValues = $oneMonthAgoSnack['data']['0']->quantity;
$oneMonthAgoGeral = $db->oneMonthAgoGeral();
$oneMonthAgoGeralValues = $oneMonthAgoGeral['data']['0']->quantity;

$actualMonthLunch = $db->actualMonthLunch();
$actualMonthLunchValues = $actualMonthLunch['data']['0']->quantity;
$actualMonthMenu = $db->actualMonthMenu();
$actualMonthMenuValues = $actualMonthMenu['data']['0']->quantity;
$actualMonthSnack = $db->actualMonthSnack();
$actualMonthSnackValues = $actualMonthSnack['data']['0']->quantity;
$actualMonthGeral = $db->actualMonthGeral();
$actualMonthGeralValues = $actualMonthGeral['data']['0']->quantity;
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-4 col-md-6">
            <div class="shadow p-3 my-3 mx-3 bg-body-stats rounded">
                <div>
                    <canvas id="lunchGraphic"></canvas>
                </div>    
            </div>
        </div>
        <div class="col-4 col-md-6">
            <div class="shadow p-3 my-3 mx-3 bg-body-stats rounded">
                <div>
                    <canvas id="menuGraphic"></canvas>
                </div>    
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col-4 col-md-6">
            <div class="shadow p-3 my-3 mx-3 bg-body-stats rounded">
                <div>
                    <canvas id="snackGraphic"></canvas>
                </div>    
            </div>           
        </div>
        <div class="col-4 col-md-6">
            <div class="shadow p-3 my-3 mx-3 bg-body-stats rounded">
                <div>
                    <canvas id="geralGraphic"></canvas>
                </div>    
            </div>            
        </div>
    </div>
</div>
<script>
  const lunchGraphic = document.getElementById('lunchGraphic');

  new Chart(lunchGraphic, {
    type: 'bar',
    data: {
      labels: ['Penúltimo Mês', 'Ultimo Mês', 'Mês Atual'],
      datasets: [{
        label: 'Número de ALMOÇOS entregues',
        data: [ <?= $twoMonthsAgoLunchValues ?>, <?= $oneMonthAgoLunchValues ?>, <?= $actualMonthLunchValues ?> ],
        borderWidth: 1,
        backgroundColor: "#674C47"
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  const menuGraphic = document.getElementById('menuGraphic');

  new Chart(menuGraphic, {
    type: 'bar',
    data: {
      labels: ['Penúltimo Mês', 'Ultimo Mês', 'Mês Atual'],
      datasets: [{
        label: 'Número de MENUS entregues',
        data: [ <?= $twoMonthsAgoMenuValues ?>, <?= $oneMonthAgoMenuValues ?>, <?= $actualMonthMenuValues ?> ],
        borderWidth: 1,
        backgroundColor: "#674C47"
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  const snackGraphic = document.getElementById('snackGraphic');

  new Chart(snackGraphic, {
    type: 'bar',
    data: {
      labels: ['Penúltimo Mês', 'Ultimo Mês', 'Mês Atual'],
      datasets: [{
        label: 'Número de LANCHES/BEBIDAS entregues',
        data: [ <?= $twoMonthsAgoSnackValues ?>, <?= $oneMonthAgoSnackValues ?>, <?= $actualMonthSnackValues ?> ],
        borderWidth: 1,
        backgroundColor: "#674C47"
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  const geralGraphic = document.getElementById('geralGraphic');

  new Chart(geralGraphic, {
    type: 'bar',
    data: {
      labels: ['Penúltimo Mês', 'Ultimo Mês', 'Mês Atual'],
      datasets: [{
        label: 'Número total de RESERVAS entregues',
        data: [ <?= $twoMonthsAgoGeralValues ?>, <?= $oneMonthAgoGeralValues ?>, <?= $actualMonthGeralValues ?> ],
        borderWidth: 1,
        backgroundColor: "#674C47"
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>