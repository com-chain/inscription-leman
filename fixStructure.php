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

	          WHERE Reg_Person.Id = ?';
	          
	          
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i",$id);
$stmt->bind_result($read_id, $read_type,$type_name, $read_ind_id, $read_leg_id);
$stmt->execute();
$stmt->fetch();
$stmt->close();	
    

    
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
  
    <a class="button" href="consultPerson.php?id='.$id.'">Retour</a><br/>
	<h2> Vérification de la structure de donnée pour l\'enregistrement '.$id.'  </h2>';
	
if ($read_id!=$id) {
    echo '<h2> Pas d\'enregistrement pour cet Id!  </h2>';
} else {
    echo "L'enregistrement est de type ".$type_name."<br/>";
    if ($read_type == 1) {
       if ($read_leg_id!=$id) {
            echo "La table Personne Légale est manquante...";
            $query = "INSERT INTO Reg_Legal (Id) VALUES (?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->close();	 
            echo " ...ajout de la table Personne Légale<br/>";
       } else {
            echo "La table Personne Légale est présente<br/>";
       }
    }
    if ($read_type == 2) {
        if ($read_ind_id==$id) {
            echo "La table Personne individuelle est manquante... ";
            $query = "INSERT INTO Reg_Individual (Id) VALUES (?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->close();	
            echo "... ajout de la table Personne individuelle<br/>";  
        } else {
            echo "La table Personne individuelle est présente<br/>";
        }
    }
    
    $new_path = './Data/img_'.$id;
    if (!file_exists($new_path."/index.html" )) {
        echo "La dossier pour les images est manquant... ";
        mkdir($new_path);
        $file = fopen( $new_path."/index.html", 'w');
        fclose($file);
        echo "... ajout du dossier pour les images<br/>";  
    } else {
         echo "La dossier pour les images est présent<br/>";
    }
   

}

	
    
echo '   
   </span>
</body>
</html>';
?>
