<div id="corps">
<?php
  include_once 'situencours.php';
?>
<div id="navcontainer">
<ul id="navlist">

<?php
$vers=5;
include_once './vue/menus/menusaisie.php';

?>

</ul>
</div>

<script type="text/javascript">
 <?php
   include "./vue/js/reste.js";
   include "./vue/js/verif.js";
 ?>
</script>

<form name="frmSitu" method="post" action="index.php" onsubmit="return verif();">

    <?php
      echo '<input type="hidden" name="action" value="saisie" />';
      echo '<input type="hidden" name="depuis" value="'.$vers.'" />';
      echo '<input type="hidden" name="modif" value="n" />';
      echo '<input type="hidden" name="vers" value="'.$vers.'" />';

      echo '<input type="hidden" name="numsitu" value="'.$numsitu.'" />';
      echo '<input type="hidden" name="commenter" value="'.$commenter.'" />';

      if ($numsitu!=0){
          $lescomm=$data["lescomm"];
          $idprof=$data["idprof"];
          $nb=count($lescomm);//nombre de commentaires
      } else $nb=0;

      $lgc=100; //largeur des controles de la page
      $nbl=3; //nombre lignes des textarea
	  echo '<div class="titre">Les commentaires &eacute;crits par les professeurs sur cette situation sont
 	     pr&eacute;sent&eacute;s par ordre chronologique d&eacute;croissant :</div>';

      foreach ($lescomm as $ligne) {
         echo '<div class="activ">'.$ligne["datecommentaire"].'  '.$ligne["prenomprof"].' '.$ligne["nomprof"];
         if ($ligne["numprof"]==$idprof){
          	echo ' - (supprimer commentaire : ';
            echo '<input type="checkbox" name="chksup[]" value="'.$ligne["numero"].'" /> )</div>';
          	echo '<input type="hidden" name="commref[]" value="'.$ligne["numero"].'" />';
          	echo '<textarea rows="'.$nbl.'"  cols="'.$lgc.'" name="comm[]">';
          }
          else
          	echo '</div><textarea rows="'.$nbl.'"  cols="'.$lgc.'" disabled="disabled">';
          echo $ligne["commentaire"];
          echo '</textarea>';
     	}
     	if ($commenter=="P"){//pour profs
	     	echo '<div class="activ">Votre commentaire : </div>';
	          echo '<textarea rows="'.$nbl.'"  cols="'.$lgc.'" name="commnew">';
	          echo '</textarea>';

	       	echo '<div class="centrer">';
	  		echo '<span class="oblig">*</span> champ obligatoire ';
	  		echo '<input type="submit" name="enregistrer" value="Enregistrer" /></div>';
     	}
    ?>

  </form>
</div>
