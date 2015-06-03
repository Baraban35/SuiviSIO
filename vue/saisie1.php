<div id="corps">

<?php
  include_once 'calend.php';
  include_once 'situencours.php';
?>
<div id="navcontainer">
<ul id="navlist">

<?php
$vers=1; //page actuelle
include_once './vue/menus/menusaisie.php';//gere vers et depuis
?>

</ul>
</div>

<script type="text/javascript">
 <?php
   include "./vue/js/reste.js";
   include "./vue/js/verif.js";
 ?>
 function vuetypo(num){
	 var obj=document.getElementById("choixtypo");
     if (num==0)
         obj.style.visibility="visible";
     else
         obj.style.visibility="hidden";

 }
</script>

<form name="frmSitu" id="frmSitu" method="post" action="index.php" onsubmit="return verif();">

    <?php
      echo '<input type="hidden" name="action" value="saisie" />';
      echo '<input type="hidden" name="modif" value="n" />';
      echo '<input type="hidden" name="depuis" value="'.$vers.'" />';

      echo '<input type="hidden" name="vers" value="'.$vers.'" />';
      echo '<input type="hidden" name="numsitu" value="'.$numsitu.'" />';
      echo '<input type="hidden" name="commenter" value="'.$commenter.'" />';

      if ($numsitu!=0){
          $lc=$lasitu[0]["libcourt"];
          $de=$lasitu[0]["descriptif"];
          $pa=$lasitu[0]["contexte"];
          $lo=$lasitu[0]["codeLocalisation"];
          $so=$lasitu[0]["codeSource"];
          $ca=$lasitu[0]["codeCadre"];
          $to=$lasitu[0]["codeTypologie"];//tableau
          $dd=$lasitu[0]["datedebut"];
          $df=$lasitu[0]["datefin"];
          $ty=$lasitu[0]["codeType"];
          $te=$lasitu[0]["environnement"];
          $ac=$lasitu[0]["moyen"];
          $av=$lasitu[0]["avisperso"];
      } else {
          $lc="";
          $de="";
          $pa="";
          $lo=0;
          $so=0;
          $ca=0;
          $to=array();
          $dd=date("d-m-Y");
          $df=date("d-m-Y");
          $ty=0;
          $te="";
          $ac="";
          $av="";
      }

      $lgc=80; //largeur des controles de la page



        echo  '<div class="libellebas">Libell&eacute; court <span class="oblig">*</span> : </div>';


            echo '<div class="champtexte"><input type="text" class="champOblig" name="libcourt" ';
            if($commenter=="P") echo ' disabled="disabled"';
            echo ' size="64" maxlength="64" value="'.$lc.'" onchange="change=true;" /></div>';


         echo  '<div class="libelle">Description <span class="oblig">*</span> : </div>';



          echo '<div class="listeder"><textarea rows="4"  cols="'.$lgc.'" class="champOblig" name="description" ';
          if($commenter=="P") echo ' disabled="disabled"';
          echo ' onchange="change=true;" >'.$de.'</textarea></div>';


         echo '<div class="libellebas">Contexte : </div>';


          echo '<div class="champtexte"><textarea rows="2"  cols="'.$lgc.'" name="lieu"';
          if($commenter=="P") echo ' disabled="disabled"';
          echo ' onchange="change=true;" >'.$pa.'</textarea></div>';

        	echo '<div class="dtes">';
        	echo '<span class="libdersb">Localisation : </span><select name="localisation"';
        	if($commenter=="P") echo ' disabled="disabled">'; else echo ' onchange="change=true;">';
            $localisation=$data["localisation"];
            foreach ($localisation as $item) {
	              echo '<option value="'.$item["code"].'"';
	              if ($item["code"]==$lo) echo ' selected';
	              echo '>'.$item["libelle"].'</option>';
            }
        	echo '</select>';

        	echo '<span class="libder">Source : </span><select name="source"';
        	if($commenter=="P") echo ' disabled="disabled">'; else echo ' onchange="change=true;">';
            $source=$data["source"];
            foreach ($source as $item) {
                  echo '<option value="'.$item["code"].'"';
                  if ($item["code"]==$so) echo ' selected';
                  echo '>'.$item["libelle"].'</option>';
            }
            echo '</select>';

        	echo '<span class="libder">Cadre : </span><select name="cadre"';
        	if($commenter=="P") echo ' disabled="disabled">'; else echo ' onchange="change=true;">';
            $source=$data["cadre"];
            foreach ($source as $item) {
                  echo '<option value="'.$item["code"].'"';
                  if ($item["code"]==$ca) echo ' selected';
                  echo '>'.$item["libelle"].'</option>';
            }
            echo '</select>';

            echo '<span class="libder">Type : </span><select name="typedecrit"';
        	if($commenter=="P") echo ' disabled="disabled">'; else echo ' onchange="change=true;">';
            $type=$data["type"];
            foreach ($type as $item) {
                  echo '<option value="'.$item["code"].'"';
                  if ($item["code"]==$ty) echo ' selected';
                  echo '>'.$item["libelle"].'</option>';
            }
            echo '</select>';
			echo '</div>';

            echo '<div class="dtes">Date d&eacute;but : <input type="text" readonly="readonly" name="datedebut" size="15" value="'.$dd.'" />&nbsp;';
            if($commenter!="P")
            	echo '<a href="javascript:change=true;cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Choisir la date"></a>';

            echo ' Date fin : <input type="text" readonly="readonly" name="datefin" size="15" maxlength="10" value="'.$df.'" />&nbsp;';
            if($commenter!="P")
            	echo '<a href="javascript:change=true;cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Choisir la date"></a>';
			echo '</div>';



          echo '<div class="libellebas">Environnement technologique : </div>';



          echo '<div class="champtexteb"><textarea rows="2"  cols="'.$lgc.'" name="techno"';
          if($commenter=="P") echo ' disabled="disabled"';
          echo ' onchange="change=true;" >'.$te.'</textarea></div>';


          echo '<div class="libellebas">Moyens : </div>';


          echo '<div class="champtexteb"><textarea rows="2"  cols="'.$lgc.'" name="acteur"';
          if($commenter=="P") echo ' disabled="disabled"';
          echo ' onchange="change=true;" >'.$ac.'</textarea></div>';


          echo '<div class="libellebas">Avis personnel : </div>';


          echo '<div class="champtexteb"><textarea rows="2"  cols="'.$lgc.'" name="avisperso"';
          if($commenter=="P") echo ' disabled="disabled"';
          echo ' onchange="change=true;" >'.$av.'</textarea></div>';


		echo '<div class="dtes">';
		  echo '<p>Est-ce une situation obligatoire ? oui : <input type="radio"
		       name="situoblig" onclick="vuetypo(0);" value="O"';
		  if (count($to)>0) echo ' checked="checked"';
		  if($commenter=="P") echo ' disabled="disabled"'; else echo ' onchange="change=true;"';
		  echo ' />';
		  echo ' non : <input type="radio" name="situoblig" onclick="vuetypo(1);" value="N"';
		  if (count($to)==0) echo ' checked="checked"';
		  if($commenter=="P") echo ' disabled="disabled"'; else echo ' onchange="change=true;"';
		  echo ' /></p>';
		  echo '<div id="choixtypo" style="visibility: ';
		  if (count($to)==0) echo 'hidden;">'; else echo 'visible;">';
		    $typologie=$data["typologie"];
		    $i=0;
		    $imax=count($to);
        	foreach($typologie as $item){
		      echo '<input type="checkbox" name="typologie[]" value="'.$item["code"].'"';
		      if ($i<$imax) {
		      	if ($item["code"]==$to[$i]["codeTypologie"]) {
		      	  echo ' checked="checked"';
		      	  $i++;
		      	}
		      }
		      if($commenter=="P") echo ' disabled="disabled"'; else echo ' onchange="change=true;"';
		      echo ' />'.$item["libelle"].'<br />';
        	}
		  echo '</div>';
		echo '</div>';


		include_once 'btnenregistrer.php';
        ?>

  </form>
<script type="text/javascript">
	var cal1 = new calendar1(document.forms['frmSitu'].elements['datedebut']);
	cal1.year_scroll = true;
	cal1.time_comp = false;
	var cal2 = new calendar1(document.forms['frmSitu'].elements['datefin']);
	cal2.year_scroll = true;
	cal2.time_comp = false;
</script>

</div>
