-- Password per tutti i primi: Ciao%
INSERT INTO `AddettoRisorseUmane` (`Nome`,`Cognome`,`Email`,`CodiceFiscale`,`Password`,`Salt`) VALUES 
('Ciccio','Pasticcio','cicciopasticcio@ciao.it','YIGH2HX4YHOGCA8V','853f7a86c8b9578dbb79e78c56addb63f4f202272ef7a231d589755171801e91b3f8d190a2a89bf8a73c0df58e4452af18d219da546d1072792ab4e8b99fec8a','6eYcz#T^m7qC##bAU4P9s8Sz^p6N2J3P%QwwVYU66qC5Eqe7L8&cKaMb@VXC$!9b$LwKYg%Gd9wJfnmzdeAybGVA2bB@LpnM5kc&yd$ku$t$QpVo%S59Tz4$u5jLsSmu'),
('Mario','Rossi','mariorossi@ciao.it','8CNQYB7LOAYXWX1Z','sdsa','asds');

ALTER TABLE `AddettoRisorseUmane`
MODIFY `CodiceARU` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Operaio` (`Nome`,`Cognome`,`Email`,`CodiceFiscale`,`Password`,`Salt`) VALUES 
('Mario','Bianchi','mariobianchi@ciao.it','PLQJKGNAIJJWHAE3','853f7a86c8b9578dbb79e78c56addb63f4f202272ef7a231d589755171801e91b3f8d190a2a89bf8a73c0df58e4452af18d219da546d1072792ab4e8b99fec8a','6eYcz#T^m7qC##bAU4P9s8Sz^p6N2J3P%QwwVYU66qC5Eqe7L8&cKaMb@VXC$!9b$LwKYg%Gd9wJfnmzdeAybGVA2bB@LpnM5kc&yd$ku$t$QpVo%S59Tz4$u5jLsSmu'),
('Mario','Rossi','mariorossi2@ciao.it','DKANJLZO049V46MA','sdsa','asds');

ALTER TABLE `Operaio`
MODIFY `CodiceOperaio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Progettista` (`Nome`,`Cognome`,`Email`,`CodiceFiscale`) VALUES 
('Riccardo','Pepe','riccardopepe@ciao.it','S2C9JMIKIDQX0EG2'),
('Mario','Gialli','mariogialli@ciao.it','X6LIF4NBV1UFAGBT');

ALTER TABLE `Progettista`
MODIFY `CodiceProgettista` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Venditore` (`Nome`,`Cognome`,`Email`,`CodiceFiscale`,`Password`,`Salt`) VALUES 
('Mario','Rossi','mariorossi3@ciao.it','XIPXTG9WSA9CG5CP','853f7a86c8b9578dbb79e78c56addb63f4f202272ef7a231d589755171801e91b3f8d190a2a89bf8a73c0df58e4452af18d219da546d1072792ab4e8b99fec8a','6eYcz#T^m7qC##bAU4P9s8Sz^p6N2J3P%QwwVYU66qC5Eqe7L8&cKaMb@VXC$!9b$LwKYg%Gd9wJfnmzdeAybGVA2bB@LpnM5kc&yd$ku$t$QpVo%S59Tz4$u5jLsSmu'),
('Giovanni','Gialli','giovannigialli@ciao.it','XIPXTG9WSA9CG5CP','s','sd');

ALTER TABLE `Venditore`
MODIFY `CodiceVenditore` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Cliente` (`Nome`,`Cognome`,`Email`,`CodiceFiscale`,`Via`,`NumeroCivico`,`CAP`,`Città`) VALUES 
('Carlo','Verdone','carloverdone@ciao.it','S2C9JMIQIDQX0GG2','Maggiore','76','98878','Napoli'),
('Giancarlo','Gialli','giancarlogialli@ciao.it','CCCCF4NBV1UFAGBT','Popoli','2','12878','Milano');

ALTER TABLE `Cliente`
MODIFY `CodiceCliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `ContrattoLavoro` (`DataAssunzione`,`CostoDipendente`,`LivelloContrattuale`,`Venditore`,`Operaio`,`ARU`,`Progettista`,`ARU_inserimento`) VALUES 
('2023-09-18','30000','3','1',NULL,NULL,NULL,'1'),
('2023-07-12','35000','2','2',NULL,NULL,NULL,'2'),
('2022-06-18','25000','4',NULL,'1',NULL,NULL,'1'),
('2023-04-08','15000','3',NULL,'2',NULL,NULL,'1'),
('2018-01-18','40000','1',NULL,NULL,'1',NULL,'2'),
('2023-09-01','30000','3',NULL,NULL,'2',NULL,'1'),
('2023-02-01','10000','6',NULL,NULL,NULL,'1','1'),
('2023-09-18','30000','3',NULL,NULL,NULL,'2','2');

