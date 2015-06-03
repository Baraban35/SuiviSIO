// JavaScript Document
var ouvert=false;

function aide(qui,ou) {
  dest='aide/pgaide.php?qui='+qui+'#'+ou;
  fen=window.open(dest,"fenaide",
  "directories=no,location=no,menubar=no,resizable=yes,toolbar=no,status=no,scrollbars=yes,left=150,top=250,width=700,height=400");
  ouvert=true;
  fen.focus();
}

function close_fen(){
  if (ouvert){
    fen1.close();
    ouvert=false;
  }
}
