1#
Comptes#
<h4>Gestion des comptes</h4>
<p> Cet item donne acc&egrave;s &agrave; cinq options via leur onglet. Les trois
  premiers (<i>Promotion</i>, <i>Professeur</i>, <i>&Eacute;tudiant</i>) permettent
  la cr&eacute;ation individuelle des comptes ; l'onglet <i>Recherche</i> permet
  de rechercher un compte afin de le consulter (perte d'identifiant -si non crypté- par exemple),
  de le modifier ou de le supprimer ; l'onglet <i>Fichier</i> permet de cr&eacute;er
  en une seule op&eacute;ration plusieurs comptes d'&eacute;tudiants &agrave;
  partir d'un fichier (genre fichier Excel du professeur).</p>
<h5>Promotion</h5>
<p>Cet onglet permet de cr&eacute;er les Promotions. Une promotion est identifi&eacute;e
  par un nom et une ann&eacute;e. Par exemple, la promotion nomm&eacute; <i>sio1b</i>
  pour l'ann&eacute;e scolaire 2011-2012 sera identifi&eacute;e dans l'application
  par <i>sio1b-11</i>. Durant une ann&eacute;e scolaire, une promotion correspond
  normalement &agrave; une classe g&eacute;r&eacute;e par un ou plusieurs professeurs
  ; un &eacute;tudiant n'appartient qu'&agrave; une seule promotion.</p>
<p>Les promotions doivent &ecirc;tre pr&eacute;f&eacute;rentiellement cr&eacute;&eacute;s
  avant les comptes des professeurs et des &eacute;tudiants qui y seront ensuite
  affect&eacute;s..</p>
<h5>Professeur</h5>
<p>Cet onglet permet de cr&eacute;er le compte d'un professeur. Vous devez saisir
  son nom, son pr&eacute;nom et son adresse m&eacute;l. Cette derni&egrave;re
  doit &ecirc;tre syntaxiquement valide. Vous pouvez consulter ou modifier ces
  donn&eacute;es dans l'onglet &quot;Recherche&quot;. Le niveau <i>professeur</i>
  permet de voir les travaux des &eacute;tudiants et de commenter leurs situations. Le niveau
  <i>lecteur</i> permet seulement de consulter les donn&eacute;es des &eacute;tudiants.
  Vous devez cocher la ou les promotions dont le professeur assurera le suivi (avec
  &eacute;ventuellement d'autres professeurs affect&eacute;s &agrave; cette promotion).</p>
<h5>&Eacute;tudiant</h5>
<p>Cet onglet permet de cr&eacute;er un compte &eacute;tudiant en saisissant son
  nom, son pr&eacute;nom et l'adresse m&eacute;l valide qui lui servira d'identifiant.
  Vous devez s&eacute;lectionner la promotion dont fait partie cet &eacute;tudiant.</p>
<h5>Recherche</h5>
<p>Cet onglet permet de rechercher une promotion, un professeur ou un &eacute;tudiant.
  Apr&egrave;s avoir s&eacute;lectionn&eacute; l'un d'entre eux, vous &ecirc;tes
  dirig&eacute; vers une des trois interfaces pr&eacute;sent&eacute;es ci-dessus,
  en mode modification : vous pouvez modifier un ou plusieurs &eacute;l&eacute;ments
  puis enregistrer ces modifications.</p>
<p>Vous pouvez aussi supprimer la promotion, le professeur ou l'&eacute;tudiant.</p>
<p>La suppression d'une promotion entraine le d&eacute;tachement des professeurs et
  &eacute;tudiants qui en font partie, sans les supprimer : en particulier les
  saisies des &eacute;tudiants ne sont pas perdues. Mais il faudra ult&eacute;rieurement
  attacher ces professeurs et ces &eacute;tudiants &agrave; une nouvelle promotion
  afin que leur travail collaboratif puisse &ecirc;tre effectu&eacute;.</p>
<p>La suppression d'un professeur ou d'un &eacute;tudiant correspond en fait &agrave;
  un marquage : ils n'apparaissent plus dans l'application mais ne sont pas supprim&eacute;s
  de la base de donn&eacute;es : la suppression d&eacute;finitive ou la restauration
  de ces comptes peut &ecirc;tre r&eacute;alis&eacute;e par l'option <i>Gestion
  suppression</i> (confer ci-dessous).</p>
<h5>Fichier</h5>
<p>Cet onglet permet de cr&eacute;er rapidement les comptes &eacute;tudiants &agrave;
  partir d'un fichier. Ceci permet d'utiliser le fichier d'&eacute;l&egrave;ves
  que poss&egrave;dent en g&eacute;n&eacute;ral les enseignants. Ce doit &ecirc;tre
  un fichier csv, obtenu usuellement &agrave; partir d'Excel mais r&eacute;alisable
  aussi &agrave; partir d'un simple &eacute;diteur de texte.</p>
<p>Dans ce fichier, une ligne correspond &agrave; un &eacute;tudiant ; chaque
  ligne contient, dans cet ordre, son nom, son pr&eacute;nom et son adrese m&eacute;l
  (qui doit &ecirc;tre valide). Ces trois donn&eacute;es sont s&eacute;par&eacute;es
  par le caract&egrave;re point-virgule. Exemple d'une ligne :</p>
<p>Martel;Jean;martel@voila.fr</p>
<p>Le nom &quot;Martel&quot; est suivi d'un point-virgule, du pr&eacute;nom &quot;Jean&quot;,
  d'un autre point-virgule puis de l'adresse m&eacute;l &quot;martel@voila.fr&quot;.</p>
<p>Vous pouvez g&eacute;n&eacute;rer ce fichier avec Excel en cr&eacute;ant une
  feuille de trois colonnes correspondant aux trois donn&eacute;es (nom, pr&eacute;nom,
  m&eacute;l), sans en-t&ecirc;te (la premi&egrave;re ligne correspond au premier
  &eacute;tudiant), puis en exportant ce fichier au format csv. Il ne doit y avoir
  aucune ligne vide.</p>
<h4>Suivi groupes</h4>
<p>Cet item permet, apr&egrave;s avoir cliqu&eacute; sur le nom d'un groupe, d'en
  voir les diff&eacute;rents membres (&eacute;tudiants et professeurs).</p>
<h4>Gestion suppressions</h4>
<p>Cet item permet de restaurer ou de supprimer d&eacute;finitivement les comptes supprim&eacute;s
  (en fait marqu&eacute;s) avec l'option de recherche pr&eacute;sent&eacute;e
  ci-dessus. Deux onglets offrent des services identiques, un pour les comptes
  des professeurs, l'autre pour les comptes des &eacute;tudiants.</p>
<h5>Professeurs </h5>
<p>Cet onglet montre, s'il y en a, les comptes de professeurs qui ont &eacute;t&eacute;
  supprim&eacute;s : leur nom, leur pr&eacute;nom, et le nombre de situations
  qu'ils ont valid&eacute;. Un clic sur <i>restaurer</i> restaure le compte ; un clic sur
  <i>supprimer</i> le supprime d&eacute;finitivement.</p>
<h5>&Eacute;tudiants </h5>
<p>Cet onglet montre, s'il y en a, les comptes d'&eacute;tudiants qui ont &eacute;t&eacute;
  supprim&eacute;s : leur nom, leur pr&eacute;nom, et le nombre de situations
  qu'ils ont saisi. Un clic sur <i>restaurer</i> restaure le compte ; un clic
  sur <i>supprimer</i> le supprime d&eacute;finitivement <b>ainsi que toutes les
  donn&eacute;es qui en d&eacute;pendent (situations, productions, validations,
  &eacute;valuations)</b>.</p>
<h4>Fin d'&eacute;tudes</h4>
<p>Cette option permet de supprimer d&eacute;finitivement de la base les &eacute;tudiants
  qui ont termin&eacute; leurs &eacute;tudes.</p>
