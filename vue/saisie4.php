<div id="corps">
<?php
  include_once 'situencours.php';
?>
<div id="navcontainer">
<ul id="navlist">

<?php
$vers=4;
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
      echo '<input type="hidden" name="modif" value="n" />';
      echo '<input type="hidden" name="depuis" value="'.$vers.'" />';

      echo '<input type="hidden" name="vers" value="'.$vers.'" />';
      echo '<input type="hidden" name="numsitu" value="'.$numsitu.'" />';
      echo '<input type="hidden" name="commenter" value="'.$commenter.'" />';



      if ($numsitu!=0){
          $lesprod=$data["lesprod"];
          $nb=count($lesprod);//nombre de productions
      } else $nb=0;

      $lgc=100; //largeur des controles de la page
    ?>
<div class="titre">
Vous saisissez un libell&eacute; explicite pour chaque production r&eacute;alis&eacute;e
dans cette situation et vous indiquez l'URI permettant d'y acc&eacute;der.
</div>

    <?php
     for ($i=0;$i<=$nb;$i++) {//une de plus : la dernière est vide
	      if ($i<$nb || $commenter!="P"){
	       if($i==$nb){
	         echo '<input type="hidden" name="codeP[]" value="" />';
	       }else{
	          $ligne=$lesprod[$i];
	          echo '<input type="hidden" name="codeP[]" value="'.$ligne["numero"].'" />';
	       }

	       echo '<div class="libellebas">D&eacute;signation : </div>';

	       echo '<div class="champtexte"><input type="text" name="designation[]" size="'.$lgc.'" maxlength="255" onchange="change=true;" ';
	       if ($i<$nb) echo ' value="'.$ligne["designation"].'"';
	       if($commenter=="P") echo ' disabled="disabled"';
	       echo ' /></div>';

	       echo '<div class="libellebas">Adresse (URI) : </div>';

	       echo '<div class="champtexte">';
	       if($commenter=="P"){
	          	if (strlen($ligne["adresse"])==0)
	          		echo "* non saisi *";
	          	else
	       			echo '<a href="'.$ligne["adresse"].'" target="_blank">'.$ligne["adresse"].'</a>';
	       } else {
	        	echo '<input type="text" name="adresse[]" size="'.$lgc.'" maxlength="255" onchange="change=true;" ';
	       		if ($i<$nb) echo ' value="'.$ligne["adresse"];
	       		echo '" />';
	       }
	       echo '</div>';

	       if ($i<$nb)
	              if($commenter!="P"){
	                	echo '<div class="btnsuppr">Supprimer : ';
	                	echo '<input type="checkbox" name="chksup[]" value="'.$ligne["numero"].'" onchange="change=true;"></div>';
	              }

	        echo '<hr />';
	     }
    }

	include_once 'btnenregistrer.php';

    ?>

  </form>

</div>
