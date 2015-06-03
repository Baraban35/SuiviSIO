<?php  include_once 'exit.php'; ?>
<div id="corps">
  <div id="navcontainer">
    <ul id="navlist">
      <?php
$vers=$data["vers"]; //page actuelle
include_once './vue/menus/menusuppr.php';

?>
    </ul>
  </div>
  <h3>Gestion des comptes supprim&eacute;s</h3>
  <p>Les comptes supprim&eacute;s dans l'option <i>Gestion des comptes</i> ne sont en fait qu'invalid&eacute;s
    afin d'&eacute;viter de d&eacute;truire par erreur des situations, des validations,
    des commentaires, etc.</p>
  <p>Afin de donner une id&eacute;e de l'activit&eacute; d'un compte, il apparait
    dans le tableau ci-dessous avec indication du nombre de situations saisies pour les &eacute;tudiants
    et du nombre de validations et d'appr&eacute;ciations pour les professeurs.</p>
  <p>En cliquant sur <i>restaurer</i> le compte est restaur&eacute; dans son &eacute;tat
    original ; en cliquant sur <i>supprimer</i>, le compte est d&eacute;finitivement
    d&eacute;truit ainsi que toutes les donn&eacute;es qui en d&eacute;pendent, c'est &agrave; dire
    :</p>
    <ul>
   <li><p>pour un professeur : son compte et ses appartenances &agrave;
      des promotions sont d&eacute;truits ; ses validations et appr&eacute;ciations
      sont conserv&eacute;es mais sans r&eacute;f&eacute;rence &agrave; un professeur
      ;</p></li>
  <li><p>pour un &eacute;tudiant : son compte, ses situations, ses
      productions, ses comp&eacute;tences, ses appr&eacute;ciations et ses validations
      sont d&eacute;truits.</p>
    </li></ul>
  <hr />
  <?php
  $suppr=$data["suppr"];
  if (count($suppr)==0){
    echo 'Il n\'y a aucun compte en phase de suppression &agrave; g&eacute;rer';
  } else {
    echo '<table cellspacing="0">';
    echo '<tr><th>Restaure</th><th>Supprime</th><th>Nom</th><th>Pr&eacute;nom</th>';
    if ($vers==1) echo '<th>Validations</th></tr>';
    else echo '<th>Situations</th></tr>';

    $li=1;//pyjama
    foreach($suppr as $ligne){
      echo '<tr>';
      echo '<td class="td'.$li.'"><a href="index.php?action=suppr&vers='.$vers.'&ty=0&num='.$ligne["num"].'">restaurer</a></td>';
      echo '<td class="td'.$li.'"><a href="index.php?action=suppr&vers='.$vers.'&ty=1&num='.$ligne["num"].'">supprimer</a></td>';
      echo '<td class="td'.$li.'">'.$ligne["nom"].'</td><td class="td'.$li.'">'.$ligne["prenom"].'</td><td class="td'.$li.'">'.$ligne["nb"].'</td></tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';
  }
?>
</div>
