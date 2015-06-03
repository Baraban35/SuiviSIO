<?php

$tb=array('Description','Activit&eacute;(s)','Reformulation(s)','Production(s)','Commentaire(s) prof.');

for($i=1;$i<=count($tb);$i++){
  if ($vers==$i)
    echo '<li id="active"><a href="#" id="current">';
  else
    echo '<li>
    <a href="#" onclick="reste('.$i.",".$vers.');">';
  echo $tb[$i-1].'</a></li> ';
}
?>
