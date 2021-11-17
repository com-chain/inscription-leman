<?php
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(0);
echo'  
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
 <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> <br/>
 <a href="http://monnaie-leman.org/" class="ariane">< Retour</a> 
  
	<h2> Adhésion à Monnaie Léman </h2>';

echo '

Ce formulaire vous permet d’adhérer à l’association Monnaie Léman.

    <h3> Je suis: </h3>
    
    <span class="half">
        <a class="big_button" href="./individual.php?adh=1">UN PARTICULIER</a><br/>
    </span>
    
    <span class="half">
	    <a class="big_button" href="./legalPerson.php?adh=1">UNE ENTREPRISE</a><br/>
	    <span class="small">
	    Est considéré comme "ENTREPRISE", toutes les structures professionnelles (personnes morales: PME, associations, raisons individuelles, etc.).
	    </span>
    </span>

   </span>
</body>
</html>';
?>
