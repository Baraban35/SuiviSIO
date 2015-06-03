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
      include './dirrw/param/param.ini.php';

      $this->serveur = $nomServeur;
      $this->bd = $nomBaseDonnee;
      $this->id = $loginAdminServeur;
      $this->mdp = $motPasseAdminServeur;
	  $this->pref = $prefixeTable;
    }

    public function connect()
    {//pas de gestion erreur, ça doit marcher quand on lui dit de marcher !
      $this->con = mysql_connect($this->serveur,$this->id,$this->mdp);
      mysql_select_db($this->bd,$this->con);
    }


    public function execSQLRes($req)
    {

      $i = 0;
      $res = mysql_query($req,$this->con);

      $tbRes = array();
      while ($ligne = mysql_fetch_assoc($res))
      {
        foreach ($ligne as $clef => $valeur)
           $tbRes[$i][$clef] = stripslashes($valeur);
        $i++;
      }
      mysql_free_result($res);
      return $tbRes ;
    }

    public function insertId()
    {
      return mysql_insert_id();
    }

    public function execSQL($req)
	{
	    //echo $req.'<br><br>';
      return mysql_query($req,$this->con);
    }


    public function sauveTables($id){
	   $this->connect();
	   $nomFic="./dirrw/exsv/export".date("w").".sql.gz";
	   $fic = gzopen($nomFic,'w');
	   $ressTables = mysql_query('show tables from '.$this->bd);
	   while ($lesTables = mysql_fetch_row($ressTables)) {
	      $uneTable = $lesTables[0];
	      if ($res = mysql_query('show create table '.$uneTable)) {
	         $tb = mysql_fetch_row($res);
	         gzwrite($fic, $tb[1].";\n");
	         $contenu = mysql_query('select * from '.$uneTable);
	         $nbChamps = mysql_num_fields($contenu);
	         while ($ligne = mysql_fetch_row($contenu)) {
	            $txt = 'insert into '.$uneTable.' values(';
	            for ($i=0; $i<$nbChamps; $i++)
	                $txt .= '\''.mysql_real_escape_string($ligne[$i]).'\',';
	            $txt = substr($txt, 0, -1);
	            gzwrite($fic, $txt.");\n");
	         }
	         mysql_free_result($contenu);
	         mysql_free_result($res);
	      }
	   }
	   gzclose($fic);
	   mysql_free_result($ressTables);
	   $this->close();
	   return $nomFic;
    }

    public function close()
    {
      mysql_close($this->con);
    }
  }
?>
