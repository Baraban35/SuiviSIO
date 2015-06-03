<?php  include_once 'exit.php'; ?>
         <div id="corps">
<div id="navcontainer">
<ul id="navlist">

<?php
$num=$data["param"];
$lng=$data["lng"];
include_once './vue/menus/menugroupe.php';

?>

</ul>
</div>

<script type="text/javascript" src="./vue/js/fctverif.js"></script>

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<form name="frmProf" method="post" action="index.php" onsubmit="return verif(this);">
    <?php
      echo '<input type="hidden" name="action" value="groupe" />';
      echo '<input type="hidden" name="num" value="'.$num.'" />';
    ?>
    <table width="80%" border="0" cellspacing="3" align="center">

<tr>
        <td colspan="2">
          <h3>Cr&eacute;ation / modification d'un professeur</h3>
          <p>Pour affecter un professeur &agrave; une ou plusieurs promotions, vous devez les
            avoir pr&eacute;alablement cr&eacute;&eacute;s.<br />
             (pour supprimer un professeur il faut d'abord le s&eacute;lectionner
          en passant par l'onglet "Recherche". La suppression d&eacute;finitive se r&eacute;alise
           &agrave; partir de l'item &quot;Gestion suppressions&quot; )</p>
        </td>
      </tr>


            <tr>
        <td colspan="2">
          <hr />
        </td>
      </tr>
      <tr>
        <td width="54%">Nom <span class="oblig">*</span> :
          <?php
          if (isset($data["professeur"])) $prof=$data["professeur"]; else $prof=null;

          echo '<input type="text" name="nom" size="20" maxlength="32" value="'.$prof[0]["nom"].'" />';
          if (!is_null($prof))
            echo '<input type="hidden" name="numprof" value="'.$prof[0]["num"].'" />';
        ?>
        </td>
        <td width="46%">Pr&eacute;nom <span class="oblig">*</span> :
          <?php
          echo '<input type="text" name="prenom" size="20" maxlength="32" value="'.$prof[0]["prenom"].'" />';
        ?>
        </td>
      </tr>
      <tr>
        <td width="54%">Adresse m&eacute;l <span class="oblig">*</span> :
          <?php
          echo '<input type="text" name="mel" size="32" maxlength="64" value="'.$prof[0]["mel"].'" />';
        ?>
        </td>

        <td width="46%">Niveau :
          <select name="niveau">


              <?php
                 $niveau=$prof[0]["niveau"];

                 echo '<option value="1"';
                 if ($niveau==1) echo ' selected';
                 echo '>professeur</option>';
                 echo '<option value="2"';
                 if ($niveau==2) echo ' selected';
                 echo '>lecteur</option>';

              ?>


          </select>

        </td>
        </tr>
          <?php
          if (!is_null($prof)){
            echo '<tr><td colspan="2">Mot de passe : ';
          echo '<input type="text" name="mdp" size="16" maxlength="'.$lng.'" value="xxxx" />';
          echo ' Changer le mot de passe : <input type="checkbox" name="chmdp">';
          echo '</td></tr>';
          }
        ?>

      <tr>
        <td colspan="2">
          Promotion(s) o&ugrave; intervient le professeur :
          <table width="100%" border="0" cellspacing="0">
            <tr>
              <?php
                 $type=$data["groupes"];
                 foreach ($type as $item) {
                   echo  '<td>'.$item["libelle"];
                   echo '<input type="checkbox" name="chk[]" value="'.$item["num"].'"';
                   if (isset($item["numGroupe"])) if ($item["numGroupe"]!=null) echo ' checked="checked"';
                   echo ' /></td>';
                 }
              ?>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2"><br />
          <hr />

        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="centrer"> <span class="oblig">*</span> champ obligatoire
            <input type="submit" name="envoi" value="Enregistrer" />
            <?php
              if (!is_null($prof))
                echo '<input type="submit" name="envoi" value="Supprimer" />';
            ?>
          </div>
        </td>
      </tr>
    </table>

  </form>
</div>
