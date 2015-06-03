<?php

$processus=$data["processus"];
$nomprocessus=$data["nomprocessus"];

$q=$data["q"];

if (isset($data["numetud"])) $numetud=$data["numetud"]; else $numetud=0;
if (isset($data["etud"])) $etud=$data["etud"];

$tb=array($nomprocessus,'&Eacute;tudiants');
if ($numetud!=0) {
  if ($q=="a")
    $tb[]=$etud["nom"].' '.$etud["prenom"]. " +A";//acquis
  else
    if ($q=="n")
      $tb[]=$etud["nom"].' '.$etud["prenom"]. " +NA";//non acquis
    else
      $tb[]=$etud["nom"].' '.$etud["prenom"];
  if (isset($data["num"])) {
    $num=$data["num"];
    $tb[]=$data["unecomp"]["nomenclature"];
  }
}

for($i=1;$i<=count($tb);$i++){
  if ($vers==$i)
    echo '<li id="active"><a href="#" id="current">';
  else {
    echo '<li><a href="index.php?action=vise&vers='.$i.'&depuis='.$vers.
        '&processus='.$processus.'&q='.$q;
    if ($i>=2) echo '&numetud='.$numetud;
    echo  '">';
  }
    echo $tb[$i-1].'</a></li> ';
}

?>
