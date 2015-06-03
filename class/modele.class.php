<?php
class Modele {
  protected $mysql=null;
  protected $pref;
  protected $lng;
  protected $mdpdefaut="ABCD";

  protected function dtj(){
    return date("Y-m-d");
  }

  protected function dtihm($d){
    return substr($d,8,2)."-".substr($d,5,2)."-".substr($d,0,4);
  }

  protected function dtMysql($d){
    return substr($d,6,4)."-".substr($d,3,2)."-".substr($d,0,2);
  }

  protected function getmdp(){

    srand((float) microtime()*1000000);
    $ch="ABCDEFGHJKLMPQRSTUVWXYZ23456789";
    $c="";
    $l=strlen($ch)-1;
    for($i=1;$i<=$this->lng;$i++) {
      $n=rand(0,$l);
      $c.=substr($ch,$n,1);
    }
    return $c;
  }

  protected function sauveTables($id){
  	return $this->mysql->sauveTables($id);
  }

  public function getLng(){
    return $this->lng;
  }

  public function __construct() {
    include_once './class/mysql.class.php';
    include './dirrw/param/param.ini.php';

    $this->lng=$lngmdp;

    $this->mysql = new Mysql();
    $this->mysql->connect();
    $this->pref=$prefixeTable;
  }

}

?>
