<?php
class Aide {
  private $e=array('<html><head><title>Aide</title>
  <link rel="stylesheet" media="screen" type="text/css" title="Aide" href="style.css" />
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   </head><body><h2><a name="sommaire"></a>Aide ','</h2><hr /><h3>Sommaire</h3>');

  private $c=array("e"=>"&Eacute;tudiant","p"=>"Professeur","a"=>"Administrateur");
  
  private $finentete='<p><a href="javascript:self.close(\'fenaide\');">Fermer la fen&ecirc;tre</a></p><hr />';

  private $finparagraphe='<table><tr><td><p><a href="#sommaire">sommaire</a></p></td>
    <td><p><a href="javascript:self.close(\'fenaide\');">fermer</a></p></td></tr></table><hr />';

  private $p=array('<h3><a name="','"></a>','</h3><p>','</p>');

  private $debut;
  private $texte;
  private $ref;
  
  public function __construct($ref){
    $this->debut='';
    $this->texte='';
    $this->ref=$ref;
    
    $dir=opendir('.');
    $reg="/^(".$ref.")[0-9]+(.txt.php)$/";
    while ($nf=readdir($dir)){
      if (preg_match($reg,$nf)){
        $fd = fopen($nf, "r");
        $ch = fread($fd, filesize ($nf));
        fclose($fd);
        $this->addparagraphe(explode('#',$ch));
      }
    }
    closedir($dir);
  }
  
  private function addparagraphe($elem){
    $this->debut.='<p><a href="#'.$elem[0].'">'.$elem[1].'</a></p>';
    for($i=0;$i<=2;$i++)
      $this->texte.=$this->p[$i].$elem[$i];
    $this->texte=$this->texte.$this->p[3].$this->finparagraphe;
  }
  
  private function getentete(){
    return $this->e[0].$this->c[$this->ref].$this->e[1].$this->debut.$this->finentete;
  }
  
  public function __toString(){
    return $this->getentete().$this->texte.'</body></html>';
  }
}

?>
