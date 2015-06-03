<?php
$tb=$data["menu"];
$tbc=$data["compcitees"];


for($i=1;$i<=count($tb);$i++){
  if ($compcitee==$tbc[$i-1])
    echo '<li id="active"><a href="#" id="current">';
  else {
    if ($i>1) $versi=2; else $versi=1;
    echo '<li><a href="index.php?action=evalue&vers='.$versi.'&depuis='.$vers.
         '&numsitu='.$numsitu.'&compcitee='.$tbc[$i-1].'">';
  }
  echo $tb[$i-1].'</a></li> ';
}
?>
