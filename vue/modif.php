<?php  include_once 'exit.php'; ?>
<div id="corps">

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<script type="text/javascript" src="./vue/js/fctverif.js"></script>


  <h2>Param&egrave;tres personnels</h2>
  <p>Cet onglet permet de modifier les informations concernant le compte d'acc&egrave;s.</p>

<form name="frmmodif" method="post" action="index.php" onsubmit="return verif(this);">
    <?php
      echo '<input type="hidden" name="action" value="modif" />';
      $num=$data["num"];
      echo '<input type="hidden" name="num" value="'.$num.'" />';

      $pers=$data["data"];
      $lngmdp=$data["lngmdp"];

    ?>
    <table>
      <tr>
        <td colspan="2">
          <hr />
        </td>
      </tr>
      <tr>
        <td> Nom :
        <?php


          echo '<input type="text" name="nom" size="20" maxlength="32" value="'.$pers[0]["nom"].'" />';
          if (!is_null($pers))
            echo '<input type="hidden" name="numpers" value="'.$pers[0]["num"].'" />';
        ?>


        </td>
        <td> Pr&eacute;nom :
        <?php
          echo '<input type="text" name="prenom" size="20" maxlength="32" value="'.$pers[0]["prenom"].'" />';
        ?>
        </td>
      </tr>
      <tr>

        <?php
          echo '<td';
          if ($num!=3) echo 'colspan="2"';
          echo '>Adresse m&eacute;l : ';
          echo '<input type="text" name="mel" size="32" maxlength="64" value="'.$pers[0]["mel"].'" />';
          echo '</td>';
          if ($num==3){
          	echo '<td>Num&eacute;ro examen : ';
          	echo '<input type="text" name="numexam" size="20" maxlength="16" value="'.$pers[0]["numexam"].'" />';
          	echo '</td>';
          }
        ?>


      <tr>
      <td colspan="2">Mot de passe :
        <?php
          echo '<input type="text" name="mdp" size="10" maxlength="'.$lngmdp.'" value="xxxx" />';
          echo ' Changer le mot de passe : <input type="checkbox" name="chmdp">';
        ?>
      </td>
      </tr>

      <tr>
        <td colspan="2">
          <br />
          <hr />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="centrer">
            <input type="submit" name="envoi" value="Enregistrer" />

          </div>
        </td>
      </tr>
    </table>

  </form>
</div>
