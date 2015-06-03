<?php  include_once 'exit.php'; ?>
<div id="corps">

<div id="messavert">
  <?php
    if (isset($data["messagetexte"])) echo '<p>'.$data["messagetexte"].'</p>';
  ?>
</div>


    <table width="80%" border="0" cellspacing="3" align="center">
          <tr> 
        <td> 
          
          <h3>Sauvegarde</h3>
        </td>
      </tr>
      <tr> 
        <td>
        <p>Cette page permet de sauvegarder ses donn&eacute;es personnelles sur 
          une cl&eacute; USB par exemple.</p>
        <p>Apr&egrave;s avoir cliqu&eacute; sur le lien ci-dessous, vous obtenez 
          un arbre XML dans une nouvelle fen&ecirc;tre de votre navigateur. En 
          conservant <b>imp&eacute;rativement</b> le nom du fichier propos&eacute;, 
          vous d&eacute;terminez l'emplacement de sa sauvegarde : cl&eacute; USB 
          ou r&eacute;pertoire sur un disque.</p>
        <p>Il est de votre <b>responsabilit&eacute;</b> de faire toutes les sauvegardes 
          n&eacute;cessaires. Une restauration compl&egrave;te des donn&eacute;es 
          par votre professeur remettra votre dossier en l'&eacute;tat o&ugrave; 
          il &eacute;tait lors de la sauvegarde.</p>
          
          </td>
      </tr>
      <tr> 
        <td> 
          <hr />
        </td>
      </tr>

      <tr> 
        <td> 
          <div class="centrer"> 
           <?php
              $fic='dirrw/xml/'.$data["fic"];
              echo '<a href="'.$fic.'" target="_blank">cliquer ici pour r&eacute;cup&eacute;rer le fichier</a>';
           ?>

          </div>
        </td>
      </tr>
    </table>

</div>
