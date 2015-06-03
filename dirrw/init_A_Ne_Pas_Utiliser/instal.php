<html>
<head>
<title>Installation passeport</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<h2 align="center">Installation et param&eacute;trage de l'application &quot;Suivi des
 comp&eacute;tences SIO &quot;</h2>

<form method="post" action="enregparam.php">
  <table width="100%" border="0" cellspacing="0">
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Nom du serveur de base de donn&eacute;es : </div>
      </td>
      <td width="45%">
        <input type="text" name="nomserveur" maxlength="40" size="50" value="localhost">
      </td>
    </tr>
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Login du compte d'administration de ce serveur : </div>
      </td>
      <td width="45%">
        <input type="text" name="login" maxlength="24" size="30" value="root">
      </td>
    </tr>
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Mot de passe du compte d'administration de ce serveur
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="mdp" maxlength="32" size="40">
      </td>
    </tr>
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Nom de la base de donn&eacute;es : </div>
      </td>
      <td width="45%">
        <input type="text" name="nombd" maxlength="40" size="50" value="portefeuille">
      </td>
    </tr>
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Faut-il cr&eacute;er la base de donn&eacute;es (si
          elle n'existe pas encore) ?</div>
      </td>
      <td width="45%">
        <input type="checkbox" name="creation" value="checkbox" checked>
      </td>
    </tr>
    <tr bgcolor="#33CC00">
      <td width="55%">
        <div align="right">Pr&eacute;fixe des tables (<i>underscore</i> sera ajout&eacute;
          en fin de pr&eacute;fixe): </div>
      </td>
      <td width="45%">
        <input type="text" name="prefixe" maxlength="6" size="10" value="port">
      </td>
    </tr>


    <tr bgcolor="#33CCCC">
      <td width="55%">
        <div align="right">Longueur des mots de passe (12 caract&egrave;res maximum)
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="lngmdp" maxlength="2" size="5" value="6">
      </td>
    </tr>
	    <tr bgcolor="#33CCCC">
      <td width="55%">
        <div align="right">Cryptage des mots de passe dans la base ? </div>
      </td>
      <td width="45%">
        <input type="checkbox" name="crypte" value="checkbox">
      </td>
    </tr>
    <tr bgcolor="#FFFF66">
      <td width="55%">
        <div align="right">Un serveur SMTP est-il disponible ?</div>
      </td>
      <td width="45%">
        <input type="checkbox" name="smtp" value="checkbox">
      </td>
    </tr>
    <tr bgcolor="#FFFF66">
      <td width="55%">
        <div align="right">Adresse m&eacute;l du contact pour &eacute;tudiants
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="contact" maxlength="64" size="40" value="-votre mel-">
      </td>
    </tr>
    <tr bgcolor="#FF9933"> 
      <td width="55%"> 
        <div align="right">Adresse m&eacute;l (&quot;login&quot;) de l'administrateur:
          (&quot;admin&quot;) de l'application : </div>
      </td>
      <td width="45%"> 
        <input type="text" name="loginadmin" maxlength="64" size="40" value="admin@local.fr">
      </td>
    </tr>

    <tr bgcolor="#FF9933">
      <td width="55%">
        <div align="right">Mot de passe (&quot;code&quot;) del'administrateur
          (&quot;admin&quot;) de l'application : </div>
      </td>
      <td width="45%">
        <input type="text" name="mdpadmin" maxlength="12" size="20" value="123456">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Enregistrement des donn&eacute;es et cr&eacute;ation
          des tables </div>
      </td>
      <td width="45%">
        <input type="submit" name="Submit" value="Envoyer">
      </td>
    </tr>
  </table>
</form>

</body>
</html>
