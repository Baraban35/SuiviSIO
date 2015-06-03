<div id="corps">

<?php
include_once 'situencours.php';
?>

<div id="navcontainer">
<ul id="navlist">

<?php
$vers=3;
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

      $lesactiv=$data["lesactiv"];

      foreach ($lesactiv as $uneactiv){
      	echo '<input type="hidden" name="idact[]" value="'.$uneactiv["id"].'" />';
      	echo '<div class="activ">'.$uneactiv["nomenclature"].' '.$uneactiv["libelle"].'</div>';
      	foreach ($uneactiv["lescomp"] as $unecomp)
      		echo '<div class="comp">'.$unecomp["nomenclature"].' '.$unecomp["libelle"].'</div>';
  	 	echo '<div class="libelle">Votre reformulation de cette activit&eacute; : </div>';
     	if (!is_null($uneactiv["commentaire"]))
     		echo '<div class="listeder"><textarea rows="3"  cols="70" name="comm[]"';
			if($commenter=="P") echo ' disabled="disabled"';
     		echo ' onchange="change=true;">'.$uneactiv["commentaire"].'</textarea></div>';
      }
      if (count($lesactiv)>0)
        include_once 'btnenregistrer.php';

    ?>

	</form>
</div>
