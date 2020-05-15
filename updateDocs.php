<?php

ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

if(isset($_GET['id'])){
 
    $id=$_GET['id'];
} else {
    $id=$_POST['id'];
}

$query = 'SELECT 
	          RecordTypeId,
              Reg_Individual.IdCard,
	          
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
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            
	            
	          WHERE Reg_Person.Id = ?';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($type, $IdCard,
                       $IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12, $FinState_1,$FinState_2,$FinState_3,$Registration_1,$Registration_2,$Registration_3);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	
    
    $cards=[$IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
            $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12];
    $fs=[$FinState_1,$FinState_2,$FinState_3];
    $rs=[$Registration_1,$Registration_2,$Registration_3];

    $folder = './Data/img_'.$id.'/';
if (isset($_GET['id']) && isset($_GET['tp']) && isset($_GET['ind'])){
    $file_to_delete='';
    $field='';

    if ($type==1){
        if ($_GET['tp']=='c'){
            $field='IdCard_'.$_GET['ind'];
            $file_to_delete=$cards[$_GET['ind']-1];
        } else if ($_GET['tp']=='ef'){
            $field='FinState_'.$_GET['ind'];
            $file_to_delete=$fs[$_GET['ind']-1];
        } else if ($_GET['tp']=='r'){
            $field='Registration_'.$_GET['ind'];
            $file_to_delete=$rs[$_GET['ind']-1];
        }
        if ($file_to_delete!=''){
            $query = 'UPDATE Legal set '.$field.'="" WHERE Id=?';
            $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("i",$id); 
	        $stmt->execute();
            $stmt->close();	
            
            unlink($folder.$file_to_delete);
        }
    } else {
      // not permitted  
    }
    
}

if (isset($_POST['id']) && isset($_POST['tp']) && isset($_POST['ind'])){
      $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
      $new_file_name = uniqid('img_'.$_POST['tp'].'_').'.'.$ext;
      $new_file =  $folder.$new_file_name;
      move_uploaded_file($_FILES['img']['tmp_name'], $new_file);
      if ($type==1){
        if ($_POST['tp']=='c'){
            $field='IdCard_'.$_POST['ind'];
            $file_to_delete=$cards[$_POST['ind']-1];
        } else if ($_POST['tp']=='ef'){
            $field='FinState_'.$_POST['ind'];
            $file_to_delete=$fs[$_POST['ind']-1];
        } else if ($_POST['tp']=='r'){
            $field='Registration_'.$_POST['ind'];
            $file_to_delete=$rs[$_POST['ind']-1];
        }
        if ($file_to_delete!=''){
            unlink($folder.$file_to_delete);
        }
        $query = 'UPDATE Reg_Legal set '.$field.'=? WHERE Id=?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si",$new_file_name,$id); 
        $stmt->execute();
        $stmt->close();	
    } else {
      if ($IdCard!=''){
          unlink($folder.$IdCard);
      }
      $query = 'UPDATE Reg_Individual set IdCard=? WHERE Id=?';
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param("si",$new_file_name,$id); 
      $stmt->execute();
      $stmt->close();	
    }             
}
header('Location: ./docs.php?id='.$id);
?>
