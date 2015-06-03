<?php
include_once './class/view.class.php';

class Utilisateur{

  private static $instance = null;
  private $authent=false;
  private $id=null;
  private $nom=null;
  private $prenom=null;
  private $niveau=-1; //admin/prof RW/profLecteur/etudiant=0/1/2/3
  private $groupe=null; //nommé "promotion" dans les ihm
  private $an=null;
  private $numgroupe=0;
  private $melContact='';
  private $groupes=null;



  public static function getInstance()
  {
  if (is_null(self::$instance)){
    self::$instance = new self();
  }
    return self::$instance;
  }

  private function __construct(){
    include './dirrw/param/param.ini.php';
    $this->melContact=$melContact;
  }

  public function init($id,$n,$p,$niv,$grps) {
    $this->authent = !is_null($n);
    $this->nom = $n;
    $this->prenom = $p;
    $this->id = $id;
    $this->niveau = $niv;
    $this->groupes=$grps;//tableau asso de groupes [num/nom/annee]
    if (count($this->groupes)>0) {
    	$this->groupe=$grps[0]["nom"];//pour eleve un seul groupe ; pour prof le premier par défaut
    	$this->an=$grps[0]["annee"];
    	$this->numgroupe=$grps[0]["num"];
    }
  }

  public function getMelContact(){
    return $this->melContact;
  }
  public function changeGroupe($n){
  	$i=0;
  	while($i<count($this->groupes) && $this->groupes[$i]["num"]!=$n) $i++;
  	if ($i<count($this->groupes)) { //toujours vrai normalement : on change de groupe
  		$this->numgroupe = $n;
  		$this->groupe = $this->groupes[$i]["nom"];
  		$this->an = $this->groupes[$i]["annee"];
  	}//sinon on reste sur le meme
  }

  public function estAuthent(){
    return $this->authent;
  }

  public function getNom() {
    return $this->nom;
  }

  public function getPrenom() {
    return $this->prenom;
  }

  public function getGroupe(){
    return $this->groupe;
  }

  public function getAn(){
    return $this->an;
  }

  public function getNumGroupe(){
    return $this->numgroupe;
  }

  public function getId() {
    return $this->id;
  }

  public function estAdmin() {
    return $this->niveau==0;
  }

  public function estLecteur() {
    return $this->niveau==2;
  }

  public function estProf() {
    return $this->niveau==1;
  }
  public function estEtudiant() {
    return $this->niveau==3;
  }
  public function getGroupes() {
  	return $this->groupes;
  }

}

?>
