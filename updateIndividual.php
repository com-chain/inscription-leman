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
   $compl = $_POST['compl'];
   $npa = $_POST['zip'];
   $city = $_POST['city'];
   $country = $_POST['country'];
   
   $membership = $_POST['ad_ass'];
   $acc_req = $_POST['cr_acc'];
   $newsletter = isset($_POST['news'])?1:0;
   
   $pep = intval($_POST['pep']);
   $pepRelated = intval($_POST['peprel']);
  
   $aed = isset($_POST['aed_dec'])?$_POST['aed_dec']:'';
   
   
   $query = "UPDATE Reg_Person set Email=?, Phone=?,
                                    Address=?, AddressComplement=?, NPA=?, City=?, Country=?,
                                    Membership=?, AccountRequest=?, Newsletter=?,
                                    PEP=?, PEPRelated=?, AED=? WHERE Id=?";
   $stmt = $mysqli->prepare($query);
   $stmt->bind_param("ssssssssiiiisi", $email, $phone,
              $address, $compl, $npa, $city, $country,  $membership, $acc_req,
              $newsletter, $pep, $pepRelated, $aed, $id);
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
   


 
 
 // Extention table for private individual
 $first_name = $_POST['surname'];
 $last_name = $_POST['name'];
 $gender = $_POST['gender'];
 $cit = $_POST['cit'];
 $born = $_POST['born'];
  
 $query = "Update Reg_Individual set FirstName=?, LastName=?, Gender=?, Citizenship=?, BirthDate=? Where Id=?";
 $stmt = $mysqli->prepare($query);
 $stmt->bind_param("sssssi",$first_name,$last_name,$gender,$cit,$born,$id);
 if (! $stmt->execute()) {
      echo("Error description: " . $mysqli -> error);
 }
 $stmt->close();
 
 
header('Location: ./consultPerson.php?id='.$id);
     
   
?>
