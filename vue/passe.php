<?php  include_once 'exit.php'; ?>
<div id="corps">

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

<form method="post" action="index.php">
    <?php
      echo '<input type="hidden" name="action" value="passe" />';
    ?>
    <h3>Envoi d'un mot de passe &agrave; un ou plusieurs utilisateurs</h3>
	<p>Cette page permet d'envoyer un mot de passe personnel par messagerie &eacute;lectronique
      &agrave; un professeur, &agrave; un &eacute;tudiant ou &agrave; tous les
      &eacute;tudiants d'une promotion.</p>

    <p>Vous choisissez le ou les destinataire(s) dans une ou plusieurs des listes
      d&eacute;roulantes propos&eacute;es puis vous cliquez sur le bouton &quot;Envoyer&quot;.
      Pour s&eacute;lectionner plusieurs personnes d'une m&ecirc;me liste, vous
      pouvez utiliser les touches <i>Ctrl</i> ou <i>Maj</i></p>
    <p>Les serveurs de messagerie ne transmettent pas toujours imm&eacute;diatement
      les envois : ne r&eacute;p&eacute;tez pas inconsid&eacute;r&eacute;ment
      le clic du bouton &quot;Envoyer&quot; pour &eacute;viter l'envoi de multiples
      messages identiques vers le(s) destinataire(s). La responsabilit&eacute;
      de l'acheminement &eacute;tant r&eacute;partie entre les diff&eacute;rents
      serveurs concern&eacute;s, aucune garantie de bonne r&eacute;ception n'est
      induite par l'information &quot;les messages ont bien &eacute;t&eacute;
      envoy&eacute;s&quot;.</p>
    <p>ATTENTION : certains serveurs comme 000.webhost.com interdisent d&eacute;finitivement
      l'envoi de m&eacute;ls lorsqu'un quota de 20 m&eacute;ls/minute a &eacute;t&eacute;
      d&eacute;pass&eacute;.</p>
    <p><b>Privil&eacute;giez la transmission directe</b> des mots de passe sans
      recours &agrave; la messagerie.</p>
	  <hr>
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <td>
          <div align="center">Promotion :
          </div>
        </td>
        <td>
          <div align="center">Professeur :
          </div>
        </td>
        <td>
          <div align="center">&Eacute;tudiant :
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div align="center">
            <select name="groupes" size="6" multiple>
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
          <div align="center">
            <select name="professeurs" size="6" multiple>
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
          <div align="center">
            <select name="etudiants[]" size="6" multiple>
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
      <tr>
        <td colspan="3" height="37">
          <div class="centrer">
            <input type="submit" name="envoi" value="Envoyer" />
          </div>
        </td>
      </tr>
    </table>

</form>
</div>
