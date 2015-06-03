<?php  include_once 'exit.php'; ?>
<div id="corps">


  <h2>Bilans, rapports</h2>
  <p>Cette page permet de consulter les bilans et rapports des
    &eacute;tudiants de votre promotion.</p>

<?php

  $eleves=$data["liste"];

    echo '<table cellspacing="0">';

    echo '<tr><th>Nom</th><th>Pr&eacute;nom</th><th colspan="4">Tableau</th></tr>';
    $li=1;//pyjama
    foreach($eleves as $eleve){
      echo '<tr><td class="td'.$li.'">'.$eleve["nom"].'</td>';
      echo '<td class="td'.$li.'">'.$eleve["prenom"].'</td>';
      $lien='index.php?action=passprof&num='.$eleve["num"].'&ep=';
      //if ($data["droit"]) {//prof
        //echo '<td class="td'.$li.'"><a href="'.$lien.'0" target="_blank">int&eacute;gral</a></td>';
        //echo '<td class="td'.$li.'"><a href="'.$lien.'1" target="_blank">E4</a></td>';
        //echo '<td class="td'.$li.'"><a href="'.$lien.'3" target="_blank">E6</a></td>';
        //echo '<td class="td'.$li.'"><a href="'.$lien.'3p" target="_blank">projet</a></td>';
      //} else {
        echo '<td colspan="4" class="td'.$li.'"><a href="'.$lien.'0" target="_blank">synth&egrave;se</a></td>';
      //}
      echo '</tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';




?>

</div>
