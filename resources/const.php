<?php

function getServerName(){
    return "Monnaie-Leman";
}



function doSendMailOnInsert(){
    return false;
}

function getMailSubject(){
  return 'Vos information pour Monnaie-Léman';
}

function getMailText($nom,$prenom,$code){
    return 'Bonjour '.$prenom.' '.$nom.',%0A%0A
Voici les information dont vous aurez besoin pour Monnaie-Léman.%0A %0A

Meilleures salutations%0A
Votre équipe Monnaie-Léman%0A%0A

Liens vers votre votre lettre de bienvenue:%0A
https://adm.cchosting.org/pdf.php?id='.$code.'&nom='.$prenom.' '.$nom.'
';
}

function getMailHeader(){
    return 'From: dominique.climenti@monnaie-leman.org' . "\r\n" .
        'Reply-To: dominique.climenti@monnaie-leman.org' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
}



?>
