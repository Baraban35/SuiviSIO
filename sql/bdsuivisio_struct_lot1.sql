
-- -----------------------------------------------------------------------------
--       TABLE : port_type
-- -----------------------------------------------------------------------------

CREATE TABLE port_type
   (
    code INT(6)  NOT NULL,
    libelle CHAR(12)  NOT NULL
,   CONSTRAINT PK_port_type PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_TYPOLOGIE
-- -----------------------------------------------------------------------------

CREATE TABLE port_typologie
   (
    code INT(6)  NOT NULL,
    lngUtile INT(6)  NOT NULL,
    libelle VARCHAR(85)  NOT NULL
,   CONSTRAINT PK_port_typologie PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_CADRE
-- -----------------------------------------------------------------------------

CREATE TABLE port_cadre
   (
    code INT(6)  NOT NULL,
    libelle CHAR(20)  NOT NULL
,   CONSTRAINT PK_port_cadre PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PARCOURS
-- -----------------------------------------------------------------------------

CREATE TABLE port_parcours
   (
    id INT(6)  NOT NULL,
    nomenclature CHAR(4)  NOT NULL,
    libelle VARCHAR(50)  NOT NULL
,   CONSTRAINT PK_port_parcours PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PROCESSUS
-- -----------------------------------------------------------------------------

CREATE TABLE port_processus
   (
    id INT(6)  NOT NULL,
    nomenclature CHAR(2)  NOT NULL,
    libelle VARCHAR(60)  NOT NULL
,   CONSTRAINT PK_port_processus PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_professeur
-- -----------------------------------------------------------------------------

CREATE TABLE port_professeur
   (
    num INT(11)  NOT NULL,
    nom CHAR(32)  NOT NULL,
    prenom CHAR(32)  NOT NULL,
    mel CHAR(64)  NOT NULL,
    mdp CHAR(32)  NOT NULL,
    niveau INT(11)  NOT NULL,
    valide CHAR(1) 
      DEFAULT 'O' NULL
,   CONSTRAINT PK_port_professeur PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_epreuve
-- -----------------------------------------------------------------------------

CREATE TABLE port_epreuve
   (
    id INT(6)  NOT NULL,
    nomenclature CHAR(4)  NOT NULL
,   CONSTRAINT PK_port_epreuve PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_groupe
-- -----------------------------------------------------------------------------

CREATE TABLE port_groupe
   (
    num INT(11)  NOT NULL,
    nom CHAR(12) 
      DEFAULT NULL,
    annee CHAR(2) 
      DEFAULT NULL,
    idParcours INT(6) 
      DEFAULT 0
,   CONSTRAINT PK_port_groupe PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_localisation
-- -----------------------------------------------------------------------------

CREATE TABLE port_localisation
   (
    code INT(6)  NOT NULL,
    libelle CHAR(32)  NOT NULL
,   CONSTRAINT PK_port_localisation PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_domaine
-- -----------------------------------------------------------------------------

CREATE TABLE port_domaine
   (
    id INT(6)  NOT NULL,
    idProcessus INT(6)  NOT NULL,
    nomenclature CHAR(4)  NOT NULL,
    libelle VARCHAR(60)  NOT NULL
,   CONSTRAINT PK_port_domaine PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_source
-- -----------------------------------------------------------------------------

CREATE TABLE port_source
   (
    code INT(6)  NOT NULL,
    libelle CHAR(20)  NOT NULL,
    codeTypeSource INT(6) 
      DEFAULT NULL
,   CONSTRAINT PK_port_source PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_activite
-- -----------------------------------------------------------------------------

CREATE TABLE port_activite
   (
    id INT(6)  NOT NULL,
    idDomaine INT(6)  NOT NULL,
    nomenclature CHAR(7)  NOT NULL,
    lngUtile INT(6)  NOT NULL,
    libelle VARCHAR(150)  NOT NULL
,   CONSTRAINT PK_port_activite PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_activitecitee
-- -----------------------------------------------------------------------------

CREATE TABLE port_activitecitee
   (
    idActivite INT(6)  NOT NULL,
    refSituation INT(11)  NOT NULL,
    commentaire TEXT  NULL
,   CONSTRAINT PK_port_activitecitee PRIMARY KEY (IDACTIVITE, REFSITUATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_esttypo
-- -----------------------------------------------------------------------------

CREATE TABLE port_esttypo
   (
    refSituation INT(11)  NOT NULL DEFAULT 0,
    codeTypologie INT(6)  NOT NULL DEFAULT 0
,   CONSTRAINT PK_port_esttypo PRIMARY KEY (REFSITUATION, CODETYPOLOGIE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_etudiant
-- -----------------------------------------------------------------------------

CREATE TABLE port_etudiant
   (
    num INT(11)  NOT NULL,
    numGroupe INT(11) 
      DEFAULT NULL,
    nom CHAR(32)  NOT NULL,
    prenom CHAR(32)  NOT NULL,
    mel CHAR(64)  NOT NULL,
    mdp CHAR(32)  NOT NULL,
    numExam CHAR(16) 
      DEFAULT NULL,
    valide CHAR(1) NOT NULL DEFAULT 'O'
,   CONSTRAINT PK_port_etudiant PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_evalue
-- -----------------------------------------------------------------------------

CREATE TABLE port_evalue
   (
    idParcours INT(6)  NOT NULL DEFAULT 0,
    idEpreuve INT(6)  NOT NULL DEFAULT 0,
    idActivite INT(6)  NOT NULL DEFAULT 0
,   CONSTRAINT PK_port_evalue PRIMARY KEY (IDPARCOURS, IDEPREUVE, IDACTIVITE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_exerce
-- -----------------------------------------------------------------------------

CREATE TABLE port_exerce
   (
    numProfesseur INT(11)  NOT NULL,
    numGroupe INT(11)  NOT NULL
,   CONSTRAINT PK_port_exerce PRIMARY KEY (NUMPROFESSEUR, NUMGROUPE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_exploite
-- -----------------------------------------------------------------------------

CREATE TABLE port_exploite
   (
    idParcours INT(6)  NOT NULL DEFAULT 0,
    idProcessus INT(6) NOT NULL DEFAULT 0
,   CONSTRAINT PK_port_exploite PRIMARY KEY (IDPARCOURS, IDPROCESSUS)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_production
-- -----------------------------------------------------------------------------

CREATE TABLE port_production
   (
    numero INT(11)  NOT NULL,
    refSituation INT(11)  NOT NULL,
    designation VARCHAR(1024) 
      DEFAULT NULL,
    adresse VARCHAR(255) 
      DEFAULT NULL
,   CONSTRAINT PK_port_production PRIMARY KEY (NUMERO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_situation
-- -----------------------------------------------------------------------------

CREATE TABLE port_situation
   (
    ref INT(11)  NOT NULL,
    numEtudiant INT(11)  NOT NULL,
    codeSource INT(6)  NOT NULL,
    codeType INT(6)  NOT NULL,
    codeCadre INT(6)  NOT NULL,
    libCourt VARCHAR(128)  NOT NULL,
    descriptif TEXT	NOT NULL,
    contexte TEXT  NULL,
    dateDebut DATE 
      DEFAULT NULL,
    dateFin DATE 
      DEFAULT NULL,
    environnement TEXT  NULL,
    moyen TEXT  NULL,
    avisPerso TEXT  NULL,
    valide CHAR(1) NOT NULL DEFAULT 'O',
    dateModif DATE 
      DEFAULT NULL,
    codeLocalisation INT(6)  NOT NULL
,   CONSTRAINT PK_port_situation PRIMARY KEY (REF)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_commentaire
-- -----------------------------------------------------------------------------

CREATE TABLE port_commentaire
   (
    numero INT(11)  NOT NULL,
    refSituation INT(11) 
      DEFAULT NULL,
    numProfesseur INT(11) 
      DEFAULT NULL,
    commentaire TEXT  NULL,
    dateCommentaire DATE 
      DEFAULT NULL
,   CONSTRAINT PK_port_commentaire PRIMARY KEY (NUMERO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : port_competence
-- -----------------------------------------------------------------------------

CREATE TABLE port_competence
   (
    id INT(6)  NOT NULL,
    idActivite INT(6)  NOT NULL,
    nomenclature CHAR(9)  NOT NULL,
    libelle VARCHAR(210)  NOT NULL
,   CONSTRAINT PK_port_competence PRIMARY KEY (ID)  
   ) ;


-- -----------------------------------------------------------------------------
-- AJOUT DE LA CONTRAINTE AUTO_INCREMENT SUR CLES PRIMAIRES
-- -----------------------------------------------------------------------------

ALTER TABLE port_commentaire
  MODIFY numero int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_etudiant
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_groupe
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_production
  MODIFY numero int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_professeur
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_situation
  MODIFY ref int(11) NOT NULL AUTO_INCREMENT;

-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------

ALTER TABLE port_domaine ADD (
     CONSTRAINT FK_DOMAINE_PROCESSUS
          FOREIGN KEY (idProcessus)
               REFERENCES port_processus (id))   ;

ALTER TABLE port_source ADD (
     CONSTRAINT FK_SOURCE_TYPE
          FOREIGN KEY (codeTypeSource)
               REFERENCES port_type (code))   ;

ALTER TABLE port_activite ADD (
     CONSTRAINT FK_ACTIVITE_DOMAINE
          FOREIGN KEY (idDomaine)
               REFERENCES port_domaine (id))   ;

ALTER TABLE port_activitecitee ADD (
     CONSTRAINT FK_ACTIVITECITEE_SITUATION
          FOREIGN KEY (refSituation)
               REFERENCES port_situation (ref))   ;

ALTER TABLE port_activitecitee ADD (
     CONSTRAINT port_activitecitee_ACTIVITE
          FOREIGN KEY (idActivite)
               REFERENCES port_activite (id))   ;

ALTER TABLE port_esttypo ADD (
     CONSTRAINT FK_ESTTYPO_SITUATION
          FOREIGN KEY (refSituation)
               REFERENCES port_situation (ref))   ;

ALTER TABLE port_esttypo ADD (
     CONSTRAINT FK_ESTTYPO_TYPOLOGIE
          FOREIGN KEY (codeTypologie)
               REFERENCES port_typologie (code))   ;

ALTER TABLE port_etudiant ADD (
     CONSTRAINT FK_ETUDIANT_GROUPE
          FOREIGN KEY (numGroupe)
               REFERENCES port_groupe (num))   ;

ALTER TABLE port_evalue ADD (
     CONSTRAINT FK_EVALUE_PARCOURS
          FOREIGN KEY (idParcours)
               REFERENCES port_parcours (id))   ;

ALTER TABLE port_evalue ADD (
     CONSTRAINT FK_EVALUE_EPREUVE
          FOREIGN KEY (idEpreuve)
               REFERENCES port_epreuve (id))   ;

ALTER TABLE port_evalue ADD (
     CONSTRAINT FK_EVALUE_ACTIVITE
          FOREIGN KEY (idActivite)
               REFERENCES port_activite (id))   ;

ALTER TABLE port_exerce ADD (
     CONSTRAINT FK_EXERCE_PROFESSEUR
          FOREIGN KEY (numProfesseur)
               REFERENCES port_professeur (num))   ;

ALTER TABLE port_exerce ADD (
     CONSTRAINT FK_EXERCE_GROUPE
          FOREIGN KEY (numGroupe)
               REFERENCES port_groupe (num))   ;

ALTER TABLE port_exploite ADD (
     CONSTRAINT FK_EXPLOITE_PARCOURS
          FOREIGN KEY (idParcours)
               REFERENCES port_parcours (id))   ;

ALTER TABLE port_exploite ADD (
     CONSTRAINT FK_EXPLOITE_PROCESSUS
          FOREIGN KEY (idProcessus)
               REFERENCES port_processus (id))   ;

ALTER TABLE port_production ADD (
     CONSTRAINT FK_PRODUCTION_SITUATION
          FOREIGN KEY (refSituation)
               REFERENCES port_situation (ref))   ;

ALTER TABLE port_situation ADD (
     CONSTRAINT FK_SITUATION_ETUDIANT
          FOREIGN KEY (numEtudiant)
               REFERENCES port_etudiant (num))   ;

ALTER TABLE port_situation ADD (
     CONSTRAINT FK_SITUATION_TYPE
          FOREIGN KEY (codeType)
               REFERENCES port_type (code))   ;

ALTER TABLE port_situation ADD (
     CONSTRAINT FK_SITUATION_SOURCE
          FOREIGN KEY (codeSource)
               REFERENCES port_source (code))   ;

ALTER TABLE port_situation ADD (
     CONSTRAINT FK_SITUATION_CADRE
          FOREIGN KEY (codeCadre)
               REFERENCES port_cadre (code))   ;

ALTER TABLE port_situation ADD (
     CONSTRAINT FK_port_situation_PORT_LOCALIS
          FOREIGN KEY (codeLocalisation)
               REFERENCES port_localisation (code))   ;

ALTER TABLE port_commentaire ADD (
     CONSTRAINT FK_COMMENTAIRE_SITUATION
          FOREIGN KEY (refSituation)
               REFERENCES port_situation (ref))   ;

ALTER TABLE port_competence ADD (
     CONSTRAINT FK_COMPETENCE_ACTIVITE
          FOREIGN KEY (idActivite)
               REFERENCES port_activite (id))   ;


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------

