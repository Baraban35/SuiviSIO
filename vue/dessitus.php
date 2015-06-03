<?php  include_once 'exit.php'; ?>
<div id="corps">

<div id="navcontainer">
<ul id="navlist">

<?php


if (isset($data["vers"])) $vers=$data["vers"]; else $vers=1;
include_once './vue/menus/menuvalidsitu.php';

?>

</ul>
</div>

<?php

    $liste=$data["lessitus"];

      echo '<h2>Commentaire des situations</h2>
  <p>Cette page vous permet de commenter les situations professionnelles et les activit&eacute;s cit&eacute;es par
   les  &eacute;tudiants de votre promotion. Un clic sur le nom de l\'&eacute;tudiant permet de consulter sa saisie
    et de la commenter &eacute;ventuellement.</p><p>Les "derni&egrave;res" sont celles qui n\'ont pas &eacute;t&eacute;
     comment&eacute;es ou qui ont &eacute;t&eacute; modifi&eacute;es apr&egrave;s la saisie de commentaires lors de votre derni&egrave;re connexion.</p>';

      echo '<input type="hidden" name="action" value="valid" />';



    echo '<table cellspacing="0"><tr class="entete">
          <td>Consulter</td><td>Libell&eacute;</td><td>Commentaire</td><td>Activit&eacute;</td></tr>';

    $li=1;//pyjama
    $ln=30;
    $numsv=0;


      foreach ($liste as $ligne) {
        if ($ligne["num"]!=$numsv) {
          $numsv=$ligne["num"];

            echo '<tr><td colspan="4"><hr /></td></tr>';

        }
        echo '<tr>';
        echo '<td class="td'.$li.'"><a href="index.php?action=saisie&vers=1&numsitu='.$ligne["ref"].'&commenter=P">';

        echo $ligne["nom"].' '.$ligne["prenom"].'</a></td>';
        echo '<td class="td'.$li.'">'.$ligne["libcourt"].'</td>';
		echo '<td class="td'.$li.'">'.$ligne["comm"].'</td>';
		echo '<td class="td'.$li.'">'.$ligne["activ"].'</td>';

        if ($li==1) $li=2; else $li=1;
        echo '</tr>';
      }
      echo '</table>';

        if (count($liste)==0)
          echo '<p class="centrer">Aucune situation nouvelle</p>';



  ?>


</div>
