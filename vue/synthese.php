<?php  include_once 'exit.php'; ?>
<?php

  function enutf8($t){
    //selon que la base est encodée ou non en utf8, commenter une des deux lignes
    return $t;
    // return utf8_decode($t);
	// return iconv("UTF-8", "CP1252", $t);
  }
  function dtihm($d){
    return substr($d,8,2)."/".substr($d,5,2)."/".substr($d,0,4);
  }
  function dtint($d){
    return mkTime(0,0,0,substr($d,5,2),substr($d,8,2),substr($d,0,4));
  }
  function getRadio($nb,$val){
    $a=array();
    for ($i=0;$i<$nb;$i++)
      if ($i==$val) $a[]='O'; else $a[]='N';
    return $a;
  }
  function dc($c){
    return html_entity_decode(stripslashes($c));
  }


include("passfpdf.php");

header('Content-type: application/pdf');

//récup des données
$tableau=$data["tableau"];
$entete=$tableau["et"];
$ident=$tableau["ident"];
$typologie=$tableau["typologie"];
$nbp=$entete["nbp"];
$nba=$entete["nba"];
$lescorps=$tableau["sit"];
$leslibs=$tableau["libsit"];

//en mm :
$margeg=10; //marge gauche
$hvt=15; //hauteur texte
$hvp=15; //hauteur ligne processus
$hv=60;//hauteur texte écrit verticalement;
$hvs=15;//hauteur pour une situ, fixe puisque seul libcourt<=64car
$margeinterne=4;//marge entre 4 col. oblig et les 57 autres ( 1 <= $margeinterne <= 6)
if ($nbp==5){//pour 57 activités, parcours indifférencié (1er semestre)
	$lg=6; // prevoir 6 mm par colonne
	$lgoblig=6;//largeur colonnes pour themes obligatoires (tjs 4)
	$offset=7;
} else { //SISR / SLAM
	$lg=7;
	$lgoblig=7;
	$offset=6.5;
}
$mgs=32;//largeur colonne de gauche pour situs (libcourt)
//en points :
$potitre=14;
$potexte=12;
$pocroix=10;
$posousigne=10;
$polibelle=5;
//niveau de gris
$grisclairfond=200;//gris clair pour fond cellules E6
$grisclairtrait=200;
$police="Arial";



$pdf = new PassFPDF('L','mm','A3');//L/P : paysage/portrait

$pdf->SetTitle("Tableau de synthèse");
$pdf->SetAuthor('BTS SIO');


$pdf->AddPage();

$pdf->SetFont($police,'B',$potitre);
$txt="BTS SERVICES INFORMATIQUES AUX ORGANISATIONS – TABLEAU DE SYNTHÈSE";
$pdf->Cell(0,$hvt,$txt,0,1,"C");
$pdf->SetFont($police,'B',$potexte);
$txt="Nom et prénom du candidat : ".enutf8($ident[0]["nom"])." ".enutf8($ident[0]["prenom"]);
$pdf->Cell(60, $hvt,"",0,0);
$pdf->Cell(160,$hvt,$txt,0,0);
$txt="Parcours : ".$ident[0]["nomenclature"];
$pdf->Cell(60,$hvt,$txt,0,0);
$txt="Numéro du candidat : ".$ident[0]["numexam"];
$pdf->Cell(0,$hvt,$txt,0,1);

$pdf->SetFont($police,'B',$polibelle);
$pdf->Ln(5);

//situ oblig
$pdf->Cell(4*$lgoblig,$hvp,"Situation obligatoire",1,0,"C");
//<>ajouté
$y0=$pdf->getY();
$x0=$pdf->getX();
$pdf->MultiCell($mgs+$margeinterne,$hvp/2,"Situation professionnelle\n(intitulé et liste des documents et productions associés)",0,"C");
$pdf->SetXY($x0,$y0);
//</ajouté>
$pdf->Cell($mgs+$margeinterne,$hvp,"",0,0);
//processus
for ($i=0;$i<$nbp;$i++){
  $unproc=$entete[$i];
  $largeur=$lg*count($unproc["act"]);
  $pdf->Cell($largeur,$hvp,$unproc["nomenclature"]." ".$unproc["libelle"],1,0,"C");
}

//ecriture verticale pour activites
$pdf->Ln($hvp);


$x0=$offset;
$x=$x0+$lgoblig/2;;
$y0=$pdf->getY();
$y1=$y0+$hv;//hauteur texte à 90°
$pdf->SetFillColor($grisclairfond);

for ($i=0;$i<4;$i++){ //4 sûr, sinon on est mal
	$pdf->TourneTexte(90,$x+$lg/2,$y1,"  ".$typologie[$i]["libelle"]);
    $pdf->SetXY($x,$y0);
  	$pdf->Cell($lg,$hv,"",1,0);//hauteur case verticale
    $x+=$lg;
}

$x0=$mgs+4*$lgoblig+$margeinterne+$offset;
$x=$x0+$lg/2;;
$y0=$pdf->getY();
$y1=$y0+$hv;

