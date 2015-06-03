<div class="menuh">
<h4><a href="index.php?action=eaccueil&q=a">Espace administrateur</a></h4>
</div>

<div class="menu">
<h4><a href="javascript:aide('a',1)">Comptes</a></h4>
<ul>
<?php
    echo '<li><a href="index.php?action=groupe">Gestion des comptes</a></li>';
    echo '<li><a href="index.php?action=suivigr">Suivi promotions</a></li>';
    echo '<li><a href="index.php?action=suppr">Gestion suppressions</a></li>';
    echo '<li><a href="index.php?action=finetude">Fin d\'&eacute;tudes</a></li>';
    //echo '<li><a href="javascript:aide(\'a\',1)">Aide</a></li>';
?>

</ul>
</div>

<div class="menu">
<h4><a href="javascript:aide('a',2)">Codes d'acc&egrave;s</a></h4>
<ul>
<?php
    $crypte = new Crypte();
    if ($crypte->getCrypte())
      echo '<li>Mots de passe crypt&eacute;s !</li>';
    else
      echo '<li><a href="index.php?action=mpasse">Export mots de passe</a></li>';

?>
</ul>
</div>

<div class="menu">
<h4><a href="javascript:aide('a',3)">Restauration</a></h4>
<ul>
<?php
    //echo '<li><a href="index.php?action=recup&t=1">Interne</a></li>';
    echo '<li><a href="index.php?action=recup&t=2">&Eacute;tudiant</a></li>';
    //echo '<li><a href="index.php?action=recup&t=3">Externe enseignant</a></li>';
    //echo '<li><a href="javascript:aide(\'a\',3)">Aide</a></li>';
?>
</ul>
</div>

<div class="menu">
<h4><a href="javascript:aide('a',4)">Sauvegarde</a></h4>
<ul>
<?php
    //echo '<li><a href="index.php?action=sauvea">Envoi évaluations</a></li>';
    echo '<li><a href="index.php?action=sauvebase">Sauvegarde base</a></li>';
    //echo '<li><a href="javascript:aide(\'a\',4)">Aide</a></li>';
?>
</ul>
</div>
