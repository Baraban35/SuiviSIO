<?php
  class Mysql
  {
    private
      $serveur = '',
      $bd = '',
      $id = '',
      $mdp = '',
      $pref= '',
      $con=null;

    /** 
     * @function __construct
     *
     * @param boolean      $estModeTest    Un booleen faux par defaut (false)
     *  
     * Permet d'initialiser un objet de la classe Mysql.
     */
    public function __construct($estModeTest=false)
    {        
        if ($estModeTest) {
            include '../dirrw/param/param.ini.php'; //TestUnit
        }
        else {
            include './dirrw/param/param.ini.php'; //AppliWeb
        }
      
      $this->serveur = $nomServeur;
      $this->bd = $nomBaseDonnee;
      $this->id = $loginAdminServeur;
      $this->mdp = $motPasseAdminServeur;
      $this->pref = $prefixeTable;      
    }

    /** 
     * @function connect
     *    
     * Permet d'établir la connexion ? la base de données
     */
    public function connect()
    {//pas de gestion erreur, ça doit marcher quand on lui dit de marcher !
	$this->dataSourceName = "mysql:host=" . $this->serveur . ";dbname=" . $this->bd;
	$this->con = new PDO($this->dataSourceName, $this->id, $this->mdp);
        //$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** 
     * @function execSQLRes
     *
     * @param string       $req     Une chaîne contenant un ordre SQL   
     *
     * @return array       $tbRes   Un tableau ? indice numérique contenant le résultat de l'ordre SQL ordonné par ligne
     *
     * Permet d'envoyer un ordre SQL ? la base de données et de retourner un tableau qui contient les lignes résultats.
     */
    public function execSQLRes($req)
    {
	  $i = 0;
	  $res = $this->con->query($req);
	  
	  $tbRes = array();
	  if($res!=false)
	  {
		while ($ligne = $res->fetch(PDO::FETCH_ASSOC))
		{
                    foreach ($ligne as $clef => $valeur)
                        $tbRes[$i][$clef] = stripslashes($valeur);
                    $i++;
		}
		$res->closecursor();
	  }
	  return $tbRes ;
    }
    
    /**
     * @function insertId
     * 
     * @return int       $dernierAjout    Un entier correspondant ? la valeur du dernier ID inséré dans un champ de type AUTO_INCREMENT
     * 
     * Permet de connaitre la valeur du dernier ID, attribué automatiquement, dans la base de données.
     */
    public function insertId()
    {
      $dernierAjout=$this->con->lastInsertId();
      if (is_string($dernierAjout))
      {
        $dernierAjout=intval($dernierAjout);
      }
      return $dernierAjout;
    }
    
    /**
     * @function execSQL
     * 
     * @param string        $req    Une chaîne contenant un ordre SQL  
     * 
     * @return int          Un entier indiquant le nombre de lignes affectées par l'ordre SQL
     * 
     * Permet d'envoyer un ordre SQL ? la base de données.
     */
    public function execSQL($req)
	{
	  //echo $req.'<br><br>';
	  return $this->con->exec($req);
    }

    /**
     * @function sauveTables
     * 
     * @param boolean      $estModeTest    Un booleen faux par defaut (false)
     * 
     * @return string       $nomFic Une chaîne portant le nom du fichier
     * 
     * Permet de sauvegarder l'état de la base de données dans un fichier SQL compressé.
     */
    public function sauveTables($id, $estModeTest=false){
            if ($estModeTest) {
                $nomFic="../dirrw/exsv/export".date("w").".sql.gz"; //TestUnit
            }
            else {
                $nomFic="./dirrw/exsv/export".date("w").".sql.gz"; //AppliWeb
            }	 
            
            $fic = gzopen($nomFic,'w');
            $ressTables = $this->con->query('show tables from '.$this->bd);
            while ($lesTables = $ressTables->fetch(PDO::FETCH_NUM)) {
		$uneTable = $lesTables[0];
                $res = $this->con->query('show create table '.$uneTable);
		if ($res!=false) {			
                    $tb = $res->fetch(PDO::FETCH_NUM);
                    gzwrite($fic, $tb[1].";\n");
                    $contenu = $this->con->query('select * from '.$uneTable);
                    $nbChamps = $contenu->columnCount();
                    while ($ligne = $contenu->fetch(PDO::FETCH_NUM)) {
                        $txt = 'insert into '.$uneTable.' values(';
                        for ($i=0; $i<$nbChamps; $i++)
                        $txt .=$this->con->quote($ligne[$i]).",";
                        $txt = substr($txt, 0, -1);
                        gzwrite($fic, $txt.");\n");			 
                    }
                $contenu->closecursor();
                $res->closecursor();
                }
            }
            gzclose($fic);
            $ressTables->closecursor();
            return $nomFic;  
	}

    /**
     * @function close
     * 
     * Permet de détruire la connexion
     */
    public function close()
    {
      $this->con=null;
    }
  }
?>
