
  var tab=new Array();
  var tbcoul=new Array();

<?php
  $vers=$data["vers"]; //page actuelle

  $pilote=$data["pilote"];
  $situ=$pilote["val"];
  $eleve=$pilote["el"];

  for($i=0;$i<count($situ);$i++) {
    echo 'tab['.$i.']=new Array("'.$situ[$i]["nomen"].'","'.$situ[$i]["lib"].'",'.$situ[$i]["ln"].');';
  }
  $nbCol=$i;
  echo 'var nbcol='.$nbCol.';';

  echo 'if (document.all) {';
    echo  'nvg=true;';
    for($i=0;$i<count($coul1);$i++)
      echo  "tbcoul[".$i."]=new Array('".$coul1[$i][0]."','".$coul1[$i][1]."');";
  echo  '} else {';
    echo  'nvg=false;';
    for($i=0;$i<count($coul2);$i++)
      echo  "tbcoul[".$i."]=new Array('".$coul2[$i][0]."','".$coul2[$i][1]."');";
  echo  '}';

  echo  'var nbcoul='.count($coul1).';';
?>

  var largeurMin=76;
  var largeurMax=980;
  var milieu=(largeurMin+largeurMax)/2;
  var position=0;
  var posl=0;
  var stya=null;
  var styb=null; //*****

  var nvg;

  function getobjsty(ref) {
    if (nvg)
      return document.all[ref].style;
    else
      return document.getElementById(ref).style;
  }

  function setgrisclair(ref){
    getobjsty(ref).backgroundColor=tbcoul[0][0];
  }

  function setgrisfonce(ref){
    getobjsty(ref).backgroundColor=tbcoul[0][1];
  }

  function fonce(ref) {
    coul=getobjsty(ref).backgroundColor;
    i=0;
    while ((i<nbcoul) && coul!=tbcoul[i][0]) i++; //cherche clair
    if (i<nbcoul) getobjsty(ref).backgroundColor=tbcoul[i][1];
  }

  function eclaircit(ref) {
    coul=getobjsty(ref).backgroundColor;
    i=0;
    while ((i<nbcoul) && coul!=tbcoul[i][1]) i++; //cherche foncé
    if (i<nbcoul) getobjsty(ref).backgroundColor=tbcoul[i][0];
  }

  function pop(n,evnt){
  ///ici
    if (stya!=null) stya.visibility="hidden";

    var xfen,yfen,xpg,ypg,obj;
    var offsetXMoins=80;
    var offsetXPlus=15;
    var offsetY=-60;
    var largeur;
    var hauteur=40;

    if (document.all) {
      obj=document.all['popref'];
      xfen = evnt.x;
      yfen = evnt.y;
      xpg=xfen;
      ypg=yfen;
      if (document.body.scrollLeft) xpg = xfen+document.body.scrollLeft ;
      if (document.body.scrollTop)  ypg = yfen+document.body.scrollTop;
    } else {
	    obj=document.getElementById('popref');
	    xfen = evnt.clientX;
      yfen = evnt.clientY ;
      xpg = evnt.pageX ;
      ypg = evnt.pageY ;
    }

    sty=obj.style;
    stya=sty;

    largeur=tab[n][3];
    largeur*=6;

    obj.innerHTML=tab[n][0]+"<br />"+tab[n][1];

    if (xfen+largeur>largeurMax)
      if (xfen-largeur<largeurMin)
        if (xfen>milieu)
          xpg=largeurMin;
        else
          xpg=largeurMax-largeur;
      else
        xpg=xfen-largeur;
    else
      xpg=xfen;
    ypg=ypg+offsetY;
    sty.width=largeur;
		sty.left=xpg+'px';
    sty.top=ypg+'px';

    if (tab[n][2]!=''){
      sty.backgroundColor=tbcoul[3][0];
      sty.borderColor=tbcoul[3][1];
    } else {
      sty.backgroundColor=tbcoul[0][0];
      sty.borderColor=tbcoul[0][1];
    }

    sty.visibility='visible';
    ////jusquici
    n++;

    //fond en-tete colonne
    fonce('0x'+n);
    if (position>0 && position!=n) eclaircit('0x'+position);

    for(var i = 1; i <= nbe; i++) fonce(i+'x'+n);

    if (position>0 && position!=n)
      for(var j = 1; j <= nbe; j++)
        if (j!=posl)
          eclaircit(j+'x'+position);

    position=n;
  }

  function poplig(n,evnt,nom,prenom){
  //copie
      if (styb!=null) styb.visibility="hidden"; //dddd

    var xfen,yfen,xpg,ypg,obj;
    var offsetXMoins=80;
    var offsetXPlus=50;
    var offsetY=-10;
    var largeur;
    var hauteur=40;

    if (document.all) {
      obj=document.all['popnom'];//dd
      xfen = evnt.x;
      yfen = evnt.y;
      xpg=xfen;
      ypg=yfen;
      if (document.body.scrollLeft) xpg = xfen+document.body.scrollLeft ;
      if (document.body.scrollTop)  ypg = yfen+document.body.scrollTop;
    } else {
	    obj=document.getElementById('popnom');//dd
	    xfen = evnt.clientX;
      yfen = evnt.clientY ;
      xpg = evnt.pageX ;
      ypg = evnt.pageY ;
    }

    sty=obj.style;
    styb=sty;//ddd

    largeurn=nom.length;//ddd
    largeurp=prenom.length;//ddd
    if (largeurn>largeurp) largeur=largeurn; else largeur=largeurp;//dd
    //largeur=tab[n][3];
    largeur*=6;

    obj.innerHTML=nom+"<br />"+prenom;//ddd

    /*
    if (xfen+largeur>largeurMax)
      if (xfen-largeur<largeurMin)
        if (xfen>milieu)
          xpg=largeurMin;
        else
          xpg=largeurMax-largeur;
      else
        xpg=xfen-largeur;
    else
      xpg=xfen;
      */

    xpg=xfen-largeur-offsetXPlus;

    ypg=ypg+offsetY;
    sty.width=largeur;
		sty.left=xpg+'px';
    sty.top=ypg+'px';

    /*
    if (tab[n][2]!=''){
      sty.backgroundColor=tbcoul[3][0];
      sty.borderColor=tbcoul[3][1];
    } else {
      sty.backgroundColor=tbcoul[0][0];
      sty.borderColor=tbcoul[0][1];
    }
    */
    sty.visibility='visible';

    ///fincopie



    //fond en-tete ligne
    setgrisfonce('y'+n);
    if (posl>0 && posl!=n) setgrisclair('y'+posl);

    for(var i = 1; i <= nbcol; i++)  fonce(n+'x'+i);
    if (posl>0 && posl!=n)
      for(var j = 1; j <= nbcol; j++)
        if (j!=position) eclaircit(posl+'x'+j);
    posl=n;
  }
