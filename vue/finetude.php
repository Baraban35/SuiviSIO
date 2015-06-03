<?php  include_once 'exit.php'; ?>
<div id="corps">


  <h2>Suppression d&eacute;finitive d'&eacute;tudiants</h2>
  <p>Cette page permet de choisir une promotion pour supprimer d&eacute;finitivement tous
   les &eacute;tudiants qui ont &eacute;t&eacute; coch&eacute;s, ainsi que leurs saisies,
    leurs validations et leurs &eacute;valuations.</p>

<?php

  if (isset($data["groupes"])) { //liste des promotions
    $groupes=$data["groupes"];

    echo '<table cellspacing="0">';

    echo '<tr><th>Libell&eacute; promotion &agrave; supprimer</th></tr>';
    $li=1;//pyjama
    foreach($groupes as $groupe){
      echo '<tr><td align="center" class="td'.$li.'"><a href="index.php?action=finetude&nom='.
      $groupe["libelle"].'&num='.$groupe["num"].'">'.$groupe["libelle"].'</a></td></tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';


  } else { //données d'un promotion
     $nom=$data["nom"];
     $eleves= $data["eleves"];


     echo '<form method="post" action="index.php">';
     echo '<input type="hidden" name="action" value="finetude" />';
     echo '<table cellspacing="0">';
     echo '<tr><th colspan="2">'.$nom.'</th></tr>';
     echo '<tr><th class="td2">&Eacute;tudiant</td><th class="td2" align="left">Suppression</td></tr>';

     $nbe=count($eleves);

     $li=1;//pyjama
     for ($i=0; $i<$nbe;++$i){

       echo '<tr><td class="td'.$li.'" align="center" >';
       echo $eleves[$i]["nom"].' '.$eleves[$i]["prenom"];
       echo '</td><td class="td'.$li.'" align="left" >';
       echo '<input type="checkbox" name="etud[]" value="'.$eleves[$i]["num"].'" />';
       echo '</td></tr>';
       if ($li==1) $li=2; else $li=1;
     }
     echo '<tr><td colspan="2" align="center"><input type="submit" name="envoi" value="Supprimer" /></td></tr>';
     echo '</table>';
     echo '</form>';


  }



?>

</div>
