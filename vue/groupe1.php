<?php  include_once 'exit.php'; ?>

<script type="text/javascript">
 <?php
   include "./vue/js/verif.js";
 ?>
</script>

<div id="corps">
	<div id="navcontainer">
		<ul id="navlist">

<?php
$num=$data["param"];
include_once './vue/menus/menugroupe.php';

?>

</ul>
</div>

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<form method="post" action="index.php" onsubmit="return verif();">
    <?php
      echo '<input type="hidden" name="action" value="groupe" />';
      echo '<input type="hidden" name="num" value="'.$num.'" />';
    ?>




	<table width="100%" border="0" cellspacing="3" align="center">
      <tr>
        <td colspan="3">
          <h3>Cr&eacute;ation / modification d'une promotion</h3>
                            <p>Une promotion correspond &agrave; un ensemble d'&eacute;tudiants suivis
            par un ensemble de professeurs. Typiquement, il s'agit d'une promotion.<br />
            Un &eacute;tudiant ne peut appartenir qu'&agrave; une seule promotion (mais peut en changer) ;
             un professeur peut intervenir dans plusieurs promotions.<br />
          Pour supprimer une promotion il faut d'abord la sélectionner en passant par l'onglet
"Recherche"</p>
        </td>
      </tr>
      <tr>

            <tr>
        <td colspan="3">
          <hr />
        </td>
      </tr>
      <tr>
        <td>
          <p>Nom de la promotion <span class="oblig">*</span> :
            <?php
          if (isset($data["groupe"])) $groupe=$data["groupe"]; else $groupe=null;
          echo '<input type="text" class="champOblig" name="nom" size="14" maxlength="12" value="'.$groupe[0]["nom"].'" />';
          if (!is_null($groupe))
            echo '<input type="hidden" name="numgroupe" value="'.$groupe[0]["num"].'" />';
        ?>
            <br />
          (12 car. max) </p>
        </td>
        <td>
          <p>Ann&eacute;e de la promotion <span class="oblig">*</span> :
            <?php
          echo '<input type="text" class="champOblig" name="an" size="5" maxlength="2" value="'.$groupe[0]["annee"].'" />';
        ?>
            <br />
            (2 chiffres, par ex. 11 pour 2011-2012)</p>
        </td>
        <td>
        	<p>Parcours :
                 <select name="parcours">


              <?php
                 $parcours=$groupe[0]["parcours"];
                 echo '<option value="0"';
				 if ($parcours==0) echo ' selected="selected"';
				 echo '>Indifférencié</option>';
                 echo '<option value="1"';
                 if ($parcours==1) echo ' selected="selected"';
                 echo '>SISR</option>';//bof.. en dur... mais c'est plus simple
                 echo '<option value="2"';
                 if ($parcours==2) echo ' selected="selected"';
                 echo '>SLAM</option>';

              ?>


          </select>
          </p>
        </td>
      </tr>

            <tr>
        <td colspan="3">
          <hr />
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <div class="centrer">  <span class="oblig">*</span> = champ obligatoire
            <input type="submit" name="envoi" value="Enregistrer" />
          </div>
        </td>
      </tr>
      <?php
              if (!is_null($groupe)){
                echo '<tr><td colspan="2">';
                echo ' La suppression de la promotion d&eacute;r&eacute;f&eacute;rence
                      tous les &eacute;l&egrave;ves et professeurs concern&eacute;s,
                       mais sans les supprimer ni alt&eacute;rer leurs donn&eacute;es ';
                echo '<input type="submit" name="envoi" value="Supprimer" />';
                echo '</td></tr>';
              }
      ?>

    </table>



  </form>
</div>
