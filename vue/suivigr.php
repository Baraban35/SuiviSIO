<?php  include_once 'exit.php'; ?>
<div id="corps">


  <h2>Suivi promotions</h2>
  <p>Cette page permet de consulter les membres d'une promotion.</p>

<?php

  if (isset($data["groupes"])) { //liste des promotions
    $groupes=$data["groupes"];

    echo '<table cellspacing="0">';

    echo '<tr><th>Libell&eacute;</th></tr>';
    $li=1;//pyjama
    foreach($groupes as $groupe){
      echo '<tr><td align="center" class="td'.$li.'"><a href="index.php?action=suivigr&nom='.
      $groupe["libelle"].'&num='.$groupe["num"].'">'.$groupe["libelle"].'</a></td></tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';


  } else { //données d'un promotion
     $nom=$data["nom"];
     $eleves= $data["eleves"];
     $profs=    $data["profs"];
     echo '<table cellspacing="0">';
     echo '<tr><th colspan="2">'.$nom.'</th></tr>';
     echo '<tr><th class="td2">&Eacute;tudiant</td><th class="td2">Professeur</td></tr>';

     $nbe=count($eleves);
     $nbp=count($profs);
     if ($nbe>$nbp) $nb=$nbe; else $nb=$nbp;

     $li=1;//pyjama
     for ($i=0; $i<$nb;++$i){

       echo '<tr><td class="td'.$li.'" align="center" >';
       if ($i<$nbe) echo $eleves[$i]["nom"].' '.$eleves[$i]["prenom"]; else echo '&nbsp;';
       echo '</td><td class="td'.$li.'" align="center" >';
       if ($i<$nbp) echo $profs[$i]["nom"].' '.$profs[$i]["prenom"]; else echo '&nbsp;';
       echo '</td></tr>';
       if ($li==1) $li=2; else $li=1;
     }
     echo '</table>';



  }



?>

</div>
