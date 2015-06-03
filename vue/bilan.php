<?php  include_once 'exit.php'; ?>
<div id="corps">


<?php
  $bilan=$data["bilan"];

  echo '<table cellspacing="0" border="1">';
  echo '<tr><th>Activit&eacute;</th>';
  echo '<th>Cit&eacute;e</th>';
  echo '<th>Comp&eacute;tence</th>';
  echo '</tr>';

  foreach($bilan as $ligne){
    $competence=$ligne["competence"];
    $nb=count($competence);
    echo '<tr><td rowspan="'.$nb.'">';

    echo '<div>'.$ligne["nomen"].' '.$ligne["lib"].'</div></td>';

    echo '<td rowspan="'.$nb.'">';
    $rep=$ligne["cite"];
    if (substr($rep,0,3)=="Oui") echo '<div class="ouinote">'.$rep.'</div></td>';
    else echo  '<div class="rouge">'.$rep.'</div></td>';

    echo '<td>'.$competence[0]["nomenclatureC"].' '.$competence[0]["libelleC"].'</td>';

    echo '</tr>';

    //si autres compétences :
    for($i=1;$i<$nb;$i++)
      echo '<tr><td>'.$competence[$i]["nomenclatureC"].' '.$competence[$i]["libelleC"].'</td></tr>';
  }
  echo '</table>';
?>

</div>
