<?php
include_once('AutoLoader.php');
// Register the directory to your include files
// la constante __DIR__ contient le nom de répertoire du fichier courant
// dirname(__DIR__) fournit le répertoire parent du répertoire courant
// ceci pour remonter au répertoire racine du projet
AutoLoader::registerDirectory(dirname(__DIR__) . '/class');