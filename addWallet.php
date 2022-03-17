<?php

include 'checkUser.php';
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}


echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(10);
echo'  
  </head>
<body>';


$id=$_GET['id'];
$curr=$_GET['cur'];
$origin=$_GET['o'];
$wallet ='';
if (isset($_GET['wallet'])){
    $wallet = $_GET['wallet'];
}

$query = 'SELECT 
	          Reg_RecordType.Id,
	          Reg_RecordType.Name, 
	         
	          Reg_Individual.FirstName, 
	          Reg_Individual.LastName, 
	          
	          Reg_Legal.Name
	           
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            
	            
	          WHERE Reg_Person.Id = ?';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($typeId, $typeName,$FirstName,$LastName,$Name);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	



echo '
  <span class="fond"></span>
  <span class="cont">
  
  
    <a class="button" href="consultPerson.php?id='.$id.'&o='.$origin.'">Annuler</a><br/>
  
    <h2> Ajouter manuelement un compte en LEM - '.$curr.'</h2>';
    
    if ($typeId==1){
        echo '<h3> Pour l\'Entreprise '.$Name.'</h3></br>';
    } else {
        echo '<h3> Pour la Personne individuelle '.$FirstName.' '.$LastName.'</h3></br>';
    }
    
    if (isset($_GET['error'])){
        if ($_GET['error']==1){
             echo '<span class="widelabel missing" >L\'adresse fournie n\'est pas au bon format!</span> <br/>';
        } else  if ($_GET['error']==2){
            echo '<span class="widelabel missing" >L\'adresse fournie existe déjà dans la base!</span> <br/>';
         $query = 'SELECT PersonId
	          FROM Reg_Wallet
	          WHERE address=? 
	           ';
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("s",$addr);
            $stmt->bind_result($pid);
            $stmt->execute();
            while ($stmt->fetch()){ 
                echo '<a  class="button" target="_blank" href="consultPerson.php?id='.$pid.'">Consulter la fiche</a>';
            }
             
            $stmt->close();	
        } else  if ($_GET['error']==3){
             echo '<span class="widelabel missing" >L\'adresse fournie n\'est pas associée à un Code! <br/>(C\'est possible pour les toutes vielles adresses, si il y en a beaucoup contacter Florian pour forcer l\'insert...)</span> <br/>';
        } else  if ($_GET['error']==4){
            echo '<span class="widelabel missing" >L\'adresse fournie est associée à un Code liée à une autre personne/entreprise!</span> <br/>';
            $query = 'SELECT PersonId
	              FROM Reg_Code
	              WHERE Id=? 
	               ';
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("i",$_GET['cid']);
            $stmt->bind_result($pid);
            $stmt->execute();
             while ($stmt->fetch()){ 
                echo '<a  class="button" target="_blank" href="consultPerson.php?id='.$pid.'">Consulter la fiche</a>';
            }
            $stmt->close();
        }else  if ($_GET['error']==5){
            echo '<span class="widelabel missing" >L\'adresse fournie est associée à un Code liée à l\'autre monnaie!</span> <br/>';
        }
     	
        echo '<br/><br/><br/><br/>';
    }
    
    
    echo '<form  action="saveWallet.php" method="post" >
          <input   type="hidden"  name="cur" value="'.$curr.'" />
          <input   type="hidden"  name="id" value="'.$id.'" />
          <input   type="hidden"  name="o" value="'.$origin.'" />
          <span class="label" >Address du compte à ajouter:</span>
          <input   type="text"  name="wallet" value="'.$wallet.'" placeholder="0x123456...."/></br>
          <span class="label" >Ce compte est déjà validé</span>
          <input   type="checkbox" name="validated" value="1"></br>
          <input class="button"  type="submit" value="Enregistrer" />
        </form>';
    

      


    
echo '   
   </span>
</body>
</html>';
?>
