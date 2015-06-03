<?php
  include_once 'exit.php';
  $numsitu=$data["numsitu"];
  $etud=$data["etudiant"];
  //$validation=$data["validation"];
  if (isset($data["compcitee"])) $compcitee=$data["compcitee"]; else $compcitee=0;
  if ($numsitu!=0){
    $lasitu=$data["lasitu"];
    $lib=$lasitu[0]["descriptif"];
    if (strlen($lib)>70) $lib=substr($lib,0,70).'...';
    echo '<span id="situtete">'.$etud[0]["prenom"].' '.$etud[0]["nom"].' - Situation en cours : </span><span id="situtexte">'.$lib.'</span>';
  } else
   echo '<span id="situtete">&nbsp;</span>';
?>
