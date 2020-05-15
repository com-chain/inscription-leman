<?php
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(1);
echo'  
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
 <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> <br/> 
 <a href="http://monnaie-leman.org/"  class="ariane">< Retour</a> 
  
	<h2> Ouverture de compte électronique </h2>';

echo '

En 4 courtes étapes (10 min. environ), j’ouvre un compte en Léman électronique et je soutiens une économie locale, durable et solidaire !
    <h3> Je suis:  </h3>
    
    <span class="half">
    <a class="big_button" href="./individual.php">UN PARTICULIER</a><br/>
    Je dispose:
    <ul>
      <li>d’une copie de ma pièce d’identité (jpg ou pdf).</li>
    </ul>
    </span>
    
    <span class="half">
	<a class="big_button" href="./legalPerson.php">UNE ENTREPRISE</a><br/>
	<span class="small">
	Sont considérées comme "ENTREPRISE", toutes les structures professionnelles (personnes morales: PME, associations, raisons individuelles, etc.). Ce formulaire est une inscription pour ouvrir un compte électronique professionnel et devenir une entreprise membre du réseau.	   
	</span><br/><br/>
	
	
    Je dispose:
    <ul>
      <li>des coordonnées de l\'entreprise;</li>
      <li>des statuts de l’entreprise;</li>
      <li>du nombre des personnes employées par l’entreprise (ETP);</li>
      <li>d’une copie de ma pièce d’identité (et si applicable, des personnes ayant droit économique (ADE) et/ou autorisées à utiliser la monnaie électronique);</li>
      <li>d’une copie des deux derniers états financiers (si disponibles);</li>
      <li>d’une copie du Registre du commerce (RC) si applicable.</li>
     </ul><br/><br/>
     
     Pour mes dépenses personnelles ou pour recevoir un salaire, j’ouvre un compte <a class="" href="./individual.php">PARTICULIER</a> également.
     
    </span>

   </span>
</body>
</html>';
?>