ALTER TABLE `ContrattoLavoro`
MODIFY `CodiceContratto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;



INSERT INTO `NumeroTelefonoARU` (`CodiceARU`,`NumeroTelefono`) VALUES 
('1','6611193075'),
('1','7601613423');



INSERT INTO `NumeroTelefonoOperaio` (`CodiceOperaio`,`NumeroTelefono`) VALUES 
('1','7044722700'),
('2','4534002886');



INSERT INTO `NumeroTelefonoProgettista` (`CodiceProgettista`,`NumeroTelefono`) VALUES 
('2','9146115476');



INSERT INTO `NumeroTelefonoVenditore` (`CodiceVenditore`,`NumeroTelefono`) VALUES 
('1','0733070880');



INSERT INTO `NumeroTelefonoCliente` (`CodiceCliente`,`NumeroTelefono`) VALUES 
('1','0569401806'),
('2','2911609826');



INSERT INTO `AnnoEconomico` (`AnnoRiferimento`,`CostoProgettisti`,`CostoVenditori`,`CostoOperai`,`CostoARU`,`CostoStampanti`,`CostoMateriale`,`EntrateProgettazione`,`EntrateProduzione`,`EntrateServizi`) VALUES
('2023','40000','75000','40000','70000','5000','5000','30000','45000','5000'),
('2022','20000','70000','25000','60000','5000','8000','30000','45000','4000'),
('2021','15000','75000','40000','80000','2000','5000','15000','15000','1000');



INSERT INTO `Stampante_3d` (`MarchioProduzione`,`Modello`,`NumeroSeriale`,`TipologiaStampa`,`OreStampa`) VALUES 
('Creality','Ender 3 Pro','4ZKgbxU6qO','Filamento','1'),
('Creality','Ender 3','nhQXyUW0K2','Filamento','120');

ALTER TABLE `Stampante_3d`
MODIFY `CodiceStampante` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Acquisto` (`Stampante`,`DataAcquisto`,`PrezzoAcquisto`,`Venditore`) VALUES 
('1','2023-09-18','300','1'),
('2','2023-09-18','500','1');



INSERT INTO `Manutenzione` (`Stampante`,`DataManutenzione`,`Descrizione`,`Operaio`) VALUES 
('1','2023-09-18','Stampante in ottimo stato','1'),
('2','2023-09-18','Da mandare in riparazione','1');



INSERT INTO `ServizioPostProduzione` (`NomeServizio`,`CostoServizio`) VALUES 
('Verniciatura','30'),
('Levigatura','10');

ALTER TABLE `ServizioPostProduzione`
MODIFY `CodiceServizio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Materiale` (`NomeMateriale`,`MarchioProduttore`,`PesoUnità`,`UnitàMagazzino`,`Tipologia`) VALUES 
('PLA','PLA s.r.l.','1000','1','Materiale Polimerico'),
('ABS','ABS inc.','1500','2','Materiale Polimerico');

ALTER TABLE `Materiale`
MODIFY `CodiceMateriale` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Corriere` (`NomeCorriere`) VALUES 
('Spedisco Facile'),
('Flash');

ALTER TABLE `Corriere`
MODIFY `CodiceCorriere` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Spedizione` (`DataSpedizione`,`Venditore`,`Corriere`) VALUES 
('2023-09-12','1','2');

ALTER TABLE `Spedizione`
MODIFY `CodiceSpedizione` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;



INSERT INTO `Ordine` (`NomeFile`,`TempoRichiesto`,`DataOrdine`,`QuantitàMateriale`,`Costo`,`Materiale`,`Venditore`, `Stampante`, `Cliente`, `Spedizione`) VALUES 
('Lampada.stl','600','2023-09-29','300','50','1','1','1','1',NULL),
('AutoModellino.stl','300','2023-09-12','150','80','1','1','2','1','1');

ALTER TABLE `Ordine`
MODIFY `CodiceOrdine` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



INSERT INTO `Compimento` (`Operaio`,`Servizio`) VALUES 
('1','2'),
('2','2'),
('2','1');



INSERT INTO `AcquistoMateriale` (`DataAcquisto`,`Venditore`) VALUES 
('2023-09-18','1'),
('2023-09-18','1');



INSERT INTO `Fornitura` (`Acquisto`,`Materiale`,`PrezzoAcquisto`) VALUES 
('1','1','500'),
('2','2','300');




INSERT INTO `Richiesta` (`Ordine`,`Servizio`) VALUES 
('1','1'),
('1','2');



INSERT INTO `Progettazione` (`Ordine`,`Progettista`,`CostoProgettazione`,`DataProgettazione`) VALUES 
('2','2','300','2023-09-01');