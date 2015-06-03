<?php
function __autoload($class_name) {
    require_once './ctrl/'.$class_name.'.class.php';
}

if (@opendir('dirrw/init/')) {
  echo 'Afin de s&eacute;curiser l\'application, vous devez renommer (de pr&eacute;f&eacute;rence) ou supprimer (au pire) le r&eacute;pertoire "init"';
} else {
  include_once './ctrl/util.class.php';
  session_start();

  if (!isset($_SESSION['ctrl'])){
    $util = Utilisateur::getInstance();
    include './dirrw/param/param.ini.php';
  } else {
    $util = $_SESSION['ctrl'];
  }

  include_once './dirrw/param/classes.class.php';
  if (!isset($_REQUEST["action"])){
    $ctrl= new Accueil($util,$_REQUEST);
  } else {
    $act=$_REQUEST["action"];
    if (in_array($act,$cl,TRUE) && ($util->estAuthent() || $act="authent")){
      if ($act=="chpromo"){
      	$util->changeGroupe($_REQUEST["legroupe"]);
      	$ctrl= new Eaccueil($util,"p");
      }	else {
      	$actm=ucfirst($act);
      	$ctrl = new $actm($util,$_REQUEST);
      }
    } else {
      //if ($util->estAuthent()) if ($util->estProf()) {
      //  @unlink('./dirrw/csv/'.substr('0000'.$util->getId(),-4,4).".csv");
      //}
      $util->init(0,null,null,-1,null);
      session_destroy();
      $ctrl= new Accueil($util,$_REQUEST);
    }
  }

  echo $ctrl->getView()->getPage();
}
?>
