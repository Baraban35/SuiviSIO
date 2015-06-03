<div class="menuh">
<?php
  if ($data["droit"]) //prof
    echo '<h4><a href="index.php?action=eaccueil&q=p">Espace professeur</a></h4>';
  else
    echo '<h4><a href="index.php?action=eaccueil&q=p">Espace lecteur</a></h4>';
?>
</div>

<div class="menu">
<h4><a href="javascript:aide('p',1)">Promotion</a></h4>
<ul>
<?php
	$groupes=$data["groupes"];
	$legroupe=$data["legroupe"];
	if (count($groupes)==0)
		echo 'aucune promo';
	else {
		echo '<form name="frmChPromo" method="post" action="index.php">';
			echo '<input type="hidden" name="action" value="chpromo" />';

			echo 'Changer <select name="legroupe" onchange="document.frmChPromo.submit();">';

			foreach ($groupes as $ungroupe){
	  			echo '<option value="'.$ungroupe["num"].'"';
	  			if ($ungroupe["num"]==$legroupe) echo 'selected="selected"';
	  			echo '>'.$ungroupe["nom"].'-'.$ungroupe["annee"].'</option>';
			}
			echo '</select>';
		echo '</form>';
	}
?>
</ul>
</div>


<div class="menu">
<h4><a href="javascript:aide('p',2)">Suivi</a></h4>
<ul>
<?php
  if ($data["droit"]) //prof
    echo '<li><a href="index.php?action=valid">Commentaire situation</a></li>';

?>
</ul>
</div>


<?php

echo '<div class="menu"><h4><a href="javascript:aide('."'p'".',3)">Donn&eacute;es</a></h4><ul>';
echo '<li><a href="index.php?action=passprof">Bilans, synth&egrave;ses</a></li>';
echo '</ul></div>';

?>

<div class="menu">
<h4><a href="javascript:aide('p',4)">Divers</a></h4>
<ul>
<?php
  if ($data["droit"]) {//prof
  		echo '<li><a href="index.php?action=recup&t=2">Restauration &eacute;tudiant</a></li>';
  		//echo '<li>Restauration &eacute;tudiant</li>';
  }
  echo '<li><a href="index.php?action=modif">Param&egrave;tres</a></li>';

?>
</ul>
</div>
