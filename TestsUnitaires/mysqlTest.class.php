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
     * M�thode red�finie dans le sc�nario de test
     * afin d'initialiser les ressources dans un contexte donn�, et ce, avant chaque test
     * On remet ici la base de donn�es dans l'�tat souhait� pour tester
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

        // instanciation d'un manager qui va servir � toutes les m�thodes de test
        $this->_unMysql = new Mysql("test");
        $this->_unMysql->connect();
    }
    /**
     * M�thode red�finie dans le sc�nario de test
     * afin d'initialiser les ressources dans un contexte donn�, et ce, avant chaque test
     * afin de lib�rer les ressources initialis�es, et ce, apr�s chaque test
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    
    protected function tearDown() {
        $this->_unMysql->close();
        unset($this->_unMysql);
    }

    /**
     * M�thode de test de la m�thode connect
     */
    public function testConnect() {
        //M�thode utilis�e dans les tests
    }
    
    /**
     * M�thode de test de la m�thode exeSqlRes
     * Cas de test : 	
     *      on v�rifie les lignes r�sultats d'une s�lection avec plusieurs lignes
     *      on v�rifie les lignes r�sultats d'une s�lection avec une seule ligne
     *      on v�rifie les lignes r�sultats d'une s�lection avec 0 ligne
     *      on v�rifie les lignes r�sultats d'une s�lection avec erreur de syntaxe
     */
    public function testExecSqlRes() {
        $lesResultatsCasUn = $this->_unMysql->execSqlRes("select * from port_processus");
        // on v�rifie le type du retour, le nombre d'�l�ments du tableau, et P1 dans 1�re ligne
        $this->assertTrue(is_array($lesResultatsCasUn));
        self::assertCount(5, $lesResultatsCasUn, "V�rification du nombre de lignes, cas de plusieurs lignes");
        self::assertContains("P1", $lesResultatsCasUn[0]);
        self::assertContains("P5", $lesResultatsCasUn[4]);
        
        $lesResultatsCasDeux = $this->_unMysql->execSqlRes("select * from port_processus where id=1");
        // on v�rifie le type du retour, le nombre d'�l�ments du tableau, et P1 dans 1�re ligne
        $this->assertTrue(is_array($lesResultatsCasDeux));
        self::assertCount(1, $lesResultatsCasDeux, "V�rification du nombre de lignes, cas d'une seule ligne");
        self::assertContains("P1", $lesResultatsCasDeux[0]);
        
        $lesResultatsCasTrois = $this->_unMysql->execSqlRes("select * from port_processus where id=42");
        // on v�rifie le type du retour, le nombre d'�l�ments du tableau
        $this->assertTrue(is_array($lesResultatsCasTrois));
        self::assertCount(0, $lesResultatsCasTrois, "V�rification du nombre de lignes, cas de z�ro ligne");
                
        $lesResultatsCasQuatre = $this->_unMysql->execSqlRes("select from port_processus");
        // on v�rifie le type du retour, le nombre d'�l�ments du tableau
        $this->assertTrue(is_array($lesResultatsCasQuatre));
        self::assertCount(0, $lesResultatsCasQuatre, "V�rification du nombre de lignes, cas d'une erreur de syntaxe");
    }
    
    /**
     * M�thode de test de la m�thode insertId
     * Cas de test :
     *      on v�rifie la valeur du dernier ID g�n�r� par la derni�re requ�te en cas de succ�s
     *      on v�rifie la valeur du dernier ID g�n�r� par la derni�re requ�te, si aucun ID n'est g�n�r�
     *      (INVALIDE) on v�rifie la valeur du dernier ID g�n�r� par la derni�re requ�te, si aucune connexion n'a �t� �tablie 
     */
    public function testInsertId() {
        //requ�te test
        $this->_unMysql->execSql("insert into `port_professeur` values (NULL, 'Test', 'Unit', 'unit.test@gmail.com', 'azerty', '0', NULL)");
        $dernierAjoutCasUn = $this->_unMysql->insertId();
        // on v�rifie le type du retour, et sa valeur
        $this->assertTrue(is_string($dernierAjoutCasUn));
        self::assertequals("42", $dernierAjoutCasUn); //la valeur voulue peut varier en fonction du nombre de fois que l'on ex�cute le test
        //suppression de la ligne ajout�e
	$this->_unMysql->execSql("delete from `port_professeur` where nom='Test'");
		
        //requ�te test
        $this->_unMysql->execSql("select * from `port_professeur`");
        $dernierAjoutCasDeux = $this->_unMysql->insertId();
        // on v�rifie le type du retour, et sa valeur
        $this->assertTrue(is_string($dernierAjoutCasDeux));
        self::assertequals("0", $dernierAjoutCasDeux);
        
        /*
         * 
        //d�connexion
        $this->_unMysql->close();
        $dernierAjoutCasTrois = $this->_unMysql->insertId();
        // on v�rifie le type du retour, et sa valeur
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
     * M�thode de test de la m�thode execSql
     * Cas de test : 
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre INSERT (une seule ligne aff�ct�e)
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre INSERT (plusieurs lignes aff�ct�es)
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre UPDATE (une seule ligne aff�ct�e)
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre UPDATE (plusieurs lignes aff�ct�es)
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre DELETE (une seule ligne aff�ct�e)
     *      on v�rifie l'�x�cution d'une requ�te SQL qui utilise l'ordre DELETE (plusieurs lignes aff�ct�es)
     */
    public function testExecSql() {
        //suppression du contenu de la table port_etudiant
	$this->_unMysql->execSql("delete from `port_etudiant` where nom='update2'");
        
        //requ�te test�e
        $nbLignesAffecteesCasUn = $this->_unMysql->execSql("insert into `port_etudiant` values (NULL, 1, 'Test1', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O')");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasUn));
        self::assertequals(1, $nbLignesAffecteesCasUn);
        
        //requ�te test�e
        $nbLignesAffecteesCasDeux = $this->_unMysql->execSql("insert into `port_etudiant` values (NULL, 1, 'Test2a', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O'), (NULL, 2, 'Test2b', 'Unit', 'unit.test@gmail.com', 'azerty', NULL, 'O')");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasDeux));
        self::assertequals(2, $nbLignesAffecteesCasDeux);
        
        //requ�te test�e
        $nbLignesAffecteesCasTrois = $this->_unMysql->execSql("update `port_etudiant` set nom='update2' where nom='Test2a'");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasTrois));
        self::assertequals(1, $nbLignesAffecteesCasTrois);
        
        //requ�te test�e
        $nbLignesAffecteesCasQuatre = $this->_unMysql->execSql("update `port_etudiant` set nom='update2' where nom='Test2b' OR nom='Test1'");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasQuatre));
        self::assertequals(2, $nbLignesAffecteesCasQuatre);
        
        //requ�te test�e
        $nbLignesAffecteesCasCinq = $this->_unMysql->execSql("delete from `port_etudiant` where numGroupe=2");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasCinq));
        self::assertequals(1, $nbLignesAffecteesCasCinq);
        
        //requ�te test�e
        $nbLignesAffecteesCasSix = $this->_unMysql->execSql("delete from `port_etudiant` where nom='update2'");
        //v�rification du type de retour, et de sa valeur        
        $this->assertTrue(is_int($nbLignesAffecteesCasSix));
        self::assertequals(2, $nbLignesAffecteesCasSix);
        
    }
    
    /**
     * M�thode de test de la m�thode sauvesTables
     * Cas de test : 
     *      on v�rifie la pr�sence du fichier
     */
    public function testSauveTables() {
        $this->_unMysql->sauveTables("test");
        $nomFic="../dirrw/exsv/export".date("w").".sql.gz";
        $presence=  file_exists($nomFic);
        self::assertequals(true, $presence, "V�rification de pr�sence du fichier");
    }
    
    /**
     * M�thode de test de la m�thode close
     */
    public function testClose() {
        //M�thode utilis�e dans les tests
    }

}
