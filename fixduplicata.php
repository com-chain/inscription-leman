<?php
ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

$id=$_GET['id'];

$query = 'SELECT
              Reg_Person.Id,
              Reg_Person.RecordTypeId,
	          Reg_RecordType.Name, 
              Reg_Individual.Id,
	          Reg_Legal.Id
              
	           
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id

	          ORDER BY Reg_Person.Id';
	          
	          
$stmt = $mysqli->prepare($query);
$stmt->bind_result($read_id, $read_type,$type_name, $read_ind_id, $read_leg_id);
$stmt->execute();
while ($stmt->fetch()){
    echo('PersonId='.$read_id. ' IndividualId='. $read_ind_id . ' LegalId='. $read_leg_id.'<br/>');
}
$stmt->close();	
?>    
