<?php

class Control {
    protected $view;
    protected $util;

    protected function __construct ($util) {
      $this->util=$util;
      include_once './class/view.class.php';
      $this->view = new View;
    }

    public function  getView() {
        return $this->view;
    }

    static protected function ha($s) {
      //return htmlentities(addSlashes($s));
      return htmlspecialchars(addSlashes($s));

    }

    static protected function ctrlmel($mel){
       return preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\.\-]+$/',$mel);
    }



    protected function setViewMenu(){
        if (!is_null($this->util->getNom())) {
          $resn=array("utilisateur"=>array(array("id"=>$this->util->getId(),
                           "nom"=>$this->util->getNom(),
                           "prenom"=>$this->util->getPrenom(),
                           "groupe"=>$this->util->getGroupe(),
                           "an"=>$this->util->getAn())));
          $this->view->init('/menus/haut.php',$resn);
        } else {
          $this->view->init('/menus/haut.php',null);
          $this->view->init('authent.php');
        }

        if($this->util->estEtudiant())
          $this->view->init('/menus/menug.php',array("droit"=>$this->util->estEtudiant(),
                                              "lien"=>$this->util->getMelContact()));
        if($this->util->estProf() || $this->util->estLecteur())
          $this->view->init('/menus/menup.php',array("droit"=>$this->util->estProf(),
                                    "groupes"=>$this->util->getGroupes(),
          							"legroupe"=>$this->util->getNumGroupe()));
        if($this->util->estAdmin())
          $this->view->init('/menus/menua.php',array("droit"=>$this->util->estAdmin()));

        $this->view->init('/menus/fin.php');

    }
    protected function setViewBas(){
        $this->view->init('/menus/bas.php');
    }

    static protected function model(){
      include_once './class/model.class.php';
    }

}


?>
