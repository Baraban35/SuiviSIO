
var change=false;

function reste(v,d){
  if (change) {
    document.frmSitu.modif.value='o';
  }
  if (verif()){
	  document.frmSitu.vers.value=v;
	  document.frmSitu.depuis.value=d;
	  document.frmSitu.submit();
  }
}
