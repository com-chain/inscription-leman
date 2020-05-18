<?php
ob_start();
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';

  
  
	


// Handle the post
 if (isset($_POST['name'])){
 
 
   $AccountRequest = $_POST['cr_acc'];
 
 
 
 
    makeHead($AccountRequest);
    echo'  
      </head>
    <body>';


    echo '
    <span class="fond"></span>
    <span class="cont">
    
     <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> <br/>';
    if ($AccountRequest==0) {
        echo '<h2> Association Monnaie Léman: adhésion - Particulier </h2><br/>';
    } else {
        echo '<h2> Ouverture de compte en Léman électronique - Particulier </h2><br/>';
   }

   // Table Person:
   $recordTypeId = 2; //Individual
   $statusId = 1; //submitted
   $email = $_POST['mail'];
   $phone = $_POST['phone'];
   $address = $_POST['street'];
   $compl = $_POST['compl'];
   $npa = $_POST['zip'];
   $city = $_POST['city'];
   $country = $_POST['country'];
   
   $membership = $_POST['ad_ass'];
   $dataUsge = isset($_POST['data'])?1:0;
   $newsletter = isset($_POST['news'])?1:0;
   $finma = isset($_POST['lb_cond'])?1:0;
   
   $cgu = isset($_POST['cgu'])?1:0;
   $charte = isset($_POST['ce'])?1:0;
   if ($AccountRequest==0) {
        $cgu = isset($_POST['cgu_0'])?1:0;
        $charte = isset($_POST['ce_0'])?1:0;
   } 
   $engagment = isset($_POST['eng'])?1:0;
   $attestation = isset($_POST['att'])?1:0;

   $pep = intval($_POST['pep']);
   $pepRelated = intval($_POST['peprel']);
  
   $aed = $_POST['aed_dec'];
   
  

  
 
      include 'connectionFactory.php';
      $mysqli= ConnectionFactory::GetConnection();
      
      $query = "INSERT INTO Reg_Person (RecordTypeId, StatusId, Email, Phone,
                                    Address, AddressComplement, NPA, City, Country,
                                    Membership,AccountRequest, DataUsage, Newsletter,
                                    PEP, PEPRelated, FINMA, AED,
                                    CGU, Charte, Engagment,Attestation) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $person_id = -1;
      $ok =true;
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param("iissssssssiiiiiisiiii", $recordTypeId, $statusId, $email, $phone,
              $address, $compl, $npa, $city, $country,  $membership,$AccountRequest,
              $dataUsge, $newsletter, $pep, $pepRelated, $finma,
              $aed,$cgu, $charte, $engagment, $attestation);
     if (! $stmt->execute()) {
      $ok=false;
      echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
      // DEBUG:
      echo("Error description: " . $mysqli -> error);

     } else {
        $person_id = $mysqli->insert_id;
     }
     $stmt->close(); 
     
       //Add AED
     for ($aed_id=1; $aed_id<5; $aed_id++){
        if ($ok && isset($_POST['aed_'.$aed_id.'_name']) && $_POST['aed_'.$aed_id.'_name']!=''){
            $aed_name = $_POST['aed_'.$aed_id.'_surname'];
            $aed_lastname = $_POST['aed_'.$aed_id.'_name'];
            $aed_address = $_POST['aed_'.$aed_id.'_add'];
            $aed_compl = $_POST['aed_'.$aed_id.'_compl'];
            $aed_zip = $_POST['aed_'.$aed_id.'_zip'];
            $aed_city = $_POST['aed_'.$aed_id.'_city'];
            $aed_country = $_POST['aed_'.$aed_id.'_country'];
            $aed_cit = $_POST['aed_'.$aed_id.'_cit'];
            $aed_birth = $_POST['aed_'.$aed_id.'_born'];
            
            $query = "UPDATE Reg_Person SET AED_".$aed_id."_FirstName=?  ,
                                        AED_".$aed_id."_LastName=?  ,
                                        AED_".$aed_id."_Address=?  ,
                                        AED_".$aed_id."_AddressComplement=?  ,
                                        AED_".$aed_id."_NPA=?  ,
                                        AED_".$aed_id."_City=?  ,
                                        AED_".$aed_id."_Country=?  ,
                                        AED_".$aed_id."_Citizenship=? ,
                                        AED_".$aed_id."_BirthDate=? 
                      WHERE Id=?";
          
             $stmt = $mysqli->prepare($query);
             $stmt->bind_param("sssssssssi",$aed_name,$aed_lastname,$aed_address,$aed_compl,$aed_zip,$aed_city,$aed_country,$aed_cit,$aed_birth,$person_id);
             if (! $stmt->execute()) {
                 $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
                  // DEBUG:
                  echo("Error description: " . $mysqli -> error);
             }
             $stmt->close();
          
     
        }
      
    }
   
  
     
     
     
     // Create image folder and save image
     if ($ok){
          $new_path = './Data/img_'.$person_id;
          $ok &= mkdir($new_path);
          $file = fopen( $new_path."/index.html", 'w');
          fclose($file);
     } 
     
     $new_file_name='';
     if ($ok && $AccountRequest==1){
          $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
          $new_file_name = uniqid('img_').'.'.$ext;
          $new_file =  $new_path.'/'.$new_file_name;
          if(!move_uploaded_file($_FILES['img']['tmp_name'], $new_file)){
              $ok=false;
              echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
          }
     }
     // Extention table for private individual
     $first_name = $_POST['surname'];
     $last_name = $_POST['name'];
     $gender = $_POST['gender'];
     $cit = $_POST['cit'];
     $born = $_POST['born'];
      
     $query = "INSERT INTO Reg_Individual (Id, FirstName, LastName, Gender, Citizenship, BirthDate, IdCard) VALUES (?,?,?,?,?,?,?)";
     
     if ($ok){
         $stmt = $mysqli->prepare($query);
         $stmt->bind_param("issssss",$person_id,$first_name,$last_name,$gender,$cit,$born,$new_file_name);
         if (! $stmt->execute()) {
             $ok=false;
              echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              // DEBUG:
              echo("Error description: " . $mysqli -> error);
         }
         $stmt->close();
     }
     
     
     
       //// Code if needed
      if ($ok && $AccountRequest==1) {
         $code=md5($person_id.$last_name.$first_name);
         $query = "INSERT INTO Reg_Code (PersonId,Code) VALUES (?,?)";
         $stmt = $mysqli->prepare($query);
         $stmt->bind_param("is",$person_id,$code);
         if (! $stmt->execute()) {
             $ok=false;
              echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
         }
         $stmt->close();
      }
     
     
     // audit
     
     $query = "INSERT INTO Reg_StatusHistory (PersonId, NewStatusId, EventDate ) VALUES (?,?,now())";
     if ($ok){
         $stmt = $mysqli->prepare($query);
         $stmt->bind_param("ii",$person_id, $statusId);
          if (! $stmt->execute()) {
             $ok=false;
              echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              // DEBUG:
              echo("Error description: " . $mysqli -> error);
         }
         $stmt->close(); 
     } 
     if ($ok){
     
        if ($AccountRequest==1)  {
         // todo mail
        
         echo ' <h3  class="center_msg"> Demande d’ouverture de compte pour PARTICULIER 
envoyée avec succès. </h3>
         <form id="form" action="pdf.php" method="post">
           <span class="labelWide">Nous vous avons envoyé un email contenant votre code d\'ouverture de compte et une marche à suivre pour l\'utiliser. Vous pouvez aussi directement télécharger ce document ci-dessous: </span>
          <input   type="hidden"  name="code" value="'.$code.'" />
          <input   type="submit" class="big_button" value="Code d\'ouverture de compte" style="width:300px;margin-right:calc( 50% - 160px);margin-left:calc( 50% - 160px);"/><br/>
        </form>
';
        } else {
         echo ' <h3  class="center_msg">Demande d’adhésion pour PARTICULIER
envoyée avec succès.<br/>
Nous revenons vers vous au plus vite. </h3>';
        }
        echo '  <br/>
 <h3 class="center_msg">Merci de votre engagement pour une économie circulaire !
 </h3>';
     }
   
 }


    
echo '   
   </span>
</body>
</html>';
?>
