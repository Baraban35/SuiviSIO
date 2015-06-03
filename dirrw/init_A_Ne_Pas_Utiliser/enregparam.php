<?php
  $c="init"; //répertoire à renommer

  $nomserveur=$_POST["nomserveur"];
  $login=$_POST["login"];
  $mdp=$_POST["mdp"];
  $nombd=$_POST["nombd"];
  $prefixe=$_POST["prefixe"].'_';

  $lngmdp=$_POST["lngmdp"];
  $mdpadmin=substr($_POST["mdpadmin"],0,$lngmdp);

  try {
    if (!$param=@fopen("../param/param.ini.php","w"))
      throw new Exception('Création param.ini.php impossible (droit écriture ?)');
    fputs($param,"<?php\r\n");

    $lg='$nomServeur="'.$nomserveur.'";'."\r\n";
    fputs($param,$lg);
    $lg='$loginAdminServeur="'.$login.'";'."\r\n";
    fputs($param,$lg);
    $lg='$motPasseAdminServeur="'.$mdp.'";'."\r\n";
    fputs($param,$lg);
    $lg='$nomBaseDonnee="'.$nombd.'";'."\r\n";
    fputs($param,$lg);
    $lg='$prefixeTable="'.$prefixe.'";'."\r\n";
    fputs($param,$lg);

    if (isset($_POST["crypte"])){
    	$lg='$crypte=true;'."\r\n";
    	$mdpadminCr = md5($mdpadmin);
    }
    else {
    	$lg='$crypte=false;'."\r\n";
    	$mdpadminCr = $mdpadmin;
    }
    fputs($param,$lg);

    if (isset($_POST["smtp"]))
    	$lg='$smtp=true;'."\r\n";
    else
    	$lg='$smtp=false;'."\r\n";
    fputs($param,$lg);

    $lg='$melContact="'.$_POST["contact"].'";'."\r\n";
    fputs($param,$lg);

    $lg='$lngmdp='.$lngmdp.';'."\r\n";
    fputs($param,$lg);


    fputs($param,'?'.'>');
    fclose($param);



	  if (!$cn=@mysql_connect($nomserveur,$login,$mdp)) throw new Exception('Connexion impossible');

	  if (isset($_POST["creation"])){ //création bd
	    $req='drop database if exists '.$nombd;
	    mysql_query($req,$cn);
	    $req='create database '.$nombd;
	    if (!mysql_query($req,$cn)) throw new Exception('Cr&eacute;ation base impossible');
	  }
	  if (!mysql_select_db($nombd,$cn)) throw new Exception('Base non trouv&eacute;e');

	  include 'tb.php';
	  foreach($requete as $cle => $valeur)
	    if (!mysql_query($debut.$prefixe.$cle.'('.$valeur.$fin,$cn)) throw new Exception('Erreur cr&eacute;ation table '.$cle);

	  include 'cle.php';
	  foreach($cle as $reqcle)
	    if (!mysql_query($reqcle)) throw new Exception('Erreur sur FK / index '.$reqcle);

	  include 'data.php';
	  foreach($requete as $cle=>$valeur)
	    foreach($valeur as $ligne)
	      if (!mysql_query('insert into '.$prefixe.$cle.' values('.$ligne.');',$cn))
	      	throw new Exception('Erreur &eacute;criture table '.$cle);

	  $req='update '.$prefixe.'professeur set mel="'.$_POST["loginadmin"].'", mdp="'.$mdpadminCr.'" where num=1';
	  mysql_query($req,$cn);

	  mysql_close($cn);
	  echo 'Fin de l\'installation<br />';
	  echo 'Notez bien les identifiants de connexion de l\'administrateur :';
	  echo '<ul><li>Login = '.$_POST["loginadmin"].'</li>';
	  echo '<li>Code = '.$mdpadmin.'</li>';
	  echo '<li>Groupe = admins-00</li></ul>';
	  srand((float) microtime()*1000000);
	  $corigine=$c;
	  for($i=1;$i<=8;$i++)
	    $c.=chr(rand(0,25)+97);
	  if (rename("../".$corigine,"../".$c))
	    echo 'Le r&eacute;pertoire "'.$corigine.'" a &eacute;t&eacute; renomm&eacute; pour s&eacute;curiser l\'application';
	  else
	    throw new Exception('Manque (peut-être) droit d\'écriture sur le répertoire "dirrw"');

  } catch (Exception $e) {
    echo 'Erreur intercept&eacute;e : ',  $e->getMessage(), "\n";
  }
?>
