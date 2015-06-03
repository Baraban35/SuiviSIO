<?php
include_once 'control.class.php';


class Mpasse extends Control {
    
    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();
        $data["auth"]=$this->util->estAuthent();
        
        if (isset($get["num"])) {
          
          $this->model();
          $nt=$get["num"];
          
          $model = new Model();
          $liste=$model->getMDPGroupe($nt);
          
          
          $repfic = 'dirrw/csv/';
          $nf='mp'.substr('000'.$nt,-3,3);
          $nomfic=$repfic.$nf.".csv";
          $fic =fopen($nomfic,"w");
          
          $li="Date sauvegarde;".date("Y-m-d")."\r\n";
          fputs($fic,$li);
          $li="numero;nom;prenom;mel;motPasse\r\n";
          fputs($fic,$li);
          
          foreach($liste as $ligne){
            $li='';
            foreach ($ligne as $cle=>$val){
              if ($li=='') $li=$val;
              else $li=$li.';'.$val;
            }
            $li.="\r\n";
            fputs($fic,$li);
          }
  
          fclose($fic);
  
          $data["fic"]=$nf.".csv";
        } else
          $data["groupes"]=$model->getGroupes();

        $this->setViewMenu();
        $this->view->init('mpasse.php',$data);
        $model->close();
        $this->setViewBas();
        
                
    }
}


?>
