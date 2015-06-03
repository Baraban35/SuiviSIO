// JavaScript Document
function verif(doc){
  frmnom=doc.nom.value;
  frmprenom=doc.prenom.value;
  frmmel=doc.mel.value;
  
  if (frmnom==0 || frmprenom=="" || frmmel==""){
    alert("Remplir les champs obligatoires !");
    return false;
  }else {
    var reg = new RegExp('^[a-zA-Z0-9_-\.]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$', 'g');

	  if (reg.test(frmmel)){
      return true;
    } else {
      alert("Adresse mel incorrecte !");
      return false;
    }
  }
}
