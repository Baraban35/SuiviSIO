var tab=new Array();

<?php
	$comp=$data["lescomp"];
	$i=0;
	$nb=count($comp);
	while($i<$nb) {
		$idact=$comp[$i]["idActivite"];
		$tb='';
		while ($i<$nb && $comp[$i]["idActivite"]==$idact)
			$tb.='"'.$comp[$i]["nomenclature"].' '.$comp[$i++]["libelle"].'",';
		echo 'tab['.$idact.']=new Array('.substr($tb,0,-1).');';
		if ($i<$nb) $idact=$comp[$i]["idActivite"];
	}
?>



<?php

echo 'var choix= new Array();';//contiendra les n° des activites choisies
//impossible de faire déclaration Array(val1, val2,...)
//(1 élem = dimension ; +1élem = valeurs)
if (isset($data["lesactiv"])) {
	$lesactiv=$data["lesactiv"];
	for ($i=0 ; $i<count($lesactiv) ; $i++)
		echo 'choix['.$i.'] = '.$lesactiv[$i]["id"].';';
}

?>

function choisir() {//ajoute une nouvelle activite dans la liste + ajout des compet corr.
	var frm = document.frmSitu;
	var frmprop = frm.activite;
	var frmchoi = frm.activchoisies;
	var nb = frmchoi.length;
	var num = frmprop.selectedIndex;
	var value = frmprop.options[num].value;
	var nouveau=true;
	var i=0;
	while (i<nb && nouveau)
		nouveau = frmchoi.options[i++].value != value;
	if (nouveau){
		frmchoi.options[nb] = new Option(frmprop.options[num].text, value, false, false);
		choix.push(value);//ajoute dans choix
		majchoix();
		frmchoi = frm.compchoisies;
		nb = frmchoi.length;
		nbcomp = tab[value].length;
		for (i=0 ; i<nbcomp ; i++)
			frmchoi.options[nb++] = new Option(tab[value][i], value, false, false);
		frmchoi.options[nb] = new Option('------------', value, false, false);
	}
}

function remplir() {//remplissage des compet au chargement de la page (activ remplies par php)
	var frm = document.frmSitu;
	var frmchoi = frm.activchoisies;
	var frmcomp = frm.compchoisies;
	var nbac = frmchoi.length;
	var nbco = frmcomp.length;
	var value;
	var j;
	var i;
	for (j=0; j<nbac ; j++){
		value = frmchoi.options[j].value ;
		nbco = frmcomp.length;
		nbcomp = tab[value].length;
		for (i=0 ; i<nbcomp ; i++)
			frmcomp.options[nbco++] = new Option(tab[value][i], value, false, false);
		frmcomp.options[nbco] = new Option('------------', value, false, false);
	}
}

function enleve() {//supprime activité(s) donc compets
	var frmchoia = document.frmSitu.activchoisies;
	var frmchoic = document.frmSitu.compchoisies;
	var value;
	var i;
	var j;
	var trouve=false;
	for (i=frmchoia.length -1 ; i>=0 ; i--)
		if (frmchoia.options[i].selected){
			trouve=true;
			value = frmchoia.options[i].value;
			frmchoia.options[i] = null;
			var trouve=false;
			for (j=0 ; j<choix.length ; j++)//décale les n° activ dans choix
				if (choix[j]==value)
					trouve=true;
				else
					if (trouve)
						choix[j-1]=choix[j];
			choix.pop();//puis supprime dernier
			majchoix();
			for (j=frmchoic.length -1 ; j>=0 ; j--)
				if (frmchoic.options[j].value == value)
					frmchoic.options[j] = null;
		}
	if (trouve) change=true;
}

function activsel() {//sélectionne ou non les comp en fonction des activ sélect ou non
	var frmchoia = document.frmSitu.activchoisies;
	var frmchoic = document.frmSitu.compchoisies;
	var value;
	var prem = true;
	var i;
	var j;
	for (i=0 ; i<frmchoia.length ; i++)
		if (frmchoia.options[i].selected){
			value = frmchoia.options[i].value;
			for (j=0 ; j<frmchoic.length ; j++)
				frmchoic.options[j].selected = (frmchoic.options[j].value == value) || (!prem && frmchoic.options[j].selected);
			prem = false;
		}
	if (prem)
		for (j=0 ; j<frmchoic.length ; j++)
			frmchoic.options[j].selected = false;
}

function majchoix(){
	ch='';
	if (choix.length == 1)//join ne marche pas pour 1 élem ?
		ch=choix[0];
	else
		ch=choix.join(',');
	document.frmSitu.lesactivschoisies.value=ch;
}