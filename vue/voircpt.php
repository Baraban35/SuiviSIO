<?php  include_once 'exit.php'; ?>
<div id="corps">


  <h2>Suivi rapports - bilans</h2>
  <p>Cette page permet &agrave; l'&eacute;tudiant de g&eacute;rer ses documents de suivi de stage</p>

<?php

  if (isset($data["liste"])) { //liste des promotions
    $liste=$data["liste"];
    $bilan=$liste["b"];
    $rapport=$liste["r"];

    echo '<h3>Bilans</h3>';
  if (count($bilan)>0){
    echo '<table cellspacing="0">';
    $li=1;//pyjama
    foreach($bilan as $ligne){
      echo '<tr><td class="td'.$li.'">'.$ligne["dte"].'</td>';
      if ($ligne["rep"])
        echo '<td class="td'.$li.'">R&eacute;ponse</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      echo '<td class="td'.$li.'"><a href="index.php?action=stage&t=b&e='.$ligne["etat"].'&iddoc='.
                    $ligne["num"].'">'.$ligne["titre"].'</a></td>';
      if ($ligne["etat"]=="t")//normal
         echo '<td class="td'.$li.'"><a href="index.php?action=rapbil&t=b&a=s&iddoc='.
                    $ligne["num"].'">Supprimer</a></td>
                    <td class="td'.$li.'">&nbsp;</td>';
      else//pre-supprime
         echo '<td class="td'.$li.'"><a href="index.php?action=rapbil&t=b&a=r&iddoc='.
                    $ligne["num"].'">Restaurer</a></td>
                    <td class="td'.$li.'"><a href="index.php?action=rapbil&t=b&a=d&iddoc='.
                    $ligne["num"].'">D&eacute;truire</a></td>';
      echo '</tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';
  }
    echo '<h3>Rapports</h3>';
  if (count($rapport)>0){
    echo '<table cellspacing="0">';
    $li=1;
    foreach($rapport as $ligne){
      echo '<tr><td class="td'.$li.'">'.$ligne["dte"].'</td>';
      if ($ligne["rep"])
        echo '<td class="td'.$li.'">R&eacute;ponse</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      echo '<td class="td'.$li.'"><a href="index.php?action=stage&t=r&e='.$ligne["etat"].'&iddoc='.
                    $ligne["num"].'">'.$ligne["titre"].'</a></td>';
      if ($ligne["etat"]=="t")//normal
         echo '<td class="td'.$li.'"><a href="index.php?action=rapbil&t=r&a=s&iddoc='.
                    $ligne["num"].'">Supprimer</a></td>
                    <td class="td'.$li.'">&nbsp;</td>';
      else//pre-supprime
         echo '<td class="td'.$li.'"><a href="index.php?action=rapbil&t=r&a=r&iddoc='.
                    $ligne["num"].'">Restaurer</a></td>
                    <td class="td'.$li.'"><a href="index.php?action=rapbil&t=r&a=d&iddoc='.
                    $ligne["num"].'">D&eacute;truire</a></td>';
      echo '</tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';

   }

  }



?>

</div>
