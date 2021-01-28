<?php
ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

   $id = $_POST['id'];
   // Table Person:
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
   $acc_req = $_POST['cr_acc'];
   $newsletter = isset($_POST['news'])?1:0;
   
   $pep = intval($_POST['pep']);
   $pepRelated = intval($_POST['peprel']);
  
   $aed = $_POST['aed_dec'];
   
   
   $query = "UPDATE Reg_Person set Email=?, Phone=?,
                                    Address=?, AddressComplement=?,NPA=?, City=?, Country=?,
                                    PostalAddress=?, PostalAddressComplement=?, PostalNPA=?, PostalCity=?, PostalCountry=?,
                                    Membership=?, AccountRequest=?, Newsletter=?,
                                    PEP=?, PEPRelated=?, AED=? WHERE Id=?";
   $stmt = $mysqli->prepare($query);
   $stmt->bind_param("ssssssssssssssiiisi", $email, $phone,
              $address, $compl_add, $npa, $city, $country, 
              $post_address,$post_compl_add, $post_npa, $post_city, $post_country,
              $membership, $acc_req, $newsletter, $pep, $pepRelated, $aed, $id);
   if (! $stmt->execute()) {
      echo("Error description: " . $mysqli -> error);
   } 
   $stmt->close(); 
     
   for ($aed_id=1; $aed_id<5; $aed_id++){
        if (isset($_POST['aed_'.$aed_id.'_name']) && $_POST['aed_'.$aed_id.'_name']!=''){
            $aed_name = $_POST['aed_'.$aed_id.'_surname'];
            $aed_lastname = $_POST['aed_'.$aed_id.'_name'];
            $aed_address = $_POST['aed_'.$aed_id.'_add'];
            $aed_compl = $_POST['aed_'.$aed_id.'_compl'];
            

            $aed_zip = $_POST['aed_'.$aed_id.'_zip'];
            $aed_city = $_POST['aed_'.$aed_id.'_city'];
            $aed_country = $_POST['aed_'.$aed_id.'_country'];
            $aed_cit = $_POST['aed_'.$aed_id.'_cit'];
            if (isset($_POST['aed_'.$aed_id.'_born']) && $_POST['aed_'.$aed_id.'_born']!=''){
                $aed_birth = $_POST['aed_'.$aed_id.'_born'];
            } else {
                $aed_birth = NULL;
            }
            
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
             $stmt->bind_param("sssssssssi",$aed_name,$aed_lastname,$aed_address,$aed_compl,$aed_zip,$aed_city,$aed_country,$aed_cit,$aed_birth,$id);
             if (! $stmt->execute()) {
                 
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
                  // DEBUG:
                  echo("Error description: " . $mysqli -> error);
             }
             $stmt->close();
          
     
        }
      
    }
   


 
 
 // Extention table for company
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
  
 $query = "Update Reg_Legal set Name=?, RefName=?, Contact=?, ContactSurname=?, ContactGender=?, LegalForm=?, CreationDate=?, ActivityField=?, ActivityFieldSeg=?, ActivityDescription=?, Website=?, EFT=? Where Id=?";
    $stmt = $mysqli->prepare($query);
 $stmt->bind_param("sssssssssssdi",$name,$RefName,$contact,$ContactSurname, $cont_gender, $legalForm,$creationDate,$activityField, $ActivityFieldSeg,$activitydesc,$Website,$eft,$id);

  if (! $stmt->execute()) {
      echo("Error description: " . $mysqli -> error);
 }
 $stmt->close();
 
   
  //Add ST
     $ok = true;
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
            
            
            if (!isset($st_birth) || $st_birth==''){
                $st_birth = NULL;
            }

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
             $stmt->bind_param("sssssssssi",$st_name,$st_lastname,$st_address,$st_compl,$st_zip,$st_city,$st_country,$st_cit,$st_birth,$id);
             if (! $stmt->execute()) {
                 $ok=false;
                  echo '<h3> Une erreur s\'est produite lors du traitement de votre demande. </h3>';
                  // DEBUG:
                  echo("Error description: " . $mysqli -> error);
  
             }
             $stmt->close();
     
        }
      
    }
   
 
 
header('Location: ./consultPerson.php?id='.$id);
     
   
?>
