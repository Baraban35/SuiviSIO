<?php
$tb=array('Professeurs','&Eacute;tudiants');
for($i=1;$i<=count($tb);$i++){
  if ($vers==$i)
    echo '<li id="active"><a href="#" id="current">';
  else
    echo '<li><a href="index.php?action=suppr&vers='.$i.'&depuis='.$vers.'">';
  echo $tb[$i-1].'</a></li> ';
}
?>
