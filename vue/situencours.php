<?php
  include_once 'exit.php';
  $numsitu=$data["numsitu"];
  $etud=$data["etudiant"];
  if (isset($data["commenter"]))
  	$commenter=$data["commenter"];
  else
  	$commenter="E";
  //if (isset($data["compcitee"])) $compcitee=$data["compcitee"]; else $compcitee=0;
  if ($numsitu!=0){
    $lasitu=$data["lasitu"];
    $lib=$lasitu[0]["libcourt"];
    echo '<span id="situtete">';
    if ($commenter=="P")
      echo '('.$etud.') - ';
    echo 'Situation en cours : </span><span id="situtexte">'.$lib.'</span>';
  } else
   echo '<span id="situtete">&nbsp;</span>';
?>
