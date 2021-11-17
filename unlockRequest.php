<?php

include 'checkUser.php';
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();



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
  
  
    <a class="button" href="user.php">Mon Compte</a>';
    if (isAdmin()){
         echo'<a class="button" href="admin.php">Admin</a>';
    }
    echo'<a class="button" href="consult.php">Inscriptions</a>
         <a class="button" href="login.php">Logout</a><br/>
  
    <h2> Demandes de déblocage à traiter </h2>
    <table>
	    <tr><td>Adresse</td><td>Date</td><td>Actions</td></tr>';
    
    $query = 'SELECT id, address, EventDate FROM Reg_UnlockRequest order by Id ASC'; 
$stmt = $mysqli->prepare($query);
$stmt->bind_result($id, $add, $date);
$stmt->execute();
while ($stmt->fetch()){ 
     echo '<tr><td>'.$add.'</td><td>'.$date.'</td><td>';
     if (canEdit()){
        echo'<a class="button" href="dismissUnlock.php?id='.$id.'">Supprimer</a>';
     }
     echo'</td></tr>';
}
$stmt->close();	

 

      


    
echo '   
   </span>
</body>
</html>';
?>
