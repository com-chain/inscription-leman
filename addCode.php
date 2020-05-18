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

$code = $_GET['code'];

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
  
  
    <a class="button" href="consultPerson.php?id='.$id.'">Annuler</a><br/>
  
    <h2> Ajouter manuelement un code </h2>';
    
    if ($typeId==1){
        echo '<h3> Pour l\'Entreprise '.$Name.'</h3></br>';
    } else {
        echo '<h3> Pour la Personne individuelle '.$FirstName.' '.$LastName.'</h3></br>';
    }
    
    if ($code!=''){
        echo '<span class="widelabel missing" >Ce code n\'est pas au bon format ou existe déjà dans la base!</span> <br/>';
        $query = 'SELECT PersonId
	          FROM Reg_Code
	          WHERE Code=? 
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("s",$code);
    $stmt->bind_result($pid);
    $stmt->execute();
     while ($stmt->fetch()){ 
        echo '<a  class="button" target="_blank" href="consultPerson.php?id='.$pid.'">Consulter la fiche</a>';
     }
     
    $stmt->close();	
     echo '<br/><br/><br/><br/>';
    }
    
    echo '<form  action="saveCode.php" method="post" >
          <input   type="hidden"  name="id" value="'.$id.'" />
          <input type="radio" id="code_m" name="ct" value="Manual" checked="checked">Code existant</br>
          <span class="half" style="width:Calc(100% - 20px)">
            <span class="label" >Code à ajouter:</span>
            <input   type="text"  name="code" value="'.$code.'" placeholder="Code"/>
          </span><br/>';
          
          
    $query = 'SELECT count(*) FROM Reg_Code WHERE PersonId IS NULL';
    $stmt = $mysqli->prepare($query);
    $stmt->bind_result($nb);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	
    if ($nb>0){
        echo '<input type="radio" id="code_m" name="ct" value="Link">Code non lié</br>
          <span class="half" style="width:Calc(100% - 20px)">
            <span class="label" >Code:</span>';
        $query = 'SELECT Reg_Code.Id , code, address FROM Reg_Code LEFT OUTER JOIN Reg_Wallet ON CodeId = Reg_Code.Id WHERE Reg_Code.PersonId IS NULL';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_result($codeid, $code,$add);
        $stmt->execute();
        echo ' <select  class="inputText" name="lc" >
	    <option value ="-1"></option>';
        while ($stmt->fetch()){
            echo ' <option value ="'.$codeid.'">'.$code.'('.$add.')</option>';
        }
        $stmt->close();	
        echo '</span><br/>';
         
    }  
    
    if ($typeId==1) {
        $newcode=md5($id.$Name);     
    } else {
        $newcode=md5($id.$LastName.$FirstName);
    }
     
    $query = 'SELECT count(*) FROM Reg_Code WHERE Code=?';
    $stmt = $mysqli->prepare($query);
	$stmt->bind_param("s",$newcode);     
    $stmt = $mysqli->prepare($query);
    $stmt->bind_result($nb);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	
    
    if ($nb==0) {
    echo' <input type="radio" id="code_m" name="ct" value="Gen">Générer le code
    <input   type="hidden"  name="gen" value="'.$newcode.'" />
    </br>';
    }   
          
    echo'
         <input class="button"  type="submit" value="Enregistrer" />
          
          
          
        </form>';
    

      


    
echo '   
   </span>
</body>
</html>';
?>
