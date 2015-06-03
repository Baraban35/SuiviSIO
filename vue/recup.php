<?php  include_once 'exit.php'; ?>
<div id="corps">

<div id="messavert">
  <?php
    $mess=$data["messagetexte"];
    if (!is_null($mess)) echo '<p>'.$mess.'</p>';
  ?>
</div>

  <form method="post" enctype="multipart/form-data" action="index.php">

      <input type="hidden" name="action" value="recup">

    <table>
      <tr>
        <td> <h3>R&eacute;cup&eacute;ration XML</h3>
          <p>
          <ol>
            <li>cliquer sur &quot;Parcourir&quot; pour chercher le fichier xml
                &eacute;tudiant  &agrave; t&eacute;l&eacute;verser</li>
            <li>cliquer le bouton &quot;Envoi&quot; pour t&eacute;l&eacute;verser
              et mettre &agrave; jour la base avec les donn&eacute;es &eacute;tudiant
              (situations, etc.) et enseignant (commentaires)

            </li>
          </ol>
		  </p>
        </td>
      </tr>
      <tr>
        <td>
          <hr>
        </td>
      </tr>
      <tr>
        <td>Fichier &agrave; t&eacute;l&eacute;verser :
          <input type="file" name="fichier" size="80">
        </td>
      </tr>
      <tr>
        <td>Envoi du fichier au serveur
          <input type="submit" name="envoi" value="Envoi">
        </td>
      </tr>
    </table>
  </form>

</div>
