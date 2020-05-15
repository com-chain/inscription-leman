<?php
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(10);
echo'  
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
	<h2> Connectez vous </h2>';

echo '
    <span class="cont_d" >

  
  	<form action="./identification.php" method="post">
	 <span class="fitem">
	   <span class="label">Nom d\'utilisateur:</span>
	   <input class="inputText"  type="text" name="login" value="" /><br/>
	 </span>
	 <span class="fitem">
	   <span class="label">Mot de passe:</span>
       <input class="inputText"  type="password" name="mdp" value="" /><br/>
     </span>
	 <span class="btnBar"> 
	   <input type="submit" class="button" value="Se connecter">
	 </span>
	
    </form>
     
   
  </span>
   </span>
</body>
</html>';
