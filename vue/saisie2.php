<div id="corps">
<?php
  include_once 'situencours.php';
?>
<div id="navcontainer">
<ul id="navlist">

<?php
	$vers=2;
	include_once './vue/menus/menusaisie.php';
?>

</ul>
</div>

<script type="text/javascript">
  <?php
  	include "./vue/js/reste.js";
    include "./vue/js/verif.js";
    include "./vue/js/loadcomp.js"; //gestion des événements des textarea
  ?>
</script>

<form name="frmSitu" method="post" action="index.php" onsubmit="majchoix();return verif();">

    <?php
      echo '<input type="hidden" name="action" value="saisie" />';
      echo '<input type="hidden" name="depuis" value="'.$vers.'" />';
	  echo '<input type="hidden" name="modif" value="n" />';

      echo '<input type="hidden" name="vers" value="'.$vers.'" />';
      echo '<input type="hidden" name="numsitu" value="'.$numsitu.'" />';
      echo '<input type="hidden" name="commenter" value="'.$commenter.'" />';

      // l'objet javascript "choix" de la classe Array (instancié dans loadcomp.js)
      //     contient les activités choisies qui sont sérialisées dans "lesactivschoisies"
      echo '<input type="hidden" name="lesactivschoisies" />';
      $lgc=100; //largeur des controles de la page
    ?>

	<div class="titre">
	Vous s&eacute;lectionnez une ou plusieurs activit&eacute;s du r&eacute;f&eacute;rentiel dans la liste ci-dessous
	          afin qu'elle(s) apparaisse(nt) dans la liste des &quot;Activit&eacute;s mises en &#339;uvre&quot;.
	          Les comp&eacute;tences correspondantes sont alors indiqu&eacute;es dans la liste des &quot;Comp&eacute;tences&quot;.
	</div>
	<div class="libelle">Activit&eacute;s du r&eacute;f&eacute;rentiel</div>
	<div class="listeder">
	              <?php
	               $type=$data["typeactiv"];
	               $ac=0;
	                 echo '<select name="activite" size="10" onclick="choisir();"';
					 if($commenter=="P") echo ' disabled="disabled">';
					 else echo 'onchange="change=true;">';
	                 for ($i=0;$i<count($type);$i++){
	                   $item=$type[$i];
	                   $nomen=$item["nomen"];
	                   if ($i==0){
	                     echo '<optgroup>';
	                     $debnomen=substr($nomen, 0, 2);
	                   } else {
	                     $debnomenencours=substr($nomen, 0, 2);
	                     if ($debnomenencours!=$debnomen){
	                       $debnomen=$debnomenencours;
	                       echo '</optgroup>';
	                       echo '<optgroup label="--------------" >';
	                     }
	                   }
	                   echo '<option value="'.$item["id"].'"';
	                   $lmax=90;
	                   $lib=$item["lib"];
	                   if (strlen($lib)>$lmax) $lib=substr($lib,0,$lmax)."...";
	                   echo '>'.$nomen." ".$lib.'</option>';
	                 }
	                 echo '</optgroup></select>';
	              ?>
	</div>

	<div class="titre">
			En s&eacute;lectionnant une ou plusieurs des activit&eacute;s ci-dessous, vous mettez en &eacute;vidence les comp&eacute;tences correspondantes.
			Le bouton &quot;Supprimer&quot; permet &eacute;ventuellement de retirer la(les) activit&eacute;(s) de cette liste.
	</div>
	<div class="libelle">Activit&eacute;s mises en &#339;uvre
	<?php
	if ($commenter=="N")
		    	echo '<input type="button" value="Supprimer" onclick="enleve();"/>';
	?>
	</div>
	<div class="listeder">
	<?php
		   echo '<select multiple="multiple" name="activchoisies" style="width:630px" size="6"';
		   if($commenter=="P") echo ' disabled="disabled">';
		   else echo ' onchange="activsel();">';
		   if (isset($data["lesactiv"])) {
					$lesactiv=$data["lesactiv"];
					foreach ($lesactiv as $item){
					   echo '<option value="'.$item["id"].'"';
	                   $lmax=90;
	                   $lib=$item["lib"];
	                   if (strlen($lib)>$lmax) $lib=substr($lib,0,$lmax)."...";
	                   echo '>'.$item["nomen"]." ".$lib.'</option>';
					}
			}
	      echo '</select>';
		?>
	</div>

	<div class="titre">
			Les comp&eacute;tences apparaissant dans la liste ci-dessous correspondent aux activit&eacute;s mises en &#339;uvre dans la situation.
			Le contenu de cette liste est g&eacute;r&eacute; automatiquement (ajout, suppression, s&eacute;lection).
	</div>
	<div class="libelle">Comp&eacute;tences</div>
	<div class="listeder">
		    <select  name="compchoisies" style="width:630px" size="12" multiple="multiple" disabled="disabled">
	        </select>
	</div>

	<?php
	   include_once 'btnenregistrer.php';
	?>

	<script type="text/javascript">
				remplir();
	</script>
  </form>
</div>

