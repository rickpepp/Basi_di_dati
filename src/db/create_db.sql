CREATE SCHEMA IF NOT EXISTS Printing_Farm DEFAULT CHARACTER SET utf8 ;
USE Printing_Farm ;

-- Inserire Tutte Le Password Nella Relazione

-- Progettista

CREATE TABLE IF NOT EXISTS Printing_Farm.Progettista (
    CodiceProgettista INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Email VARCHAR(35) NOT NULL,
    CodiceFiscale CHAR(16) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.NumeroTelefonoProgettista (
    CodiceProgettista INT NOT NULL, 
    NumeroTelefono CHAR(10) NOT NULL,
    PRIMARY KEY(CodiceProgettista, NumeroTelefono),
    CONSTRAINT fk_NumeroTelefonoProgettista_CodiceProgettista
        FOREIGN KEY (CodiceProgettista) 
        REFERENCES Printing_Farm.Progettista(CodiceProgettista)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS Printing_Farm.AddettoRisorseUmane (
    CodiceARU INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Email VARCHAR(35) NOT NULL,
    CodiceFiscale CHAR(16) NOT NULL,
    Password CHAR(128) NOT NULL, 
    Salt CHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.NumeroTelefonoARU (
    CodiceARU INT NOT NULL,
    NumeroTelefono CHAR(10) NOT NULL,
    PRIMARY KEY(CodiceARU,NumeroTelefono),
    CONSTRAINT fk_NumeroTelefonoARU_CodiceAru
        FOREIGN KEY (CodiceARU) 
        REFERENCES Printing_Farm.AddettoRisorseUmane(CodiceARU)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Venditore

CREATE TABLE IF NOT EXISTS Printing_Farm.Venditore (
    CodiceVenditore INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Email VARCHAR(35) NOT NULL,
    CodiceFiscale CHAR(16) NOT NULL,
    Password CHAR(128) NOT NULL, 
    Salt CHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.NumeroTelefonoVenditore (
    CodiceVenditore INT NOT NULL,
    NumeroTelefono CHAR(10) NOT NULL,
    PRIMARY KEY(CodiceVenditore,NumeroTelefono),
    CONSTRAINT fk_NumeroTelefonoVenditore_CodiceVenditore
        FOREIGN KEY (CodiceVenditore) 
        REFERENCES Printing_Farm.Venditore(CodiceVenditore)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Operaio

CREATE TABLE IF NOT EXISTS Printing_Farm.Operaio (
    CodiceOperaio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Email VARCHAR(35) NOT NULL,
    CodiceFiscale CHAR(16) NOT NULL,
    Password CHAR(128) NOT NULL, 
    Salt CHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.NumeroTelefonoOperaio (
    CodiceOperaio INT NOT NULL,
    NumeroTelefono CHAR(10) NOT NULL,
    PRIMARY KEY(CodiceOperaio,NumeroTelefono),
    CONSTRAINT fk_NumeroTelefonoOperaio_CodiceOperaio
        FOREIGN KEY (CodiceOperaio) 
        REFERENCES Printing_Farm.Operaio(CodiceOperaio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Cliente

CREATE TABLE IF NOT EXISTS Printing_Farm.Cliente (
    CodiceCliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Email VARCHAR(35) NOT NULL,
    CodiceFiscale VARCHAR(16) NOT NULL,
    Via VARCHAR(30) NOT NULL,
    NumeroCivico INT NOT NULL,
    CAP CHAR(5) NOT NULL,
    Città VARCHAR(40) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.NumeroTelefonoCliente (
    CodiceCliente INT NOT NULL,
    NumeroTelefono CHAR(10) NOT NULL,
    PRIMARY KEY(CodiceCliente,NumeroTelefono),
    CONSTRAINT fk_NumeroTelefonoCliente_CodiceCliente
        FOREIGN KEY (CodiceCliente) 
        REFERENCES Printing_Farm.Cliente(CodiceCliente)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Stampante_3D

CREATE TABLE IF NOT EXISTS Printing_Farm.Stampante_3D (
    CodiceStampante INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MarchioProduzione VARCHAR(30) NOT NULL,
    Modello VARCHAR(30) NOT NULL,
    NumeroSeriale VARCHAR(30) NOT NULL,
    OreStampa FLOAT NOT NULL DEFAULT 0 ,
    TipologiaStampa VARCHAR(30) NOT NULL,
    CHECK (OreStampa>=0)
);

CREATE TABLE IF NOT EXISTS Printing_Farm.Acquisto (
    CodiceAcquisto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Stampante INT NOT NULL,
    DataAcquisto DATE NOT NULL,
    PrezzoAcquisto FLOAT NOT NULL,
    Venditore INT NOT NULL,
    CHECK (PrezzoAcquisto>=0),
    CONSTRAINT fk_Acquisto_Stampante
        FOREIGN KEY (Stampante) 
        REFERENCES Printing_Farm.Stampante_3D(CodiceStampante)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Acquisto_Venditore
        FOREIGN KEY (Venditore) 
        REFERENCES Printing_Farm.Venditore(CodiceVenditore)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS Printing_Farm.Manutenzione (
    CodiceManutenzione INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Stampante INT NOT NULL,
    DataManutenzione DATE NOT NULL,
    Descrizione TEXT,
    Operaio INT NOT NULL,
    CONSTRAINT fk_Manutenzione_Stampante
        FOREIGN KEY (Stampante) 
        REFERENCES Printing_Farm.Stampante_3D(CodiceStampante)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Manutenzione_Operaio
        FOREIGN KEY (Operaio) 
        REFERENCES Printing_Farm.Operaio(CodiceOperaio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Materiale

CREATE TABLE IF NOT EXISTS Printing_Farm.Materiale (
    CodiceMateriale INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NomeMateriale VARCHAR(35) NOT NULL,
    MarchioProduttore VARCHAR(30) NOT NULL,
    PesoUnità FLOAT NOT NULL,
    UnitàMagazzino FLOAT NOT NULL DEFAULT 0,
    CHECK(PesoUnità <> 0),
    Tipologia ENUM('Materiale Metallico','Materiale Polimerico','Materiale Composito')
);

CREATE TABLE IF NOT EXISTS Printing_Farm.AcquistoMateriale (
    CodiceAcquisto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    DataAcquisto DATE NOT NULL,
    Venditore INT NOT NULL,
    PrezzoAcquisto FLOAT NOT NULL,
    Materiale INT NOT NULL,
    Quantità INT NOT NULL DEFAULT 1,
    CHECK (PrezzoAcquisto>0),
    CONSTRAINT fk_AcquistoMateriale_Materiale
        FOREIGN KEY (Materiale) 
        REFERENCES Printing_Farm.Materiale(CodiceMateriale)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Spedizione

CREATE TABLE IF NOT EXISTS Printing_Farm.Corriere (
    CodiceCorriere INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NomeCorriere VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS Printing_Farm.Spedizione (
    CodiceSpedizione INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    CodiceTracciamento VARCHAR(30),
    DataSpedizione DATE NOT NULL,
    Venditore INT NOT NULL,
    Corriere INT NOT NULL,
    CONSTRAINT fk_Spedizione_Venditore
        FOREIGN KEY (Venditore) 
        REFERENCES Printing_Farm.Venditore(CodiceVenditore)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Spedizione_Corriere
        FOREIGN KEY (Corriere) 
        REFERENCES Printing_Farm.Corriere(CodiceCorriere)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Ordine

CREATE TABLE IF NOT EXISTS Printing_Farm.Ordine (
    CodiceOrdine INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NomeFile VARCHAR(50) NOT NULL,
    TempoRichiesto INT NOT NULL,
    DataOrdine DATE NOT NULL,
    QuantitàMateriale FLOAT NOT NULL,
    Costo FLOAT NOT NULL,
    Materiale INT NOT NULL,
    Venditore INT NOT NULL,
    Stampante INT NOT NULL,
    Cliente INT NOT NULL,
    Spedizione INT,
    CHECK (Costo>0),
    CONSTRAINT fk_Ordine_Materiale
        FOREIGN KEY (Materiale) 
        REFERENCES Printing_Farm.Materiale(CodiceMateriale)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Ordine_Venditore
        FOREIGN KEY (Venditore) 
        REFERENCES Printing_Farm.Venditore(CodiceVenditore)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Ordine_Stampante
        FOREIGN KEY (Stampante) 
        REFERENCES Printing_Farm.Stampante_3D(CodiceStampante)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Ordine_Cliente
        FOREIGN KEY (Cliente) 
        REFERENCES Printing_Farm.Cliente(CodiceCliente)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Ordine_Spedizione
        FOREIGN KEY (Spedizione) 
        REFERENCES Printing_Farm.Spedizione(CodiceSpedizione)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- ServizioPostProduzione

CREATE TABLE IF NOT EXISTS Printing_Farm.ServizioPostProduzione (
    CodiceServizio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NomeServizio VARCHAR(30) NOT NULL,
    CostoServizio FLOAT NOT NULL DEFAULT 1,
    Disponibilità BOOLEAN NOT NULL DEFAULT 1,
    CHECK (CostoServizio>0)
);

CREATE TABLE IF NOT EXISTS Printing_Farm.Compimento (
    Operaio INT NOT NULL,
    Servizio INT NOT NULL,
    PRIMARY KEY(Operaio,Servizio),
    CONSTRAINT fk_Compimento_Servizio
        FOREIGN KEY (Servizio) 
        REFERENCES Printing_Farm.ServizioPostProduzione(CodiceServizio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Compimento_Operaio
        FOREIGN KEY (Operaio) 
        REFERENCES Printing_Farm.Operaio(CodiceOperaio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS Printing_Farm.Richiesta (
    Ordine INT NOT NULL,
    Servizio INT NOT NULL,
    PRIMARY KEY(Ordine,Servizio),
    CONSTRAINT fk_Richiesta_Servizio
        FOREIGN KEY (Servizio) 
        REFERENCES Printing_Farm.ServizioPostProduzione(CodiceServizio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Richiesta_Ordine
        FOREIGN KEY (Ordine) 
        REFERENCES Printing_Farm.Ordine(CodiceOrdine)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- Progettazione

CREATE TABLE IF NOT EXISTS Printing_Farm.Progettazione (
    Ordine INT NOT NULL,
    Progettista INT NOT NULL,
    CostoProgettazione FLOAT NOT NULL,
    DataProgettazione DATE NOT NULL,
    CHECK (CostoProgettazione>0),
    PRIMARY KEY(Ordine,Progettista),
    CONSTRAINT fk_Progettazione_Ordine
        FOREIGN KEY (Ordine) 
        REFERENCES Printing_Farm.Ordine(CodiceOrdine)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Progettazione_Progettista
        FOREIGN KEY (Progettista) 
        REFERENCES Printing_Farm.Progettista(CodiceProgettista)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

-- AnnoEconomico

CREATE TABLE IF NOT EXISTS Printing_Farm.AnnoEconomico (
    AnnoRiferimento YEAR NOT NULL PRIMARY KEY,
    CostoProgettisti FLOAT NOT NULL DEFAULT 0,
    CostoVenditori FLOAT NOT NULL DEFAULT 0,
    CostoOperai FLOAT NOT NULL DEFAULT 0,
    CostoARU FLOAT NOT NULL DEFAULT 0,
    CostoStampanti FLOAT NOT NULL DEFAULT 0,
    CostoMateriale FLOAT NOT NULL DEFAULT 0,
    EntrateProgettazione FLOAT NOT NULL DEFAULT 0,
    EntrateProduzione FLOAT NOT NULL DEFAULT 0,
    EntrateServizi FLOAT NOT NULL DEFAULT 0
);

-- Mantiene (Non Necessario)

-- ContrattoLavoro

CREATE TABLE IF NOT EXISTS Printing_Farm.ContrattoLavoro (
    CodiceContratto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    DataAssunzione DATE NOT NULL,
    CostoDipendente FLOAT NOT NULL DEFAULT 0,
    DataLicenziamento DATE,
    LivelloContrattuale INT NOT NULL,
    Venditore INT,
    Operaio INT,
    ARU INT,
    Progettista INT,
    ARU_inserimento INT NOT NULL,
    CHECK (CostoDipendente>=0),
    CONSTRAINT fk_ContrattoLavoro_Progettista
        FOREIGN KEY (Progettista) 
        REFERENCES Printing_Farm.Progettista(CodiceProgettista)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_ContrattoLavoro_Operaio
        FOREIGN KEY (Operaio) 
        REFERENCES Printing_Farm.Operaio(CodiceOperaio)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_ContrattoLavoro_Venditore
        FOREIGN KEY (Venditore) 
        REFERENCES Printing_Farm.Venditore(CodiceVenditore)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_ContrattoLavoro_ARU
        FOREIGN KEY (ARU) 
        REFERENCES Printing_Farm.AddettoRisorseUmane(CodiceARU)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_ContrattoLavoro_ARU_inserimento
        FOREIGN KEY (ARU_inserimento) 
        REFERENCES Printing_Farm.AddettoRisorseUmane(CodiceARU)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);