$eprE6=array();//récupere à la volée le type d'epreuve pour les autres lignes
for ($i=0;$i<$nbp;$i++){
  $lesact=$entete[$i]["act"];
  for ($j=0;$j<count($lesact);$j++){
    $pdf->SetXY($x,$y0);
    if ($lesact[$j]["idEpreuve"]==3) { //epreuve E6=3 (E4=1 ; E5=2)
    	$pdf->Cell($lg,$hv,"",1,0,"C",true);
    	$eprE6[]=true;
    } else {
    	$pdf->Cell($lg,$hv,"",1,0,"C",false);
    	$eprE6[]=false;
    }
  	$pdf->SetXY($x,$y0);
  	$pdf->TourneTexte(90,$x+$lg/2,$y1,"  ".$lesact[$j]["nomenclature"]."  ".$lesact[$j]["libelle"]);
  	$pdf->Cell($lg,$hv,"",1,0);//hauteur case verticale
    $x+=$lg;
  }
}

$pdf->Ln($hv);


//itération sur les trois sortes de situations
for ($src=0 ; $src<3 ; $src++){//0=formation / 1=stage1 / 2=stage2
	$corps=$lescorps[$src];

	//affichage celules en filigranne
	$pdf->SetDrawColor($grisclairtrait);
	for ($i=0; $i<4;$i++) $pdf->Cell($lgoblig,$hvs,"","LR",0); //4 cellules claires à gauche
	$pdf->Cell($mgs+$margeinterne,$hvs,"",0,0);
	$ysrc=$pdf->getY();
	$xsrc=$pdf->getX();

	for ($i=0;$i<$nba ; $i++) $pdf->Cell($lg,$hvs,"","LR",0);//que gauche et droite en clair
	$pdf->SetXY($xsrc,$ysrc);
	$pdf->SetFont($police,'B',$potexte);
	//$pdf->Cell(0,$hvs,$leslibs[$src],0,1,"C");
	$pdf->Cell(0,$hvs,enutf8($leslibs[$src]),0,1,"C");

	$pdf->SetDrawColor(0); //noir
	foreach($corps as $situ){
	  $typo=$situ["typo"];
	  $pdf->SetFont($police,'B',$pocroix);
	  for ($i=0; $i<count($typologie);$i++)
	    $pdf->Cell($lgoblig,$hvs,$typo[$i],1,0);
	  $pdf->Cell($margeinterne,$hvs,"",0,0);
	  $pdf->SetFont($police,'B',$polibelle);
	  $x0=$pdf->getX();
	  $y0=$pdf->getY();
	  $dts=dtihm($situ["datedebut"]).' - '.dtihm($situ["datefin"]);
	  $pdf->MultiCell($mgs,5,enutf8($situ["libcourt"])."\n".$dts,0);
	  $pdf->setXY($x0,$y0);
	  $pdf->Cell($mgs,$hvs,"",1,0);

	  $act=$situ["act"];

	  //affichage des X pour les activites citées
	  $pdf->SetFont($police,'B',$pocroix);
	  for ($i=0;$i<$nba ; $i++) $pdf->Cell($lg,$hvs," ".$act[$i],1,0,"C",$eprE6[$i]);

	  $pdf->Ln($hvs);
	}
}
//gestion bas de page : soussigné...
$pdf->Ln(10);
$pdf->SetFont($police,'B',$posousigne);
$txtj="Je soussigné-e";
$pdf->Cell(80,$hvt,$txtj,0,0);
$txt="formatrice (formateur) au centre de formation";
$pdf->Cell(120,$hvt,$txt,0,0);
$txt="certifie que le candidat (la candidate) a bien effectué en formation les activités et missions présentées dans ce tableau";
$pdf->Cell(0,$hvt,$txt,0,1,"R");
/*
$pdf->Cell(80,$hvt,$txtj,0,0);
$txt="représentant-e de l’organisation";
$pdf->Cell(120,$hvt,$txt,0,0);
$txt="certifie que le candidat (la candidate) a bien effectué en stage les activités et missions présentées dans ce tableau";
$pdf->Cell(0,$hvt,$txt,0,1,"R");
*/
//**********************************************
//pages perso supplementaires
/*
$synthese=$data["synth"];

$hauteur=40;

if (count($synthese)>0){
  foreach ($synthese as $synt){
    $pdf->AddPage();
    //situation
    //ref, libcourt as libcs, descriptif as descs, datedebut, datefin
    $pdf->SetFont($police,'B',$po2);
    $txt="Situation : ".$synt["libcs"];
    $pdf->MultiCell(0, $ht, $txt, "LTR", "C", 0);
    $pdf->SetFontSize($po2);
    $txt=$synt["descs"];
    $pdf->MultiCell(0, $hcl, $txt, "LBR", "L", 0);
    $txt=dtihm($synt["datedebut"]).' - '.dtihm($synt["datefin"]);
    $pdf->MultiCell(0, $hcl, $txt, "LBR", "L", 0);
*/

$pdf->Output();


?>
