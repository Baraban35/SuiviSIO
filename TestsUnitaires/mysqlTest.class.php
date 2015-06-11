<?php
require_once("../class/mysql.class.php");

/**
 * Classe de test de la classe Mysql
 * @author baraban
 *
 */
class MySqlTest extends PHPUnit_Framework_TestCase {
    /**
     * @var _unMysql string 
     */
    private  $_unMysql;

    /**
     * Méthode redéfinie dans le scénario de test
     * afin d'initialiser les ressources dans un contexte donné, et ce, avant chaque test
     * On remet ici la base de données dans l'état souhaité pour tester
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp() {
        $hote = "localhost";
        $nomBD = "portefeuille";
        $compte = "portefeuille";
        $mdp = "portefeuille";
        $monPdo = new PDO("mysql:host=" . $hote . ";dbname=" . $nomBD, $compte, $mdp);
        $monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // $monPdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES \'UTF8\'");

        // suppression de lignes d'une ou plusieurs tables
        // $monPdo->exec("delete from xxx");

        // insertion des lignes du jeu d'essai insertDonneesTests.sql
        //$req = file_get_contents("insertProcessus.sql", "./");
        
        // supprimer les sauts de ligne dans le texte de la commande
        //$req = str_replace("\n", "", $req);
        //$req = str_replace("\r", "", $req);
        //$monPdo->exec($req);
        
        unset($monPdo);

        // instanciation d'un manager qui va servir à toutes les méthodes de test
        $this->_unMysql = new Mysql("test");
        $this->_unMysql->connect();
    }
    /**
     * Méthode redéfinie dans le scénario de test
     * afin d'initialiser les ressources dans un contexte donné, et ce, avant chaque test
     * afin de libérer les ressources initialisées, et ce, après chaque test
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    
    protected function tearDown() {
        $this->_unMysql->close();
        unset($this->_unMysql);
    }

    /**
     * Méthode de test de la méthode connect
     */
    public function testConnect() {
        //Méthode utilisée dans les tests
    }
    
    /**
     * Méthode de test de la méthode exeSqlRes
     * Cas de test : 	
     *      on vérifie les lignes résultats d'une sélection avec plusieurs lignes
     *      on vérifie les lignes résultats d'une sélection avec une seule ligne
     *      on vérifie les lignes résultats d'une sélection avec 0 ligne
     *      on vérifie les lignes résultats d'une sélection avec erreur de syntaxe
     */
    public function testExecSqlRes() {
        $lesResultatsCasUn = $this->_unMysql->execSqlRes("select * from port_processus");
        // on vérifie le type du retour, le nombre d'éléments du tableau, et P1 dans 1ère ligne
        $this->assertTrue(is_array($lesResultatsCasUn));
        self::assertCount(5, $lesResultatsCasUn, "Vérification du nombre de lignes, cas de plusieurs lignes");
        self::assertContains("P1", $lesResultatsCasUn[0]);
        self::assertContains("P5", $lesResultatsCasUn[4]);
        
        $lesResultatsCasDeux = $this->_unMysql->execSqlRes("select * from port_processus where id=1");
        // on vérifie le type du retour, le nombre d'éléments du tableau, et P1 dans 1ère ligne
        $this->assertTrue(is_array($lesResultatsCasDeux));
        self::assertCount(1, $lesResultatsCasDeux, "Vérification du nombre de lignes, cas d'une seule ligne");
        self::assertContains("P1", $lesResultatsCasDeux[0]);
        
        $lesResultatsCasTrois = $this->_unMysql->execSqlRes("select * from port_processus where id=42");
        // on vérifie le type du retour, le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesResultatsCasTrois));
        self::assertCount(0, $lesResultatsCasTrois, "Vérification du nombre de lignes, cas de zéro ligne");
                
        $lesResultatsCasQuatre = $this->_unMysql->execSqlRes("select from port_processus");
        // on vérifie le type du retour, le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesResultatsCasQuatre));
        self::assertCount(0, $lesResultatsCasQuatre, "Vérification du nombre de lignes, cas d'une erreur de syntaxe");
    }
    
