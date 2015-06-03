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

<form name="frmEleve" method="post" action="index.php" onsubmit="return verif(this);">
    <?php
      echo '<input type="hidden" name="action" value="groupe" />';
      echo '<input type="hidden" name="num" value="'.$num.'" />';
    ?>
    <table width="80%" border="0" cellspacing="3" align="center">

			<tr>
        <td colspan="2">
          <h3>Cr&eacute;ation / modification d'un &eacute;tudiant</h3>
          <p>Pour affecter un &eacute;tudiant &agrave; une promotion, vous devez l'avoir pr&eacute;alablement
            cr&eacute;&eacute;e.<br />(pour supprimer un &eacute;tudiant il faut d'abord le
          sélectionner en passant par l'onglet "Recherche") </p>
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
          if (isset($data["etudiant"])) $etud=$data["etudiant"]; else $etud=null;

          echo '<input type="text" name="nom" size="20" maxlength="32" value="'.$etud[0]["nom"].'" />';
          if (!is_null($etud)){
            echo '<input type="hidden" name="numetud" value="'.$etud[0]["num"].'" />';
            $gr=$etud[0]["numGroupe"];
          } else $gr=0;
        ?>
        </td>
        <td width="46%">Pr&eacute;nom <span class="oblig">*</span> :
          <?php
          echo '<input type="text" name="prenom" size="20" maxlength="32" value="'.$etud[0]["prenom"].'" />';
        ?>
        </td>
      </tr>
            <tr>
        <td width="54%">Adresse m&eacute;l <span class="oblig">*</span> :
          <?php
          echo '<input type="text" name="mel" size="32" maxlength="64" value="'.$etud[0]["mel"].'" />';
        ?>
        </td>
        <td width="46%">Promotion :
          <select name="groupe">


              <?php
                 echo '<option value="0"';
                 if ($gr==0) echo ' selected';
                 echo '>-- aucun --</option>';
                 $type=$data["groupes"];
                 foreach ($type as $item) {
                   echo '<option value="'.$item["num"].'"';
                   if ($gr==$item["num"]) echo ' selected';
                   echo '>'.$item["libelle"].'</option>';
                 }
              ?>


          </select>
        </td>
      </tr>

          <?php
          if (!is_null($etud)){
            echo '<tr><td colspan="2">Mot de passe : <span class="oblig">*</span> : ';
            echo '<input type="text" name="mdp" size="16" maxlength="'.$lng.'" value="xxxx" />';
            echo ' Changer le mot de passe : <input type="checkbox" name="chmdp">';
            echo '</td></tr>';
          }
        ?>

	  <tr><td colspan="2"><br /><hr /></td></tr>

      <tr>
        <td colspan="2">
          <div class="centrer"> <span class="oblig">*</span> champ obligatoire
            <input type="submit" name="envoi" value="Enregistrer">
            <?php
              if (!is_null($etud))
                echo '<input type="submit" name="envoi" value="Supprimer" />';
            ?>
          </div>
        </td>
      </tr>
    </table>

  </form>
</div>
