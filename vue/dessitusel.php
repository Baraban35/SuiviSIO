<?php  include_once 'exit.php'; ?>
<div id="corps">

    <?php
      $vers=1;


      $liste=$data["lessitusel"];

    ?>

    <h2>Situations</h2>

<div class="titre">Cette page permet d'&eacute;diter une situation en cliquant sur son
          descriptif, de la supprimer, de la r&eacute;cup&eacute;rer si la suppression
          n'est pas souhait&eacute;e ou de la d&eacute;truire d&eacute;finitivement.
          Entre parenth&egrave;ses vous sont indiqu&eacute;s les nombres de commentaires, d'activit&eacute;s
           cit&eacute;es et de productions pour chaque situation.</div>

  <table cellspacing="0" border="0">
  <?php
    $li=1;
    $ln=30;
    $ids=0;
    foreach ($liste as $ligne) {

      $valide=$ligne["valide"];
      //$commenter=$ligne["validation"];
      //$commenter=0;
      $commentaire=$ligne["commentaire"];
      $activ=$ligne["activ"];
	  $prod=$ligne["prod"];

      $ref=$ligne["ref"];
      echo '<tr>';

      $lib=$ligne["libT"];
      if (strlen($lib)>$ln) $lib=substr($lib,0,$ln).'...';
      if (strlen($lib)==0) $lib='* non saisi *';

      //echo '<td class="td'.$li.'"><a href="index.php?action=saisie&vers=1&numsitu='.$ref.'&v='.$commenter.'">'.$lib.'</a></td>';
      echo '<td class="td'.$li.'"><a href="index.php?action=saisie&vers=1&numsitu='.$ref.'">'.$lib.'</a></td>';

      if ($valide=='O'){
          echo '<td class="td'.$li.'"><a href="index.php?action=gestion&mode=1&t=s&numsitu='.$ref.'">supprimer</a></td>';
          echo '<td class="td'.$li.'">&nbsp;</td>';
      } else{
          echo '<td class="td'.$li.'"><a href="index.php?action=gestion&mode=2&t=s&numsitu='.$ref.'">r&eacute;cup&eacute;rer</a></td>';
          echo '<td class="td'.$li.'"><a href="index.php?action=gestion&mode=3&t=s&numsitu='.$ref.'">d&eacute;truire</a></td>';
      }

      if ($commentaire>0)
        echo '<td class="td'.$li.'">Comment&eacute;e ('.$commentaire.')</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      if ($activ>0)
        echo '<td class="td'.$li.'">Activit&eacute; ('.$activ.')</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      if ($prod>0)
        echo '<td class="td'.$li.'">Production ('.$prod.')</td>';
      else
        echo '<td class="td'.$li.'">&nbsp;</td>';

      if ($li==1) $li=2; else $li=1;
      echo '</tr>';
    }
  ?>
</table>
</div>
