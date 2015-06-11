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

    public function __construct()
    {
        //block évitant un message d'erreur (notice) 
        //lorsque la fonction est appélée sans argument
        if (func_num_args()>= 1)
        {
            $test=func_get_args(1);
        }
        else 
        {
            $test[0]=NULL;
        }
        
        if ($test[0]!="test") {
            include './dirrw/param/param.ini.php'; //AppliWeb
        }
        else {
            include '../dirrw/param/param.ini.php'; //TestUnit
        }
      
      $this->serveur = $nomServeur;
      $this->bd = $nomBaseDonnee;
      $this->id = $loginAdminServeur;
      $this->mdp = $motPasseAdminServeur;
      $this->pref = $prefixeTable;      
    }

    public function connect()
    {//pas de gestion erreur, ça doit marcher quand on lui dit de marcher !
	$this->dataSourceName = "mysql:host=" . $this->serveur . ";dbname=" . $this->bd;
	$this->con = new PDO($this->dataSourceName, $this->id, $this->mdp);
        //$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


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

    public function insertId()
    {
      return $this->con->lastInsertId();
    }

    public function execSQL($req)
	{
	  //echo $req.'<br><br>';
	  return $this->con->exec($req);
    }


    public function sauveTables(){        
            $test=func_get_args(1);
            if ($test[0]!="test") {
                $nomFic="./dirrw/exsv/export".date("w").".sql.gz"; //AppliWeb
            }
            else {
                $nomFic="../dirrw/exsv/export".date("w").".sql.gz"; //TestUnit
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
                            $txt .= '\''.$this->con->quote($ligne[$i]).'\',';
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

    public function close()
    {
      $this->con=null;
    }
  }
?>
