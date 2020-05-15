<?php

include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}

include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

$id=$_GET['id'];

$query = 'SELECT 
	          Reg_RecordType.Id,
	          Reg_RecordType.Name, 
	          Reg_Status.Id,
	          Reg_Status.Name,
	           
	        
             
  
	          Reg_Individual.FirstName, 
	          Reg_Individual.LastName, 
	          Reg_Individual.Gender,
              Reg_Individual.Citizenship,
              Reg_Individual.BirthDate,
              Reg_Individual.IdCard,
	          
	          Reg_Legal.Name,
	          Reg_Legal.Contact,
              Reg_Legal.LegalForm,
              Reg_Legal.CreationDate,
              Reg_Legal.ActivityField,
              Reg_Legal.ActivityDescription,
              Reg_Legal.EFT ,
             
             
              Reg_Legal.IdCard_1,
              Reg_Legal.IdCard_2,
              Reg_Legal.IdCard_3,
              Reg_Legal.IdCard_4,
              Reg_Legal.IdCard_5,
              Reg_Legal.IdCard_6,
              Reg_Legal.IdCard_7,
              Reg_Legal.IdCard_8,
              Reg_Legal.IdCard_9,
              Reg_Legal.IdCard_10,
              Reg_Legal.IdCard_11,
              Reg_Legal.IdCard_12,
              Reg_Legal.FinState_1,
              Reg_Legal.FinState_2,
              Reg_Legal.FinState_3,
              Reg_Legal.Registration_1,
              Reg_Legal.Registration_2,
              Reg_Legal.Registration_3
	           
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            
	            
	          WHERE Reg_Person.Id = ?';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($type,$typeName,$status,$statusName,
                       $FirstName,$LastName,$Gender,$Citizenship,$BirthDate,$IdCard,
                       $Name,$Contact,$LegalForm,$CreationDate,$ActivityField,$ActivityDescription,$EFT,
                       $IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12,
                       $FinState_1,$FinState_2,$FinState_3,$Registration_1,$Registration_2,$Registration_3);
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
    <script>
        function handleFileDialog(changed) {
           
            if (changed){
                var file = document.getElementById("img").files[0];

                if(file && file.size < 1048576*'.$uploal_limit_MB.') { // 1 MB (this size is in bytes)
                     document.forms[\'form\'].submit(); 
                } else {
                    alert("Ce fichier est trop volumineux! il fait "+Math.round(file.size/10485.76)/100+"MB, la limite est de '.$uploal_limit_MB.'MB.");
                }
            }
        }

        var fileSelected = null;
        
        function addPict(name,ind){
            document.getElementById("img").onchange = function(e) { // will trigger each time
                handleFileDialog(document.getElementById("img").value !== fileSelected);
            };


        
        
            document.getElementById("tp").value=name;
            document.getElementById("ind").value=ind;
            fileSelected = document.getElementById("img").value;
            document.getElementById("img").click();
        }
    </script>
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
    <a class="button" href="consultPerson.php?id='.$id.'">Retour</a><br/>
	<h2> Modification des documents pour un compte '.$typeName.'  Status: '.$statusName.'  </h2>
	<form id="form" enctype="multipart/form-data" action="./updateDocs.php" method="post">
	    <input   type="hidden"  name="id" value="'.$id.'"/>
	    <input   type="hidden" id="tp"  name="tp" value=""/>
	    <input   type="hidden" id="ind" name="ind" value=""/>
        <h3> Informations personnelles  </h3>';
	
	
	
	
	if($type==1) {
	    echo '

	 <span class="fitem">
	   <span class="label" id="lb_name">Nom de la société: '.$Name.'</span>
	 </span>
	';
	} else {
	  echo'

	 <span class="fitem">
	   <span class="label" id="lb_name">Nom: '.$LastName.'</span>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_surname" >Prénom: '.$FirstName.'</span>
	 </span>
	 ';
	
	}
	
	echo'
	 <h3> Documents </h3>';
	 
	 $doc=['Carte d\'Identité'=>[$IdCard]];
	 if($type==1) {
	    $doc=['Carte d\'Identité'=>[$IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12],
	        'Etat Financier'=>[$FinState_1,$FinState_2,$FinState_3],
	        'Registre du commerce'=>[$Registration_1,$Registration_2,$Registration_3]];
	 }
	 
	 $type_dict=['Carte d\'Identité'=>'c','Etat Financier'=>'ef','Registre du commerce'=>'r'];
	 
	 $folder = './Data/img_'.$id.'/';
	 
	 echo '<table>
	            <tr><td>Type</td><td>Miniature</td><td>Action</td></tr>';
	 foreach($doc as $doc_name => $list) {
        $counter=1;
	    foreach($list as $file) {
	        $set = $file!='';
	        echo '<tr><td>'.$doc_name.'-'.$counter.'</td><td>';
	        
	        if ($set){
	          echo '<a href="'.$folder.$file.'" target="_blank">';
	            if (strtolower(substr($file, -4)) === '.pdf'){
	               echo' <img src="css/image/pdf.png" height="100px"/>';
	            } else {
	               echo'<img src="'.$folder.$file.'" height="100px"/>';
	            }
	            echo'</a>';
	        } else {
	            echo 'Pas définit';
	        }
	        
	        echo'</td><td>';
	        
	       
	        
	        if ($set){
	            echo '<a class="button" onClick="addPict(\''. $type_dict[$doc_name].'\','.$counter.')">Remplacer</a>';
	        } else {
	            echo '<a class="button" onClick="addPict(\''. $type_dict[$doc_name].'\','.$counter.')">Ajouter</a>';
	        }
	        
	         if ($counter>1){
	            echo '<a class="button" href="updateDocs.php?id='.$id.'&tp='. $type_dict[$doc_name].'&ind='.$counter.'">Supprimer</a>';
	        } 
	        
	        echo'</td></tr>';
	         $counter++;
	    }
	 }
echo '</table>
<input   type="file" id="img" name="img" accept="application/pdf,image/*" required="required" style="display:none;">
</form>';
	
	


    
echo '   
   </span>
</body>
</html>';
?>