    /**
     * Méthode de test de la méthode insertId
     * Cas de test :
     *      on vérifie la valeur du dernier ID généré par la dernière requête en cas de succès
     *      on vérifie la valeur du dernier ID généré par la dernière requête, si aucun ID n'est généré
     *      (INVALIDE) on vérifie la valeur du dernier ID généré par la dernière requête, si aucune connexion n'a été établie 
     */
    public function testInsertId() {
        //requête test
        $this->_unMysql->execSql("insert into `port_professeur` values (NULL, 'Test', 'Unit', 'unit.test@gmail.com', 'azerty', '0', NULL)");
        $dernierAjoutCasUn = $this->_unMysql->insertId();
        // on vérifie le type du retour, et sa valeur
        $this->assertTrue(is_string($dernierAjoutCasUn));
        self::assertequals("42", $dernierAjoutCasUn); //la valeur voulue peut varier en fonction du nombre de fois que l'on exécute le test
        //suppression de la ligne ajoutée
	$this->_unMysql->execSql("delete from `port_professeur` where nom='Test'");
		
        //requête test
        $this->_unMysql->execSql("select * from `port_professeur`");
        $dernierAjoutCasDeux = $this->_unMysql->insertId();
        // on vérifie le type du retour, et sa valeur
        $this->assertTrue(is_string($dernierAjoutCasDeux));
        self::assertequals("0", $dernierAjoutCasDeux);
        
        /*
         * 
        //déconnexion
        $this->_unMysql->close();
        $dernierAjoutCasTrois = $this->_unMysql->insertId();
        // on vérifie le type du retour, et sa valeur
        $this->assertTrue(is_bool($dernierAjoutCasTrois));
        self::assertequals(false, $dernierAjoutCasTrois);
        //reconnexion
        $hote = "localhost";
        $nomBD = "portefeuille"; 
        $compte = "portefeuille";
        $mdp = "portefeuille";
        $this->_unMysql = new Mysql($hote, $nomBD, $compte, $mdp);
        $this->_unMysql->connect();
         * 
         */
    }
        
    /**
     * Méthode de test de la méthode execSql
     * Cas de test : 
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre INSERT (une seule ligne afféctée)
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre INSERT (plusieurs lignes afféctées)
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre UPDATE (une seule ligne afféctée)
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre UPDATE (plusieurs lignes afféctées)
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre DELETE (une seule ligne afféctée)
     *      on vérifie l'éxécution d'une requête SQL qui utilise l'ordre DELETE (plusieurs lignes afféctées)
     */
    public function testExecSql() {
        //suppression du contenu de la table port_etudiant
	$this->_unMysql->execSql("delete from `port_etudiant` where nom='update2'");
        
        //requête testée
        $nbLignesAffecteesCasUn = $this->_unMysql->execSql("insert into `port_etudiant` values (NULL, 1, 'Test1', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O')");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasUn));
        self::assertequals(1, $nbLignesAffecteesCasUn);
        
        //requête testée
        $nbLignesAffecteesCasDeux = $this->_unMysql->execSql("insert into `port_etudiant` values (NULL, 1, 'Test2a', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O'), (NULL, 2, 'Test2b', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O')");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasDeux));
        self::assertequals(2, $nbLignesAffecteesCasDeux);
        
        //requête testée
        $nbLignesAffecteesCasTrois = $this->_unMysql->execSql("update `port_etudiant` set nom='update2' where nom='Test2a'");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasTrois));
        self::assertequals(1, $nbLignesAffecteesCasTrois);
        
        //requête testée
        $nbLignesAffecteesCasQuatre = $this->_unMysql->execSql("update `port_etudiant` set nom='update2' where nom='Test2b' OR nom='Test1'");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasQuatre));
        self::assertequals(2, $nbLignesAffecteesCasQuatre);
        
        //requête testée
        $nbLignesAffecteesCasCinq = $this->_unMysql->execSql("delete from `port_etudiant` where numGroupe=2");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasCinq));
        self::assertequals(1, $nbLignesAffecteesCasCinq);
        
        //requête testée
        $nbLignesAffecteesCasSix = $this->_unMysql->execSql("delete from `port_etudiant` where nom='update2'");
        //vérification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasSix));
        self::assertequals(2, $nbLignesAffecteesCasSix);
        
    }
    
    /**
     * Méthode de test de la méthode sauvesTables
     * Cas de test : 
     *      on vérifie la présence du fichier
     */
    public function testSauveTables() {
        $this->_unMysql->sauveTables("test");
        $nomFic="../dirrw/exsv/export".date("w").".sql.gz";
        $presence=  file_exists($nomFic);
        self::assertequals(true, $presence, "Vérification de présence du fichier");
    }
    
    /**
     * Méthode de test de la méthode close
     */
    public function testClose() {
        //Méthode utilisée dans les tests
    }

}
