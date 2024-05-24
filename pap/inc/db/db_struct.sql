DROP TABLE IF EXISTS marcacao;
DROP TABLE IF EXISTS menudiario;
DROP TABLE IF EXISTS produto;
DROP TABLE IF EXISTS utilizador;
DROP TABLE IF EXISTS tipoproduto;
DROP TABLE IF EXISTS aplicacao;

CREATE TABLE aplicacao (
    idAplicacao INT PRIMARY KEY AUTO_INCREMENT,
    emailSufixoUm VARCHAR(100),
    emailSufixoDois VARCHAR(100),
    emailSufixoTres VARCHAR(100),
    emailSufixoQuatro VARCHAR(100),
    nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(100),
    telemovel VARCHAR(100),
    localizacao VARCHAR(100),
    instagram VARCHAR(100),
    facebook VARCHAR(100),
    linkedIn VARCHAR(100),
    whatsapp VARCHAR(100),
    youtube VARCHAR(100),
    intervaloUm VARCHAR(10),
    intervaloDois VARCHAR(10),
    intervaloTres VARCHAR(10),
    intervaloQuatro VARCHAR(10),
    intervaloCinco VARCHAR(10),
    intervaloSeis VARCHAR(10),
    intervaloSete VARCHAR(10),
    horaAlmocoUm VARCHAR(10),
    horaAlmocoDois VARCHAR(10),
    horaLimite VARCHAR(10)
);

CREATE TABLE tipoproduto (
    idTipoProduto INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100)
);

CREATE TABLE utilizador (
    idUtilizador INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    palavraPasse VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    contacto VARCHAR(12) NOT NULL,
    tipoUtilizador VARCHAR(30) NOT NULL,
    nif INT,
    apontamentos TEXT,
    objetivo INT DEFAULT 100,
    email_link VARCHAR(100) UNIQUE,
    email_validate TINYINT,
    email_validated_at DATETIME,
    password_recover_code VARCHAR(100) UNIQUE,
    password_recovered_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME
);

CREATE TABLE produto (
    idProduto INT PRIMARY KEY AUTO_INCREMENT, 
    nomeProduto VARCHAR(100) NOT NULL,
    preco FLOAT NOT NULL, 
    pratoDoDia TINYINT,
    tipoProduto INT,
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,

    FOREIGN KEY(tipoProduto) REFERENCES tipoProduto(idTipoProduto)
);

CREATE TABLE menudiario (
    idMenuDiario INT PRIMARY KEY AUTO_INCREMENT,
    dataCompleta DATE NOT NULL,
    sopa INT, 
    prato INT,
    bebida INT,
    sobremesa INT,
    preco FLOAT NOT NULL, 
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,

    FOREIGN KEY(sopa) REFERENCES produto(idProduto),
    FOREIGN KEY(prato) REFERENCES produto(idProduto),
    FOREIGN KEY(bebida) REFERENCES produto(idProduto),
    FOREIGN KEY(sobremesa) REFERENCES produto(idProduto)
);


CREATE TABLE marcacao (
    idMarcacao INT PRIMARY KEY AUTO_INCREMENT,
    idUtilizador INT NOT NULL,
    tipoMarcacao VARCHAR(20) NOT NULL,
    menu INT,
    sopa INT,
    prato INT, 
    bebida INT,
    sobremesa INT,
    produtoLanche INT,
    dataCompleta DATE NOT NULL,
    hora TIME NOT NULL,
    estado VARCHAR(40) NOT NULL,
    total FLOAT NOT NULL,
    created_at DATETIME,
    update_at DATETIME,
    deleted_at DATETIME,

    FOREIGN KEY (idUtilizador) REFERENCES utilizador(idUtilizador),
    FOREIGN KEY (menu) REFERENCES menudiario(idMenuDiario),
    FOREIGN KEY (sopa) REFERENCES produto(idProduto),
    FOREIGN KEY (prato) REFERENCES produto(idProduto),
    FOREIGN KEY (bebida) REFERENCES produto(idProduto),
    FOREIGN KEY (sobremesa) REFERENCES produto(idProduto),
    FOREIGN KEY (produtoLanche) REFERENCES produto(idProduto)
);

INSERT INTO tipoproduto (idTipoProduto, nome) VALUES ('1', 'Almoço');
INSERT INTO tipoproduto (idTipoProduto, nome) VALUES ('2', 'Lanche');
INSERT INTO tipoproduto (idTipoProduto, nome) VALUES ('3', 'Bebida');
INSERT INTO tipoproduto (idTipoProduto, nome) VALUES ('4', 'Sobremesa');
INSERT INTO tipoproduto (idTipoProduto, nome) VALUES ('5', 'Sopa');