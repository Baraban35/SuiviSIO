
function verif(){
	var ok=true;
	/*
	if (document.getElementsByClassName('champOblig')){
	//ne marche pas pour IE
		var chObl = document.getElementsByClassName('champOblig');
		var lsObl = document.getElementsByClassName('listeOblig');

		var i=0;
		while (i<chObl.length && ok)
			ok = /\S/.test(chObl[i++].value);
		i=0;
		while (i<lsObl.length && ok)
			ok = lsObl[i++].value!="0";
	} else {
	*/
		var contrObl = document.getElementsByTagName("input");
		var i=0;
		while (i<contrObl.length && ok){
			if (contrObl[i].className=="champOblig")
				ok = /\S/.test(contrObl[i].value);
			i++;
		}
		if (ok){
			contrObl = document.getElementsByTagName("textarea");
			i=0;
			while (i<contrObl.length && ok){
				if (contrObl[i].className=="champOblig")
					ok = /\S/.test(contrObl[i].value);
				i++;
			}
		}
		if (ok){
			contrObl = document.getElementsByTagName("select");
			i=0;
			while (i<contrObl.length && ok){
				if (contrObl[i].className=="listeOblig")
					ok = contrObl[i].value!="0";
				i++;
			}
		}
	//}
	if (!ok) alert("Remplir les champs obligatoires !");
	return ok;
}
