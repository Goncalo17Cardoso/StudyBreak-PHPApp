<?php

class database
{
    private function query($sql, $params = [])
    {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $lastID = $pdo->lastInsertId();
            $affectedRows = $stmt->rowCount();

            $results = $stmt->fetchAll(PDO::FETCH_CLASS);

            return [
                'status' => 'success',
                'data' => $results,
                'lastID' => $lastID,
                'affectedRows' => $affectedRows
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'data' => $e->getMessage()
            ];
        }
    }

    // ==============================================================================
    // users
    // ==============================================================================

    public function signin($email)
    {
        $params = [
            ':email' => $email
        ];

        $sql = "SELECT * FROM utilizador WHERE email = :email AND deleted_at IS NULL";

        return $this->query($sql, $params);
    }

    public function signup($email, $name, $password, $contact, $usertype, $nif, $email_link)
    {
        $password_enc = password_hash($password, PASSWORD_DEFAULT);
        $email_validate = 0;
        $objective = 0;

        $params = [
            ':email'        => $email,
            ':name'         => $name,
            ':password'     => $password_enc,
            ':contact'      => $contact,
            ':usertype'     => $usertype,
            ':nif'          => $nif,
            ':objective'    => $objective,
            ':email_link'   => $email_link,
            ':email_validate' => $email_validate
        ];

        $sql = "INSERT INTO utilizador (email, palavrapasse, nome, contacto, tipoutilizador, nif, objetivo, email_link, email_validate, created_at)
                VALUES (:email, :password, :name, :contact, :usertype, :nif, :objective, :email_link, :email_validate, NOW())";

        return $this->query($sql, $params);
    }

    public function validateEmailLink($email_link)
    {
        $params = [
            ':email_link'   => $email_link,
        ];

        $sql = "UPDATE utilizador 
                SET email_link = NULL, email_validate = 1, email_validated_at = NOW()
                WHERE email_link = :email_link";

        return $this->query($sql, $params);
    }

    public function recoverPasswordEmailVerification($email_forgot_password) 
    {
        $params = [
            ':email_forgot_password'    => $email_forgot_password,
        ];

        $sql = "SELECT COUNT(email) AS quantity FROM utilizador WHERE email = :email_forgot_password AND email_validate = 1";

        return $this->query($sql, $params);
    }

    public function recoverPasswordCode($email_forgot_password, $password_recover_code) 
    {
        $params = [
            ':email_forgot_password'    => $email_forgot_password,
            ':password_recover_code'    => $password_recover_code,
        ];

        $sql = "UPDATE utilizador 
                SET password_recover_code = :password_recover_code
                WHERE email = :email_forgot_password";

        return $this->query($sql, $params);
    }

    public function recoverPassword($password_recover, $recover_code) 
    {
        $new_password = password_hash($password_recover, PASSWORD_DEFAULT);

        $params = [
            ':new_password'    => $new_password,
            ':recover_code'    => $recover_code,
        ];

        $sql = "UPDATE utilizador 
                SET password_recover_code = NULL, palavraPasse = :new_password, password_recovered_at = NOW()
                WHERE password_recover_code = :recover_code";

        return $this->query($sql, $params);
    }
    // ==============================================================================
    // reservations functions
    // ==============================================================================

    public function userCart($userID) {
        $params = [
            ':userID' => $userID,
        ];

        $sql = "SELECT marcacao.idMarcacao, marcacao.menu, marcacao.dataCompleta, marcacao.hora, marcacao.tipoMarcacao, marcacao.total, produtoSopa.nomeProduto AS nomeSopa, produtoPrato.nomeProduto AS nomePrato,
                produtoBebida.nomeProduto AS nomeBebida, produtoSobremesa.nomeProduto AS nomeSobremesa, produtoLanche.nomeProduto AS nomeProdutoLanche
                FROM marcacao LEFT JOIN produto AS produtoSopa ON marcacao.sopa = produtoSopa.idProduto LEFT JOIN produto AS produtoPrato ON marcacao.prato = produtoPrato.idProduto
                LEFT JOIN produto AS produtoBebida ON marcacao.bebida = produtoBebida.idProduto LEFT JOIN produto AS produtoSobremesa ON marcacao.sobremesa = produtoSobremesa.idProduto 
                LEFT JOIN produto AS produtoLanche ON marcacao.produtoLanche = produtoLanche.idProduto WHERE idUtilizador = :userID AND estado = 'pending'";

        return $this->query($sql, $params);
    }

    public function confirmCart($userId) {
        $params = [
            ':userID' => $userId,
        ];

        $sql = "UPDATE marcacao 
        SET estado = 'paid, to delivery', update_at = NOW()
        WHERE idUtilizador = :userID AND estado = 'pending'";

        return $this->query($sql, $params);
    }

    public function getProductPrice($productId) {
        $params = [
            ':productId' => $productId,
        ];

        $sql = "SELECT preco FROM produto WHERE idProduto = :productId";

        return $this->query($sql, $params);
    }

    public function verifyMenuDateAvailable($date) {

        $params = [
            ':date' => $date,
        ];

        $sql = "SELECT * FROM menudiario WHERE dataCompleta = :date";

        return $this->query($sql, $params);
    }

    public function verifyUserReservation($userID, $date) {
        $params = [
            ':userID' => $userID,
            ':date' => $date,
        ];

        $sql = "SELECT * FROM marcacao WHERE idUtilizador = :userID AND dataCompleta = :date, estado != 'canceled', tipoMarcacao != 'almoco', tipoMarcacao != 'menu'";

        return $this->query($sql, $params);
    }

    public function newReservationMenu($userID, $menuID, $date, $hour, $price) {
        $params = [
            ':userID' => $userID,
            ':menuID' => $menuID,  
            ':reservationType' => 'menu', 
            ':date' => $date,
            ':hour' => $hour,
            ':status' => 'pending',
            ':price' => $price,  
        ];

        $sql = "INSERT INTO marcacao (idUtilizador, menu, tipoMarcacao, dataCompleta, hora, estado, total, created_at) VALUES
                (:userID, :menuID, :reservationType, :date, :hour, :status, :price, NOW())";

        return $this->query($sql, $params);
    }

    public function newReservationLunch($userID, $soup, $food, $drink, $dessert, $date, $hour, $price) {
        $params = [
            ':userID' => $userID,
            ':reservationType' => 'almoco',
            ':soup' => $soup,
            ':food' => $food,
            ':drink' => $drink,
            ':dessert' => $dessert, 
            ':date' => $date,
            ':hour' => $hour,
            ':status' => 'pending',
            ':price' => $price,  
        ];

        $sql = "INSERT INTO marcacao (idUtilizador, tipoMarcacao, sopa, prato, bebida, sobremesa, dataCompleta, hora, estado, total, created_at) VALUES
                (:userID, :reservationType, :soup, :food, :drink, :dessert, :date, :hour, :status, :price, NOW())";

        return $this->query($sql, $params);
    }

    public function newReservationSnack($userID, $snack, $date, $hour, $price) {
        $params = [
            ':userID' => $userID,
            ':reservationType' => 'lanche', 
            ':snack' => $snack,
            ':date' => $date,
            ':hour' => $hour,
            ':status' => 'pending',
            ':price' => $price,  
        ];

        $sql = "INSERT INTO marcacao (idUtilizador, tipoMarcacao, produtoLanche, dataCompleta, hora, estado, total, created_at) VALUES
                (:userID, :reservationType, :snack, :date, :hour, :status, :price, NOW())";

        return $this->query($sql, $params);
    }

    public function lastReservationsUser($userId) {

        $params = [
            ':userId' => $userId,
        ];

        $sql = "SELECT marcacao.idMarcacao, marcacao.menu, marcacao.dataCompleta, marcacao.hora, marcacao.tipoMarcacao, marcacao.total,
        produtoSopa.nomeProduto AS nomeSopa, produtoPrato.nomeProduto AS nomePrato,
        produtoBebida.nomeProduto AS nomeBebida, produtoSobremesa.nomeProduto AS nomeSobremesa,
        produtoLanche.nomeProduto AS nomeProdutoLanche, utilizador.nome AS nomeUtilizador
        FROM marcacao
        LEFT JOIN produto AS produtoSopa ON marcacao.sopa = produtoSopa.idProduto
        LEFT JOIN produto AS produtoPrato ON marcacao.prato = produtoPrato.idProduto
        LEFT JOIN produto AS produtoBebida ON marcacao.bebida = produtoBebida.idProduto
        LEFT JOIN produto AS produtoSobremesa ON marcacao.sobremesa = produtoSobremesa.idProduto 
        LEFT JOIN produto AS produtoLanche ON marcacao.produtoLanche = produtoLanche.idProduto
        LEFT JOIN utilizador ON marcacao.idUtilizador = utilizador.idUtilizador
        WHERE marcacao.idUtilizador = :userId AND marcacao.estado = 'finished' ORDER BY marcacao.idMarcacao DESC";

        return $this->query($sql, $params);
    }

    // ==============================================================================
    // admin functions
    // ==============================================================================

    public function newObjective($userId, $objective) {
        $params = [
            ':userId' => $userId,
            ':newObjective' => $objective,
        ];

        $sql = "UPDATE utilizador SET objetivo = :newObjective, updated_at = NOW() WHERE idUtilizador = :userId";

        return $this->query($sql, $params);
    }

    public function showObjective($userId) {
        $params = [
            ':userId' => $userId,
        ];

        $sql = "SELECT objetivo FROM utilizador WHERE idUtilizador = :userId";

        return $this->query($sql, $params);
    }

    public function actualMoneyMonthObjective() {
        $actualMonth = date("m");

        $params = [
            ':actualMonth' => '%' . $actualMonth . '%',
        ];

        $sql = "SELECT sum(total) AS total FROM marcacao WHERE dataCompleta LIKE :actualMonth AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function lastReservationsAdmin() {

        $sql = "SELECT marcacao.idMarcacao, marcacao.menu, marcacao.dataCompleta, marcacao.hora, marcacao.tipoMarcacao, marcacao.total,
        produtoSopa.nomeProduto AS nomeSopa, produtoPrato.nomeProduto AS nomePrato,
        produtoBebida.nomeProduto AS nomeBebida, produtoSobremesa.nomeProduto AS nomeSobremesa,
        produtoLanche.nomeProduto AS nomeProdutoLanche, utilizador.nome AS nomeUtilizador
        FROM marcacao
        LEFT JOIN produto AS produtoSopa ON marcacao.sopa = produtoSopa.idProduto
        LEFT JOIN produto AS produtoPrato ON marcacao.prato = produtoPrato.idProduto
        LEFT JOIN produto AS produtoBebida ON marcacao.bebida = produtoBebida.idProduto
        LEFT JOIN produto AS produtoSobremesa ON marcacao.sobremesa = produtoSobremesa.idProduto 
        LEFT JOIN produto AS produtoLanche ON marcacao.produtoLanche = produtoLanche.idProduto
        LEFT JOIN utilizador ON marcacao.idUtilizador = utilizador.idUtilizador
        WHERE marcacao.estado = 'finished' ORDER BY marcacao.idMarcacao DESC";

        return $this->query($sql);
    }

    public function addProductsSelectType()
    {
        $sql = "SELECT * FROM tipoproduto";

        return $this->query($sql);
    }

    public function addProducts($productName, $productPrice, $lunchOfTheDay, $productType)
    {
        $params = [
            ':productName' => $productName,
            ':productPrice' => $productPrice,
            ':lunchOfTheDay' => $lunchOfTheDay,
            ':productType' => $productType, 
        ];

        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at)
        VALUES (:productName, :productPrice, :lunchOfTheDay, :productType, NOW())";

        return $this->query($sql, $params);
    }

    public function addProductsType($productType)
    {
        $params = [
            ':productType' => $productType, 
        ];

        $sql = "INSERT INTO tipoproduto (nome) VALUES (:productType)";

        return $this->query($sql, $params);
    }

    public function selectProducts()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectProductsSearch($search)
    {
        $params = [
            ':product' => '%' . $search . '%',
        ];

        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nomeProduto LIKE :product AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql, $params);
    }

    public function selectProductsById($id)
    {
        $params = [
            ':id' => $id,
        ];

        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE idProduto = :id AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql, $params);
    }

    public function editProducts($id, $name, $type, $menu, $price) 
    {
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':type' => $type,
            ':menu' => $menu,
            ':price' => $price,
        ];

        $sql = "UPDATE produto SET nomeProduto = :name, preco = :price, pratoDoDia = :menu, tipoProduto = :type, updated_at = NOW() WHERE idProduto = :id";

        return $this->query($sql, $params);
    }

    public function deleteProducts($id)
    {
        $params = [
            ':id' => $id,
        ];

        $sql = "UPDATE produto SET deleted_at = NOW() WHERE idProduto = :id";

        return $this->query($sql, $params);
    }

    public function selectSnackProducts()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Bebida' || nome = 'Lanche' AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectSoup()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Sopa' AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectFoodMenu()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Almoço' AND pratoDoDia = 1 AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectFood()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Almoço' AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectDessert()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Sobremesa' AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function selectDrink()
    {
        $sql = "SELECT * FROM produto p join tipoproduto tp on p.tipoProduto = tp.idTipoProduto WHERE nome = 'Bebida' AND deleted_at IS NULL ORDER BY nomeProduto";

        return $this->query($sql);
    }

    public function verifyMenuDate($date) 
    {
        $params = [
            ':date' => $date,
        ];

        $sql = "SELECT * FROM menudiario WHERE dataCompleta = :date";

        return $this->query($sql, $params);
    }

    public function showMenuDate($date) 
    {
        $params = [
            ':date' => $date,
        ];

        $sql = "SELECT md.*,ps.nomeProduto AS nomeSopa, pp.nomeProduto AS nomePrato, pb.nomeProduto AS nomeBebida,
                psb.nomeProduto AS nomeSobremesa FROM menudiario md JOIN produto ps ON md.sopa = ps.idProduto JOIN 
                produto pp ON md.prato = pp.idProduto JOIN produto pb ON md.bebida = pb.idProduto JOIN produto psb ON md.sobremesa = psb.idProduto
                WHERE md.dataCompleta = :date;";

        return $this->query($sql, $params);
    }

    public function updateMenu($date, $menuSoup, $menuFood, $menuDessert, $menuDrink, $menuPrice) 
    {
        $params = [
            ':date' => $date,
            ':menuSoup' => $menuSoup,
            ':menuFood' => $menuFood,
            ':menuDessert' => $menuDessert,
            ':menuDrink' => $menuDrink,
            ':menuPrice' => $menuPrice,
        ];

        $sql = "UPDATE menudiario 
        SET sopa = :menuSoup, prato = :menuFood, bebida = :menuDrink, sobremesa = :menuDessert, preco = :menuPrice, updated_at = NOW()
        WHERE dataCompleta = :date";

        return $this->query($sql, $params);
    }

    public function newMenu($date, $menuSoup, $menuFood, $menuDessert, $menuDrink, $menuPrice) 
    {
        $params = [
            ':date' => $date,
            ':menuSoup' => $menuSoup,
            ':menuFood' => $menuFood,
            ':menuDessert' => $menuDessert,
            ':menuDrink' => $menuDrink,
            ':menuPrice' => $menuPrice,
        ];

        $sql = "INSERT INTO menudiario (dataCompleta, sopa, prato, bebida, sobremesa, preco, created_at) VALUES (:date, :menuSoup, :menuFood, :menuDrink, :menuDessert, :menuPrice, NOW())";

        return $this->query($sql, $params);
    }

    public function reservationForDelivery() {
        
        $sql = "SELECT marcacao.idMarcacao, marcacao.menu, marcacao.dataCompleta, marcacao.hora, marcacao.tipoMarcacao, marcacao.total,
        produtoSopa.nomeProduto AS nomeSopa, produtoPrato.nomeProduto AS nomePrato,
        produtoBebida.nomeProduto AS nomeBebida, produtoSobremesa.nomeProduto AS nomeSobremesa,
        produtoLanche.nomeProduto AS nomeProdutoLanche, utilizador.nome AS nomeUtilizador
        FROM marcacao
        LEFT JOIN produto AS produtoSopa ON marcacao.sopa = produtoSopa.idProduto
        LEFT JOIN produto AS produtoPrato ON marcacao.prato = produtoPrato.idProduto
        LEFT JOIN produto AS produtoBebida ON marcacao.bebida = produtoBebida.idProduto
        LEFT JOIN produto AS produtoSobremesa ON marcacao.sobremesa = produtoSobremesa.idProduto 
        LEFT JOIN produto AS produtoLanche ON marcacao.produtoLanche = produtoLanche.idProduto
        LEFT JOIN utilizador ON marcacao.idUtilizador = utilizador.idUtilizador
        WHERE marcacao.estado = 'paid, to delivery'";

        return $this->query($sql);
    }

    public function deleteReservation($reservationId) {
        $params = [
            ':reservationId' => $reservationId,
        ];

        $sql = "UPDATE marcacao 
        SET estado = 'canceled', update_at = NOW(), deleted_at = NOW()
        WHERE idMarcacao = :reservationId";

        return $this->query($sql, $params);
    }

    public function confirmReservationDelivery($reservationId) {
        $params = [
            ':reservationId' => $reservationId,
        ];

        $sql = "UPDATE marcacao 
        SET estado = 'finished', update_at = NOW()
        WHERE idMarcacao = :reservationId";

        return $this->query($sql, $params);
    }

    public function twoMonthsAgoLunch() {
        $d=strtotime("-2 Months");
        $twoMonthsAgo = date("m", $d);

        $params = [
            ':twoMonthsAgo' => '%-' . $twoMonthsAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :twoMonthsAgo AND tipoMarcacao = 'almoco' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function twoMonthsAgoMenu() {
        $d=strtotime("-2 Months");
        $twoMonthsAgo = date("m", $d);

        $params = [
            ':twoMonthsAgo' => '%-' . $twoMonthsAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :twoMonthsAgo AND tipoMarcacao = 'menu' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function twoMonthsAgoSnack() {
        $d=strtotime("-2 Months");
        $twoMonthsAgo = date("m", $d);

        $params = [
            ':twoMonthsAgo' => '%-' . $twoMonthsAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :twoMonthsAgo AND tipoMarcacao = 'lanche' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function twoMonthsAgoGeral() {
        $d=strtotime("-2 Months");
        $twoMonthsAgo = date("m", $d);

        $params = [
            ':twoMonthsAgo' => '%-' . $twoMonthsAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :twoMonthsAgo AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function oneMonthAgoLunch() {
        $d=strtotime("-1 Months");
        $oneMonthAgo = date("m", $d);

        $params = [
            ':oneMonthAgo' => '%-' . $oneMonthAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :oneMonthAgo AND tipoMarcacao = 'almoco' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function oneMonthAgoMenu() {
        $d=strtotime("-1 Months");
        $oneMonthAgo = date("m", $d);

        $params = [
            ':oneMonthAgo' => '%-' . $oneMonthAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :oneMonthAgo AND tipoMarcacao = 'menu' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function oneMonthAgoSnack() {
        $d=strtotime("-1 Months");
        $oneMonthAgo = date("m", $d);

        $params = [
            ':oneMonthAgo' => '%-' . $oneMonthAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :oneMonthAgo AND tipoMarcacao = 'lanche' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function oneMonthAgoGeral() {
        $d=strtotime("-1 Months");
        $oneMonthAgo = date("m", $d);

        $params = [
            ':oneMonthAgo' => '%-' . $oneMonthAgo . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :oneMonthAgo AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function actualMonthLunch() {
        $actualMonth = date("m");

        $params = [
            ':actualMonth' => '%-' . $actualMonth . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :actualMonth AND tipoMarcacao = 'almoco' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function actualMonthMenu() {
        $actualMonth = date("m");

        $params = [
            ':actualMonth' => '%-' . $actualMonth . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :actualMonth AND tipoMarcacao = 'menu' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function actualMonthSnack() {
        $actualMonth = date("m");

        $params = [
            ':actualMonth' => '%-' . $actualMonth . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :actualMonth AND tipoMarcacao = 'lanche' AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function actualMonthGeral() {
        $actualMonth = date("m");

        $params = [
            ':actualMonth' => '%-' . $actualMonth . '-%',
        ];

        $sql = "SELECT count(*) AS quantity FROM marcacao WHERE dataCompleta LIKE :actualMonth AND estado = 'finished'";

        return $this->query($sql, $params);
    }

    public function sendNotes($note, $userId) {
        $params = [
            ':note' => $note,
            ':userId' => $userId,
        ];

        $sql = "UPDATE utilizador 
        SET apontamentos = :note, updated_at = NOW()
        WHERE idUtilizador = :userId";

        return $this->query($sql, $params);
    }

    public function notes($userId) {
        $params = [
            ':userId' => $userId,
        ];

        $sql = "SELECT apontamentos FROM utilizador WHERE idUtilizador = :userId";

        return $this->query($sql, $params);
    }

    public function allUsers() {
        $sql = "SELECT * FROM utilizador WHERE deleted_at IS NULL";

        return $this->query($sql);
    }

    public function editUsersSearch($id) {
        $params = [
            ':id' => $id,
        ];

        $sql = "SELECT * FROM utilizador WHERE idUtilizador = :id";

        return $this->query($sql, $params);
    }

    public function editUsers($id, $name, $phone, $type, $nif) {
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':phone' => $phone,
            ':type' => $type,
            ':nif' => $nif
        ];

        $sql = "UPDATE utilizador SET nome = :name, contacto = :phone, tipoUtilizador = :type, nif = :nif WHERE idUtilizador = :id";

        return $this->query($sql, $params);
    }

    public function deleteUser($id) {
        $params = [
            ':id' => $id,
        ];

        $sql = "UPDATE utilizador SET deleted_at = NOW() WHERE idUtilizador = :id";

        return $this->query($sql, $params);
    }

    public function emailDomain() {

        $sql = "SELECT * FROM aplicacao";

        return $this->query($sql);
    }

    public function editEmailDomains($domain1, $domain2, $domain3, $domain4) {
        $params = [
            ':domainOne' => $domain1,
            ':domainTwo' => $domain2,
            ':domainThree' => $domain3,
            ':domainFour' => $domain4,
        ];

        $sql = "UPDATE aplicacao SET emailSufixoUm = :domainOne, emailSufixoDois = :domainTwo, emailSufixoTres = :domainThree, emailSufixoQuatro = :domainFour";

        return $this->query($sql, $params);
    }

    public function editFooter($appName, $appEmail, $appPhone, $appCellphone, $appLocation) {
        $params = [
            ':name' => $appName,
            ':email' => $appEmail,
            ':phone' => $appPhone,
            ':cellphone' => $appCellphone,
            ':location' => $appLocation,
        ];

        $sql = "UPDATE aplicacao SET nome = :name, email = :email, telefone = :phone, telemovel = :cellphone, localizacao = :location";

        return $this->query($sql, $params);
    }

    public function editSocial($instagram, $facebook, $linkedin, $whatsapp, $youtube) {
        $params = [
            ':instagram' => $instagram,
            ':facebook' => $facebook,
            ':linkedin' => $linkedin,
            ':whatsapp' => $whatsapp,
            ':youtube' => $youtube,
        ];

        $sql = "UPDATE aplicacao SET instagram = :instagram, facebook = :facebook, linkedin = :linkedin, whatsapp = :whatsapp, youtube = :youtube";

        return $this->query($sql, $params);
    }

    public function editPauses($pause1, $pause2, $pause3, $pause4, $pause5, $pause6, $pause7) {
        $params = [
            ':pause1' => $pause1,
            ':pause2' => $pause2,
            ':pause3' => $pause3,
            ':pause4' => $pause4,
            ':pause5' => $pause5,
            ':pause6' => $pause6,
            ':pause7' => $pause7,
        ];

        $sql = "UPDATE aplicacao SET intervaloUm = :pause1, intervaloDois = :pause2, intervaloTres = :pause3, intervaloQuatro = :pause4, intervaloCinco = :pause5, intervaloSeis = :pause6, intervaloSete = :pause7";

        return $this->query($sql, $params);
    }

    public function editLunchs($lunch1, $lunch2) {
        $params = [
            ':lunch1' => $lunch1,
            ':lunch2' => $lunch2,
        ];

        $sql = "UPDATE aplicacao SET horaAlmocoUm = :lunch1, horaAlmocoDois = :lunch2";

        return $this->query($sql, $params);
    }

    public function editLimitHour($hour) {
        $params = [
            ':hour' => $hour,
        ];

        $sql = "UPDATE aplicacao SET horaLimite = :hour";

        return $this->query($sql, $params);
    }

    public function addUser($name, $email, $pass, $phone, $type, $nif) {
        $password_enc = password_hash($pass, PASSWORD_DEFAULT);
        
        $params = [
            ':email'        => $email,
            ':name'         => $name,
            ':pass'     => $password_enc,
            ':phone'      => $phone,
            ':type'     => $type,
            ':nif'          => $nif,
        ];

        $sql = "INSERT INTO utilizador (email, palavraPasse, nome, contacto, tipoUtilizador, nif, email_validate, created_at) VALUES (:email, :pass, :name, :phone, :type, :nif, '1', NOW())";

        return $this->query($sql, $params);
    }

    public function installationUserRegister($name, $email, $pass) {
        $password_enc = password_hash($pass, PASSWORD_DEFAULT);
        $phone = '000000000';
        $type = 'Direcao';
        $nif = '000000000';

        $params = [
            ':email' => $email,
            ':name' => $name,
            ':pass' => $password_enc,
            ':phone' => $phone,
            ':type' => $type,
            ':nif' => $nif,
        ];

        $sql = "INSERT INTO utilizador (email, palavraPasse, nome, contacto, tipoUtilizador, nif, email_validate, created_at) VALUES (:email, :pass, :name, :phone, :type, :nif, '1', NOW())";

        return $this->query($sql, $params);
    }

    public function installationSchoolRegister($name, $email, $fixPhone, $phone, $address, $emailOne, $emailTwo, $emailThree, $emailFour, $pause1, $pause2, $pause3, $pause4, $pause5, $pause6, $pause7, $lunch1, $lunch2, $lunchLimit) {
        $instagram = 'https://www.instagram.com';
        $facebook = 'https://www.facebook.com';
        $linkedin = 'https://www.linkedin.com';
        $whatsapp = 'https://www.whatsapp.com';
        $youtube = 'https://www.youtube.com';

        $params = [
            ':emailOne' => $emailOne,
            ':emailTwo' => $emailTwo,
            ':emailThree' => $emailThree,
            ':emailFour' => $emailFour,
            ':email' => $email,
            ':name' => $name,
            ':fixPhone' => $fixPhone,
            ':phone' => $phone,
            ':address' => $address,
            ':instagram' => $instagram,
            ':facebook' => $facebook,
            ':linkedin' => $linkedin,
            ':whatsapp' => $whatsapp,
            ':youtube' => $youtube,
            ':pauseOne' => $pause1,
            ':pauseTwo' => $pause2,
            ':pauseThree' => $pause3,
            ':pauseFour' => $pause4,
            ':pauseFive' => $pause5,
            ':pauseSix' => $pause6,
            ':pauseSeven' => $pause7,
            ':lunchOne' => $lunch1,
            ':lunchTwo' => $lunch2,
            ':lunchLimit' => $lunchLimit,
        ];

        $sql = "INSERT INTO aplicacao (emailSufixoUm, emailSufixoDois, emailSufixoTres, emailSufixoQuatro, nome, email, telefone, telemovel, localizacao, instagram, facebook, linkedIn, whatsapp, youtube, intervaloUm, intervaloDois, intervaloTres, intervaloQuatro, intervaloCinco, intervaloSeis, intervaloSete, horaAlmocoUm, horaAlmocoDois, horaLimite) VALUES (:emailOne, :emailTwo, :emailThree, :emailFour, :name, :email, :fixPhone, :phone, :address, :instagram, :facebook, :linkedin, :whatsapp, :youtube, :pauseOne, :pauseTwo, :pauseThree, :pauseFour, :pauseFive, :pauseSix, :pauseSeven, :lunchOne, :lunchTwo, :lunchLimit)";

        return $this->query($sql, $params);
    }

    public function tempProducts()
    {
        $sql = "SELECT * FROM produto";

        return $this->query($sql);
    }

    public function tempOne()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Arroz de Pato', 1, 0, 1, NOW())";

        return $this->query($sql);
    }

    public function tempTwo()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Cozido à Portuguesa', 5, 0, 1, NOW())";

        return $this->query($sql);
    }

    public function tempThree()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Gambas', 6, 1, 1, NOW())";

        return $this->query($sql);
    }

    public function tempFour()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Seven up', 2, 0, 3, NOW())";

        return $this->query($sql);
    }

    public function tempFive()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Água', 9, 0, 3, NOW())";

        return $this->query($sql);
    }

    public function tempSix()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Musse de Oreo', 1, 0, 4, NOW())";

        return $this->query($sql);
    }

    public function tempSeven()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Broa de Mel', 9, 0, 2, NOW())";

        return $this->query($sql);
    }

    public function tempEight()
    {
        $sql = "INSERT INTO produto (nomeProduto, preco, pratoDoDia, tipoProduto, created_at) VALUES ('Sopa de Legumes', 1, 0, 5, NOW())";

        return $this->query($sql);
    }

    public function temp2One()
    {
        $sql = "INSERT INTO utilizador (idUtilizador, email, palavraPasse, nome, contacto, tipoUtilizador, nif, objetivo, email_validate, created_at) VALUES (100, 'je@gmail.com', 'isso', 'jé', '911222333', 'Aluno', 0, 0, 1, NOW())";

        return $this->query($sql);
    }

    public function temp2Two()
    {
        $sql = "INSERT INTO marcacao (idUtilizador, tipoMarcacao, menu, sopa, prato, bebida, sobremesa, produtoLanche, dataCompleta, hora, estado, total, created_at) VALUES (100, 'lanche', '', '', '', '', '', 2, 'Aluno', 0, 0, 1, NOW())";

        return $this->query($sql);
    }
}