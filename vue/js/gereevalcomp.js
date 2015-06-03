  function changer(n){
    document.frmvise4.imgchange.src='./images/c'+n+'.png';
    
    archive(n);
  }
  function archive(n){
  
  <?php

     echo "var niveau = new Array('".$niveau[0]["libelle"]."'";
     for ($i=1;$i<count($niveau);$i++)
       echo ",'".$niveau[$i]["libelle"]."'";
    
    echo ");";
  ?>
   
    document.frmvise4.evaluation.value=n;
    document.frmvise4.niveval.value=niveau[n];
  }
