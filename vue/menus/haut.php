<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <link rel="stylesheet" media="screen" type="text/css" title="Portefeuille" href="style.css" />
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
       <title>Suivi des compétences SIO</title>
       <script type="text/javascript" src="./vue/js/fenaide.js"></script>


   </head>

   <body>

       <div id="bandeau">
         <div id="qui">
           <?php
              $utilisateur=$data["utilisateur"];
              if (!is_null($utilisateur)){
                  echo $utilisateur[0]["prenom"].' '.$utilisateur[0]["nom"].'<br />';
                  echo $utilisateur[0]["groupe"]."-".$utilisateur[0]["an"].'<br />';
                  echo '<a href="index.php?action=fermesession">d&eacute;connecter</a>';

              }
            ?>
          </div>
        </div>
       <div id="left">
