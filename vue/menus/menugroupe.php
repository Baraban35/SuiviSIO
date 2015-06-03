<?php
$tb=array('Promotion','Professeur','&Eacute;tudiant','Recherche','Fichier');
for($i=1;$i<=count($tb);$i++){
  if ($num==$i)
    echo '<li id="active"><a href="#" id="current">';
  else
    echo '<li><a href="index.php?action=groupe&num='.$i.'">';
  echo $tb[$i-1].'</a></li> ';
}
?>
