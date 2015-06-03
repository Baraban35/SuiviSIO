<?php
$cle=array();

$cle[]='alter table '.$prefixe.'production add foreign key fkprodsitu (refSituation)
      references '.$prefixe.'situation (ref)';
$cle[]='alter table '.$prefixe.'situation add foreign key fksituetud (numEtudiant)
      references '.$prefixe.'etudiant (num)';
$cle[]='alter table '.$prefixe.'commentaire add foreign key fkcommsitu (refSituation)
      references '.$prefixe.'situation (ref)';
$cle[]='alter table '.$prefixe.'activitecitee add foreign key fkaccisitu (refSituation)
      references '.$prefixe.'situation (ref)';
$cle[]='alter table '.$prefixe.'activitecitee add foreign key fkacciacti (idActivite)
      references '.$prefixe.'activite (id)';

$cle[]='create index icommsitu on '.$prefixe.'commentaire (refSituation)';
$cle[]='create index iprodsitu on '.$prefixe.'production (refSituation)';
$cle[]='create index isituetud on '.$prefixe.'situation (numEtudiant)';
$cle[]='create index isitulibc on '.$prefixe.'situation (libcourt)';
$cle[]='create index iaccisitu on '.$prefixe.'activitecitee (refSituation)';
$cle[]='create index ietudgrou on '.$prefixe.'etudiant (numGroupe)';

?>