<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($_SESSION['type'] == 'Aluno' || $_SESSION['type'] == 'Professor/Funcionario') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=office_student"><b>Página Inicial</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=lunch_student"><b>Reservar Almoço</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=snack_student"><b>Reservar Lanche</b></a>
                    </li> <?php } else if ($_SESSION['type'] == 'Administrador') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=office_admin"><b>Página Inicial</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=stats_admin"><b>Estatisticas</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=reservations_admin"><b>Reservas</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=weekmenu_admin"><b>Alterar Menu Semanal</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=addproducts_admin"><b>Adicionar Produtos</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=products_admin"><b>Produtos</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=notes_admin"><b>Apontamentos</b></a>
                    </li> <?php } else if ($_SESSION['type'] == 'Direcao') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=app_customize"><b>Costumização da Aplicação</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=users"><b>Utilizadores</b></a>
                    </li>
                <?php } ?>
            </ul>
            <?php 
            $db = new database();

            $userCart = $db->userCart($_SESSION['id']);
            if ($userCart['affectedRows'] != 0) { ?>
                <span class="navbar-text">
                    <a class="nav-link mx-3" data-bs-toggle="offcanvas" href="#userCart" role="button" aria-controls="userCart"><i class="bi bi-cart4"></i> Carrinho</a>
                </span>
            <?php } ?>
            <span class="navbar-text">
                <a class="nav-link mx-3" href="?page=logout"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </span>
        </div>
    </div>
</nav>