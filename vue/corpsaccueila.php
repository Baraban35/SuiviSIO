
<div id="corps">


  <h2>Comptes</h2>
  <p>Ce menu permet de cr&eacute;er les promotions ainsi que les comptes des professeurs 
    et des &eacute;tudiants. Il est le pr&eacute;alable indispensable &agrave; 
    toute utilisation. Le <i>login</i> d'un compte correspond &agrave; l'adresse 
    m&eacute;l de son titulaire ; cette adresse doit &ecirc;tre unique et syntaxiquement 
    valide. Son existence r&eacute;elle n'est requise qu'en cas d'utilisation 
    d'un serveur de messagerie qui transmettra le mot de passe choisi al&eacute;atoirement 
    par le syst&egrave;me.</p>
  <p>Une promotion a logiquement une dur&eacute;e de vie de un an ; elle est identifi&eacute;e 
    par son nom suivi d'un tiret et des deux derniers chiffres de l'ann&eacute;e. 
    Par exemple la promotion <i>sio1b</i> pour l'ann&eacute;e <i>2011</i> a comme 
    identifiant <i>sio1b-11</i>. Pratiquement, une promotion correspond &agrave; 
    une classe ou a un de ses sous-ensembles. Une promotion correspond &agrave; 
    un parcours : SISR, SLAM ou indif&eacute;renci&eacute; (premier semestre) 
    ; un &eacute;tudiant a donc comme parcours celui de sa promotion. Durant une 
    ann&eacute;e scolaire, un professeur peut g&eacute;rer une ou plusieurs promotions, 
    un &eacute;tudiant n'appartient qu'&agrave; une seule promotion. En cas de 
    changement, quelle que soit sa promotion, un &eacute;tudiant conserve toutes 
    ses donn&eacute;es.</p>
  <h2>Code d'acc&egrave;s</h2>
  <p>Les mots de passe des professeurs et &eacute;tudiants sont g&eacute;n&eacute;r&eacute;s
    par l'application lors de la cr&eacute;ation des comptes. Ils peuvent &ecirc;tre
    modifi&eacute;s par l'administrateur aussi bien que par le titulaire du compte.</p>
  <p>Si un serveur SMTP est disponible, le mot de passe est envoy&eacute; &agrave;
    son titulaire.</p>
  <p>S'il n'y a pas de serveur SMTP et que les mots de passe ne sont pas crypt&eacute;s 
    dans la base (option d'installation), l'administrateur doit fournir ces informations 
    &agrave; leurs destinataires &agrave; l'aide de la liste propos&eacute;e pas 
    ce menu.</p>
  <p>S'il n'y a pas de serveur SMTP et que les mots de passe sont crypt&eacute;s
    dans la base, l'application g&eacute;n&egrave;re comme mot de passe la cha&icirc;ne
    de quatre caract&egrave;res ABCD pour chaque utilisateur qui devra modifier
    cette valeur lors de sa premi&egrave;re connexion.</p>
  <h2>Restauration</h2>
  <p>Vous pouvez restaurer les donn&eacute;es d'un &eacute;tudiant &agrave; partir 
    de sa sauvegarde XML. Vous pouvez utiliser cette fonctionnalit&eacute; (&eacute;galement 
    disponible pour les professeurs) pour tous les &eacute;l&egrave;ves. Les commentaires 
    des enseignants sont automatiquement restaur&eacute;s, mais l'identification 
    de leur auteur n'est r&eacute;alis&eacute;e que s'ils sont d&eacute;j&agrave; 
    enregistr&eacute;s.</p>
  <p>Pour des &eacute;tudiants provenant d'autres &eacute;tablissements, vous 
    devez restaurer les donn&eacute;es en deux temps : d'abord cr&eacute;ation 
    d'un nouveau compte &eacute;tudiant, ensuite restauration des donn&eacute;es 
    fournies par celui-ci. Les commentaires apparaitront alors sans indication 
    du professeur qui en est l'auteur.</p>
  <h2>Sauvegarde</h2>
  <p>L'int&eacute;gralit&eacute; de la base de donn&eacute;es est sauvegard&eacute;e
    sur le serveur web afin de permettre une restauration &eacute;ventuelle. Il
    est recommand&eacute; de copier cette sauvegarde sur un support externe afin
    de pallier &agrave; une &eacute;ventuelle panne commune des serveurs web et
    sql.</p>
</div>
