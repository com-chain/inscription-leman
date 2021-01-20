<?php
ob_start();
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
include 'p_mail.php';


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
    
     <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> <br/>
     ';
    if ($AccountRequest==0) {
        echo '<h2> Association Monnaie Léman: adhésion - Entreprise </h2><br/>';
    } else {
        //echo '<h2> Ouverture de compte en Léman électronique - Entreprise </h2><br/>';
   }

   // Table Person:
   $recordTypeId = 1; //Entreprise
   $statusId = 1; //submitted
   $email = $_POST['mail'];
   $phone = $_POST['phone'];
   $address = $_POST['street'];
   $compl_add = $_POST['compl'];
   $npa = $_POST['zip'];
   $city = $_POST['city'];
   $country = $_POST['country'];
   
   $post_address = $_POST['p_street'];
   $post_compl_add = $_POST['p_compl'];
   $post_npa = $_POST['p_zip'];
   $post_city = $_POST['p_city'];
   $post_country = $_POST['p_country'];
   
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
                                    PostalAddress,PostalAddressComplement, PostalNPA, PostalCity, PostalCountry,
                                    Membership, AccountRequest, DataUsage, Newsletter,
                                    PEP, PEPRelated, FINMA, AED,
                                    CGU, Charte, Engagment,Attestation) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $person_id = -1;
      $ok =true;
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param("iisssssssssssssiiiiiisiiii", $recordTypeId, $statusId, $email, $phone,
              $address, $compl_add, $npa, $city, $country,  $post_address, $post_compl_add, $post_npa, $post_city, $post_country, $membership,$AccountRequest,
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
   
  
     
     
     
     // Create image folder and save images
     if ($ok){
          $new_path = './Data/img_'.$person_id;
          $ok &= mkdir($new_path);
          $file = fopen( $new_path."/index.html", 'w');
          fclose($file);
     } 
     $img_c=[null,null,null,null,null,null];
     for ($img_id=1;$img_id<13;$img_id++){
         if ($ok && isset($_FILES['img_c'.$img_id]) && isset($_FILES['img_c'.$img_id]['name'])&& $_FILES['img_c'.$img_id]['name']!=''){
              $ext = pathinfo($_FILES['img_c'.$img_id]['name'], PATHINFO_EXTENSION);
              $new_file_name = uniqid('img_c_').'.'.$ext;
              $new_file =  $new_path.'/'.$new_file_name;
              if(!move_uploaded_file($_FILES['img_c'.$img_id]['tmp_name'], $new_file)){
                  $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              }
              $img_c[$img_id-1]=$new_file_name;
         }
     }
     
     $img_ef=[null,null,null];
     for ($img_id=1;$img_id<4;$img_id++){
         if ($ok && isset($_FILES['img_ef'.$img_id]) && isset($_FILES['img_ef'.$img_id]['name'])&& $_FILES['img_ef'.$img_id]['name']!=''){
              $ext = pathinfo($_FILES['img_ef'.$img_id]['name'], PATHINFO_EXTENSION);
              $new_file_name = uniqid('img_ef_').'.'.$ext;
              $new_file =  $new_path.'/'.$new_file_name;
              if(!move_uploaded_file($_FILES['img_ef'.$img_id]['tmp_name'], $new_file)){
                  $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              }
              $img_ef[$img_id-1]=$new_file_name;
         }
     }
     $img_r=[null,null,null];
     for ($img_id=1;$img_id<4;$img_id++){
     
         if ($ok && isset($_FILES['img_r'.$img_id]) && isset($_FILES['img_r'.$img_id]['name'])&& $_FILES['img_r'.$img_id]['name']!=''){
              $ext = pathinfo($_FILES['img_r'.$img_id]['name'], PATHINFO_EXTENSION);
              $new_file_name = uniqid('img_r_').'.'.$ext;
              $new_file =  $new_path.'/'.$new_file_name;
              if(!move_uploaded_file($_FILES['img_r'.$img_id]['tmp_name'], $new_file)){
                  $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              }
              $img_r[$img_id-1]=$new_file_name;
         }
     }
     // Extention table for legal
     $name = $_POST['name'];
     $RefName = $_POST['RefName'];
     $contact = $_POST['contact'];
     $ContactSurname = $_POST['ContactSurname'];
     $cont_gender = $_POST['cont_gender'];
     $legalForm = $_POST['kind'];
     $creationDate = $_POST['created_on'];
     $activityField = $_POST['fieldActivity'];
     $ActivityFieldSeg = $_POST['ActivityFieldSeg'];
     $activitydesc = $_POST['activityDesc'];
     $Website = $_POST['www'];
     $eft = (float)$_POST['ETP'];
      
     $query = "INSERT INTO Reg_Legal (Id, Name, RefName,Contact, ContactSurname, ContactGender,LegalForm, CreationDate, 
                                  ActivityField, ActivityFieldSeg,ActivityDescription, Website, EFT,
                                  IdCard_1, IdCard_2, IdCard_3, IdCard_4, IdCard_5, IdCard_6,
                                  IdCard_7, IdCard_8, IdCard_9, IdCard_10, IdCard_11, IdCard_12,
                                  FinState_1, FinState_2, FinState_3,
                                  Registration_1, Registration_2, Registration_3 ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
     
     if ($ok){
         $stmt = $mysqli->prepare($query);
         $stmt->bind_param("isssssssssssdssssssssssssssssss",$person_id,$name,$RefName,$contact,$ContactSurname,$cont_gender,$legalForm,$creationDate,
                            $activityField,$ActivityFieldSeg,$activitydesc,$Website, $eft,
                            $img_c[0],$img_c[1],$img_c[2],$img_c[3],$img_c[4],$img_c[5],
                            $img_c[6],$img_c[7],$img_c[8],$img_c[9],$img_c[10],$img_c[11],
                            $img_ef[0],$img_ef[1],$img_ef[2],
                            $img_r[0],$img_r[1],$img_r[2]
                            );
         if (! $stmt->execute()) {
             $ok=false;
              echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
              // DEBUG:
              echo("Error description: " . $mysqli -> error);
         }
         $stmt->close();
     }
     
     
     
        //Add ST
     for ($st_id=1; $st_id<5; $st_id++){
        if ($ok && isset($_POST['st_'.$st_id.'_name']) && $_POST['st_'.$st_id.'_name']!=''){
            $st_name = $_POST['st_'.$st_id.'_surname'];
            $st_lastname = $_POST['st_'.$st_id.'_name'];
            $st_address = $_POST['st_'.$st_id.'_add'];
            $st_compl = $_POST['st_'.$st_id.'_compl'];
            $st_zip = $_POST['st_'.$st_id.'_zip'];
            $st_city = $_POST['st_'.$st_id.'_city'];
            $st_country = $_POST['st_'.$st_id.'_country'];
            $st_cit = $_POST['st_'.$st_id.'_cit'];
            $st_birth = $_POST['st_'.$st_id.'_born'];
            
            $query = "UPDATE Reg_Legal SET ST_".$st_id."_FirstName=?  ,
                                        ST_".$st_id."_LastName=?  ,
                                        ST_".$st_id."_Address=?  ,
                                        ST_".$st_id."_AddressComplement=?  ,
                                        ST_".$st_id."_NPA=?  ,
                                        ST_".$st_id."_City=?  ,
                                        ST_".$st_id."_Country=?  ,
                                        ST_".$st_id."_Citizenship=? ,
                                        ST_".$st_id."_BirthDate=? 
                      WHERE Id=?";
          
             $stmt = $mysqli->prepare($query);
             $stmt->bind_param("sssssssssi",$st_name,$st_lastname,$st_address,$st_compl,$st_zip,$st_city,$st_country,$st_cit,$st_birth,$person_id);
             if (! $stmt->execute()) {
                 $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
             }
             $stmt->close();
          
     
        }
      
    }
    
    
    //// Code if needed
      if ($ok && $AccountRequest==1) {
         $code=md5($person_id.$name);
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
            // generate pdf 
            include 'pdf_builder.php';
            getPDF($code, $mysqli, true);
            sendConfirmationMail($email, './Data/img_'.$person_id.'/Code_'.$code.'.pdf' , $name , 1);

            
            echo '<h3  class="center_msg"> BRAVO! VOUS AVEZ TERMINÉ LA PREMIÈRE PHASE AVEC SUCCÈS. </h3>';
            echo '<h3  class="center_msg"> DEUXIÈME PHASE: CRÉEZ VOTRE COMPTE! </h3>';
            echo '<h3  class="center_msg"> VOUS VENEZ DE RECEVOIR PAR E-MAIL VOTRE "CODE D\'AUTORISATION". </h3>';
            
           /* echo ' <h3 class="center_msg"> Demande d’ouverture de compte pour ENTREPRISE 
envoyée avec succès.</h3>
         <form id="form" action="pdf.php" method="post" target="_blank">
           <span class="labelWide">Nous vous avons envoyé un email contenant votre code d\'ouverture de compte et une marche à suivre pour l\'utiliser. Vous pouvez aussi directement télécharger ce document ci-dessous: </span>
          <input   type="hidden"  name="code" value="'.$code.'" />
         <input   type="submit" target="_blank" class="big_button" value="Code d\'ouverture de compte" style="width:300px;margin-right:calc( 50% - 160px);margin-left:calc( 50% - 160px);"/><br/> 
         <a   target="_blank" class="big_button" href="'.$how_to_file.'" style="width:260px !important;margin-right:calc( 50% - 160px);margin-left:calc( 50% - 160px);">Marche à suivre</a><br/>
        </form>';*/
        } else {
         echo ' <h3 class="center_msg">Demande d’adhésion pour ENTREPRISE
envoyée avec succès.<br/>
Nous revenons vers vous au plus vite. </h3>';
        }
        echo '<br/>
 <br/><br/>
 
 Pour mes dépenses personnelles ou pour recevoir un salaire, j’ouvre un compte <a class="" href="./individual.php">PARTICULIER</a> également.';
     }
 }  
 


    
echo '   
   </span>
</body>
</html>';
?>
