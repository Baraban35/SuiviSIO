delete from port_processus ;
alter table port_processus auto_increment 1;
INSERT INTO `port_processus` ( `nomenclature`, `libelle`) VALUES
('P1', 'Production de services'),
('P2', 'Fourniture de services'),
('P3', 'Conception et maintenance de solutions d?infrastructure'),
('P4', 'Conception et maintenance de solutions applicatives'),
('P5', 'Gestion de patrimoine informatique');

