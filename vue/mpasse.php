<?php  include_once 'exit.php'; ?>
<div id="corps">


  <h2>R&eacute;cup&eacute;ration des mots de passe</h2>
  <p>Cette page permet de r&eacute;cup&eacute;rer les mots de passe d'une promotion.</p>

<?php

  if (isset($data["groupes"])) { //liste des groupes
    $groupes=$data["groupes"];

    echo '<table cellspacing="0">';

    echo '<tr><th>Libell&eacute;</th></tr>';
    $li=1;//pyjama
    foreach($groupes as $groupe){
      echo '<tr><td align="center" class="td'.$li.'"><a href="index.php?action=mpasse&nom='.
      $groupe["libelle"].'&num='.$groupe["num"].'">'.$groupe["libelle"].'</a></td></tr>';
      if ($li==1) $li=2; else $li=1;
    }
    echo '</table>';


  } else { //données d'un groupe
     echo '
    <table width="80%" border="0" cellspacing="3" align="center">

      <tr>
        <td>
        <p>Apr&egrave;s avoir cliqu&eacute; sur le lien ci-dessous, vous pouvez
          enregistrer ces donn&eacute;es ou ouvrir le fichier avec votre tableur.
          La date de sauvegarde est incluse dans le fichier.</p>
          </td>
      </tr>
      <tr>
        <td>
          <hr />
        </td>
      </tr>

      <tr>
        <td>
          <div class="centrer"> ';
              $fic='dirrw/csv/'.$data["fic"];
              echo '<a href="'.$fic.'" target="_blank">cliquer ici pour r&eacute;cup&eacute;rer le fichier</a>';

      echo '</div> </td></tr></table>';
  }

?>

</div>
