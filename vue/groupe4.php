<?php  include_once 'exit.php'; ?>
<div id="corps">
<div id="navcontainer">
<ul id="navlist">

<?php
$num=$data["param"];
include_once './vue/menus/menugroupe.php';

?>

</ul>
</div>

<script type="text/javascript">
  function sel(){
      document.frmRech.submit();
  }
</script>

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<form name="frmRech" method="post" action="index.php">
    <?php
      echo '<input type="hidden" name="action" value="groupe" />';
      echo '<input type="hidden" name="num" value="'.$num.'" />';
      echo '<input type="hidden" name="envoi" value="Rechercher" />';
    ?>

    <table width="80%" border="0" cellspacing="3" align="center">
	      <tr>
        <td colspan="3">
        <h3>Recherche d'une promotion, d'un professeur ou d'un &eacute;tudiant</h3>
          <p>Cet onglet permet de rechercher une promotion, un professeur ou un &eacute;tudiant
            afin d'en modifier les caract&eacute;ristiques ou &eacute;ventuellement
            de le supprimer.</p>
          <p>(une suppression entraine la perte des informations d&eacute;j&agrave;
            saisies : par exemple, supprimer un &eacute;tudiant qui a d&eacute;j&agrave;
            enregistr&eacute; diff&eacute;rents situations implique l'effacement
            de ces derni&egrave;res)</p>
          </td>
      </tr>
	  <tr><td colspan="3"><hr /></td></tr>


      <tr>
        <td>
          <div align="center"> Promotion :
          <select name="groupes" onchange="sel();">
          <option value="0" selected>- choisir -</option>
              <?php
                 $type=$data["groupes"];
                 foreach ($type as $item) {
                   echo '<option value="'.$item["num"].'">'.$item["libelle"].'</option>';
                 }
              ?>
          </select>
          </div>
        </td>
        <td>
          <div align="center"> Professeur :
          <select name="professeurs" onchange="sel();">
          <option value="0" selected>- choisir -</option>
              <?php
                 $type=$data["professeurs"];
                 foreach ($type as $item) {
                   echo '<option value="'.$item["num"].'">'.$item["libelle"].'</option>';
                 }
              ?>
          </select>
          </div>
        </td>
        <td>
          <div align="center"> &Eacute;tudiant :
          <select name="etudiants" onchange="sel();">
          <option value="0" selected>- choisir -</option>
              <?php
                 $type=$data["etudiants"];
                 foreach ($type as $item) {
                   echo '<option value="'.$item["num"].'">'.$item["libelle"].'</option>';
                 }
              ?>
          </select>
          </div>
        </td>
      </tr>

    </table>

</form>
</div>
