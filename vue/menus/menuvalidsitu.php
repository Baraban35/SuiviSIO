<?php

$tb=array('Derni&egrave;res non comment&eacute;es','Derni&egrave;res','Non comment&eacute;es','Toutes');

for($i=1;$i<=count($tb);$i++){
  if ($vers==$i)
    echo '<li id="active"><a href="#" id="current">';
  else
    echo '<li><a href="index.php?action=valid&vers='.$i.'&depuis='.$vers.'">';

  echo $tb[$i-1].'</a></li> ';
}

?>
