<?php
    ob_start();
    include 'checkUser.php';
    include 'connectionFactory.php';
    $mysqli= ConnectionFactory::GetConnection();
    require_once('ripcord/ripcord.php');
  
    if (isset($_GET['id'])){
        $id=(int)$_GET['id'];
        
    $query = 'SELECT 
        Reg_RecordType.Id,
        Reg_RecordType.Name, 
        Reg_Status.Id,
        Reg_Status.Name,

        Email,
        Phone,

        Address,
        AddressComplement,
        NPA,
        City,
        Country,

        PostalAddress,
        PostalAddressComplement,
        PostalNPA ,
        PostalCity ,
        PostalCountry ,

        Membership,
        AccountRequest,
        Newsletter,

        PEP,
        PEPRelated,

        AED,

        AED_1_FirstName,
        AED_1_LastName,
        AED_1_Address,
        AED_1_AddressComplement,
        AED_1_NPA,
        AED_1_City,
        AED_1_Country,
        AED_1_Citizenship,
        AED_1_BirthDate ,


        AED_2_FirstName,
        AED_2_LastName,
        AED_2_Address,
        AED_2_AddressComplement,
        AED_2_NPA,
        AED_2_City,
        AED_2_Country,
        AED_2_Citizenship,
        AED_2_BirthDate ,

        AED_3_FirstName,
        AED_3_LastName,
        AED_3_Address,
        AED_3_AddressComplement,
        AED_3_NPA,
        AED_3_City,
        AED_3_Country,
        AED_3_Citizenship,
        AED_3_BirthDate ,


        AED_4_FirstName,
        AED_4_LastName,
        AED_4_Address,
        AED_4_AddressComplement,
        AED_4_NPA,
        AED_4_City,
        AED_4_Country,
        AED_4_Citizenship,
        AED_4_BirthDate ,

        Reg_Individual.FirstName, 
        Reg_Individual.LastName, 
        Reg_Individual.Gender,
        Reg_Individual.Citizenship,
        Reg_Individual.BirthDate,
        Reg_Individual.IdCard,

        Reg_Legal.Name,
        Reg_Legal.RefName,
        Reg_Legal.Contact,
        Reg_Legal.ContactSurname,
        Reg_Legal.ContactGender,
        Reg_Legal.LegalForm,
        Reg_Legal.CreationDate,
        Reg_Legal.ActivityField,
        Reg_Legal.ActivityFieldSeg,
        Reg_Legal.ActivityDescription,
        Reg_Legal.EFT,
        Reg_Legal.Website,

        ST_1_FirstName,
        ST_1_LastName,
        ST_1_Address,
        ST_1_AddressComplement,
        ST_1_NPA,
        ST_1_City,
        ST_1_Country,
        ST_1_Citizenship,
        ST_1_BirthDate ,


        ST_2_FirstName,
        ST_2_LastName,
        ST_2_Address,
        ST_2_AddressComplement,
        ST_2_NPA,
        ST_2_City,
        ST_2_Country,
        ST_2_Citizenship,
        ST_2_BirthDate ,

        ST_3_FirstName,
        ST_3_LastName,
        ST_3_Address,
        ST_3_AddressComplement,
        ST_3_NPA,
        ST_3_City,
        ST_3_Country,
        ST_3_Citizenship,
        ST_3_BirthDate ,


        ST_4_FirstName,
        ST_4_LastName,
        ST_4_Address,
        ST_4_AddressComplement,
        ST_4_NPA,
        ST_4_City,
        ST_4_Country,
        ST_4_Citizenship,
        ST_4_BirthDate ,


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
        Reg_Legal.Registration_3,

        Notes

        FROM Reg_Person 
            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
        WHERE Reg_Person.Id = ?';
              
              
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->bind_result($type,$typeName,$status,$statusName,$mail,$phone,
                       $address,$addressComplement,$NPA,$city,$count,
                       $p_address,$p_addressComplement,$p_NPA,$p_city,$p_country,
                       $membership ,$acc_req ,$newsletter,$PEP,$PEPRelated,$aed,
                       $AED_1_FirstName,$AED_1_LastName,$AED_1_Address,$AED_1_ComplAddress, $AED_1_ZIP, $AED_1_City, $AED_1_Country, $AED_1_Citizenship,$AED_1_BirthDate,
                       $AED_2_FirstName,$AED_2_LastName,$AED_2_Address,$AED_2_ComplAddress, $AED_2_ZIP, $AED_2_City, $AED_2_Country, $AED_2_Citizenship,$AED_2_BirthDate,
                       $AED_3_FirstName,$AED_3_LastName,$AED_3_Address,$AED_3_ComplAddress, $AED_3_ZIP, $AED_3_City, $AED_3_Country, $AED_3_Citizenship,$AED_3_BirthDate,
                       $AED_4_FirstName,$AED_4_LastName,$AED_4_Address,$AED_4_ComplAddress, $AED_4_ZIP, $AED_4_City, $AED_4_Country, $AED_4_Citizenship,$AED_4_BirthDate,
                       $FirstName,$LastName,$Gender,$Citizenship,$BirthDate,$IdCard,
                       $Name,$RefName, $Contact, $ContactSurname, $ContactGender,$LegalForm,$CreationDate,$ActivityField,$ActivityFieldSeg,$ActivityDescription,$EFT,$site,
                       
                       
                       $ST_1_FirstName,$ST_1_LastName,$ST_1_Address,$ST_1_ComplAddress, $ST_1_ZIP, $ST_1_City, $ST_1_Country, $ST_1_Citizenship,$ST_1_BirthDate,
                       $ST_2_FirstName,$ST_2_LastName,$ST_2_Address,$ST_2_ComplAddress, $ST_2_ZIP, $ST_2_City, $ST_2_Country, $ST_2_Citizenship,$ST_2_BirthDate,
                       $ST_3_FirstName,$ST_3_LastName,$ST_3_Address,$ST_3_ComplAddress, $ST_3_ZIP, $ST_3_City, $ST_3_Country, $ST_3_Citizenship,$ST_3_BirthDate,
                       $ST_4_FirstName,$ST_4_LastName,$ST_4_Address,$ST_4_ComplAddress, $ST_4_ZIP, $ST_4_City, $ST_4_Country, $ST_4_Citizenship,$ST_4_BirthDate,
                       
                       
                       
                       $IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12,
                       $FinState_1,$FinState_2,$FinState_3,$Registration_1,$Registration_2,$Registration_3,
                       $Notes);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close(); 


    // code et comptes
    
    $query = 'SELECT Code, address fROM Reg_Wallet LEFT OUTER JOIN Reg_Code ON Reg_Code.Id=Reg_Wallet.CodeId WHERE Reg_Wallet.PersonId=?';
              
              
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->bind_result($code,$add);
    $stmt->execute();
    $wallets='';
    while($stmt->fetch()){
            if ($wallets!=''){
             $wallets=$wallets.', ';
            }
            $wallets=$wallets.$code.'-'.$add;
    }
    $stmt->close();
    
    $query = 'SELECT Code fROM Reg_Code  LEFT OUTER JOIN Reg_Wallet ON Reg_Code.Id=Reg_Wallet.CodeId WHERE Reg_Code.PersonId=?  and Reg_Wallet.CodeId IS NULL';
              
              
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->bind_result($code);
    $stmt->execute();
    while($stmt->fetch()){
            if ($wallets!=''){
             $wallets=$wallets.', ';
            }
            $wallets=$wallets.$code;
    }
    $stmt->close();

    $array_legal_status['CH-Association'] = "CH - Association";
    $array_legal_status['CH-Coopérative'] = "CH - Coopérative";
    $array_legal_status['CH-Fondation'] = "CH - Fondation";
    $array_legal_status['CH-Raison individuelle'] = "CH - Raison individuelle";
    $array_legal_status['CH-SNC'] = "CH - Société en nom collectif (SNC)";
    $array_legal_status['CH-Sàrl'] = "CH - Société à responsabilité limitée (Sàrl)";
    $array_legal_status['CH-SA'] = "CH - Société anonyme (SA)";
    $array_legal_status['CH-Société en commandite'] = "CH - Société en commandite";
    $array_legal_status['FR-Association'] = "FR - Association";
    $array_legal_status['FR-EI'] = "FR - Entreprise individuelle (EI)";
    $array_legal_status['FR-EIRL'] = "FR - Entreprise individuelle à responsabilité limitée (EIRL)";
    $array_legal_status['FR-EURL'] = "FR - Entreprise unipersonnelle à responsabilité limitée (EURL)";
    $array_legal_status['FR-EARL'] = "FR - Exploitation agricole à responsabilité limitée (EARL)";
    $array_legal_status['FR-SARL'] = "FR - Société à responsabilité limitée (SARL)";
    $array_legal_status['FR-SA'] = "FR - Société anonyme (SA)";
    $array_legal_status['FR-SAS'] = "FR - Société par actions simplifiée (SAS)";
    $array_legal_status['FR-SASU'] = "FR - Société par actions simplifiée unipersonnelle (SASU)";
    $array_legal_status['FR-SNC'] = "FR - Société en nom collectif (SNC)";
    $array_legal_status['FR-SCOP'] = "FR - Société coopérative de production (SCOP)";
    $array_legal_status['FR-SCIC'] = "FR - Société coopérative d’intérêt collectif (SCIC)";
    $array_legal_status['FR-SCA'] = "FR - Société en commandite par actions (SCA)";
    $array_legal_status['FR-SCS'] = "FR - Société en commandite simple (SCS)";
    $array_legal_status['FR-SCP'] = "FR - Société civile professionnelle (SCP)";
    $array_legal_status['FR-SCM'] = "FR - Société civile de moyens (SCM)";
    $array_legal_status['FR-SCI'] = "FR - Société civile immobilière (SCI)";
    $array_legal_status['FR-Mutuelle'] = "FR - Mutuelle";
    $array_legal_status['FR-Fondation'] = "FR - Fondation";

    $array_activity['ActivitésCitoyennesAdvocacy'] = "Activités Citoyennes & Advocacy";
    $array_activity['AdministratifAudit'] = "Administratif & Audit";
    $array_activity['AgricultureProducteurs'] = "Agriculture & Producteurs";
    $array_activity['AlimentationEpicerie'] = "Alimentation & Epicerie";
    $array_activity['Artisanat'] = "Artisanat";
    $array_activity['BarRestauration'] = "Bar & Restauration";
    $array_activity['CommunicationGraphismeDessinImpression'] = "Communication - Graphisme - Dessin - Impression";
    $array_activity['Culture'] = "Culture";
    $array_activity['EducationFormation'] = "Education & Formation";
    $array_activity['Energie'] = "Energie";
    $array_activity['Événementiel'] = "Événementiel";
    $array_activity['FournituresEquipement'] = "Fournitures & Equipement";
    $array_activity['HabillementBeauté'] = "Habillement & Beauté";
    $array_activity['HumanitaireCaritatif'] = "Humanitaire & Caritatif";
    $array_activity['InformatiqueElectronique'] = "Informatique& Electronique";
    $array_activity['LogementConstruction'] = "Logement & Construction";
    $array_activity['MobilitéTransport'] = "Mobilité & Transport";
    $array_activity['NettoyageGestionDéchets'] = "Nettoyage & Gestion déchets";
    $array_activity['PresseMédias'] = "Presse & Médias";
    $array_activity['RéparationSAV'] = "Réparation & SAV";
    $array_activity['SantéBienêtre'] = "Santé & Bien-être";
    $array_activity['Services'] = "Services";
    $array_activity['TourismeLoisirs'] = "Tourisme & Loisirs";


    $url = "https://leman-en-transition.org";
    $db = "myOdooDb";
    $username = "myOdooUser";
    $password = "myOdooPassword";

    $common = ripcord::client("$url/xmlrpc/2/common");
    $common->version();

    $uid = $common->authenticate($db, $username, $password, array());

    $models = ripcord::client("$url/xmlrpc/2/object");

    //avoid multiple import, uncomment when connecting to prod
    $search_odoo_id = $models->execute_kw($db, $uid, $password,
        'res.partner', 'search', array(
            array(array('leman_inscription_id', '=', $id))));
    if (count($search_odoo_id) >= 1){
        exit("Déjà exporté");
    }

    //format Gender
    if ($Gender == 'Masculin'){
        $Gender_odoo = 'male';
    } elseif ($Gender == 'Feminin'){
        $Gender_odoo = 'female';
    } elseif ($Gender == 'Autre'){
        $Gender_odoo = 'other';
    } else {
        $Gender_odoo = False;
    }
    if ($ContactGender == 'Masculin'){
        $ContactGender_odoo = 'male';
    } elseif ($ContactGender == 'Feminin'){
        $ContactGender_odoo = 'female';
    } elseif ($ContactGender == 'Autre'){
        $ContactGender_odoo = 'other';
    } else {
        $ContactGender_odoo = False;
    }

    // format PEP
    if ($PEP == 1){
        $PEP_odoo = True;
    } else{
        $PEP_odoo = False;
    }
    if ($PEPRelated == 1){
        $PEPRelated_odoo = True;
    } else{
        $PEPRelated_odoo = False;
    }

    if ($wallets!=''){
        $electronic_account_odoo = True;
    } else {
        $electronic_account_odoo = False;
    }

    //quick an dirty, if it happens again with another date, improve with Datetime lib
    if ($CreationDate == "1000-01-01"){
        $CreationDate = False;
    }

    if ($newsletter == 1){
        $odoo_search_mailing_list_id = $models->execute_kw($db, $uid, $password,
            'mail.mass_mailing.list', 'search_read',
            array(array(array('name', 'like', 'Newsletter mensuelle'))),
            array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
        $newsletter_list_odoo = $odoo_search_mailing_list_id[0]['id'] or False;
    }

    $odoo_search_nationality_id = $models->execute_kw($db, $uid, $password,
        'res.country', 'search_read',
        array(array(array('name', '=', $Citizenship))),
        array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
    $Citizenship_odoo = $odoo_search_nationality_id[0]['id'] or False;

    $odoo_search_country = $models->execute_kw($db, $uid, $password,
        'res.country', 'search_read',
        array(array(array('name', '=', $count))),
        array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
    $country_odoo = $odoo_search_country[0]['id'] or False;
    if ($membership == 'Oui'){
        $membership_odoo = 'true';
    } else{
        $membership_odoo = '';
    }
    if ($typeName == 'Individuelle'){
        $odoo_id = $models->execute_kw($db, $uid, $password,
            'res.partner', 'create',
            array(array(
                    'lastname'=>$LastName,
                    'firstname'=>$FirstName,
                    'birthdate_date'=>$BirthDate,
                    'gender'=>$Gender_odoo,
                    'nationality_id'=>$Citizenship_odoo,
                    'email'=>$mail,
                    'phone'=>$phone,
                    'street'=>$address,
                    'street2'=>$addressComplement,
                    'zip'=>$NPA,
                    'city'=>$city,
                    'country_id'=>$country_odoo,
                    'wallet_accounts'=>$wallets,
                    'pep'=>$PEP_odoo,
                    'pepr'=>$PEPRelated_odoo,
                    'comment'=>$Notes,
                    'leman_inscription_id'=>$id,
                    'free_member'=>$membership_odoo,
                    'electronic_account'=>$electronic_account_odoo,
                )
            )
        );
        if (is_int($odoo_id)){
            echo '<p>Export inscription individuelle:'.$odoo_id.'</p>';
        } else{
            echo '<p>Export inscription individuelle: Erreur</p>';
        }
        if ($newsletter_list_odoo){
            $odoo_mailing_contact_id = $models->execute_kw($db, $uid, $password,
                'mail.mass_mailing.contact', 'create',
                array(array(
                        'partner_id'=>$odoo_id,
                        'list_ids'=>array(array(4,$newsletter_list_odoo)),

                    )
                )
            );
            if (is_int($odoo_mailing_contact_id)){
                echo '<p>Inscription newsletter:'.$odoo_mailing_contact_id.'</p>';
            } else{
                echo '<p>Inscription newsletter: Erreur</p>';
            }
        }
    }

    if ($typeName == 'Entreprise'){
        $LegalForm_name = $array_legal_status[$LegalForm];
        $odoo_search_legal_id = $models->execute_kw($db, $uid, $password,
            'res.partner.legal.status', 'search_read',
            array(array(array('name', '=', $LegalForm_name))),
            array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'), 'limit'=>1));
        $LegalForm_odoo = $odoo_search_legal_id[0]['id'] or False;

        $ActivityField_name = $array_activity[$ActivityField];
        $odoo_search_activity_id = $models->execute_kw($db, $uid, $password,
            'res.partner.industry', 'search_read',
            array(array(array('name', '=', $ActivityField_name))),
            array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'), 'limit'=>1));
        $ActivityField_odoo = $odoo_search_activity_id[0]['id'] or False;

        $ActivityFieldSeg_name = $array_activity[$ActivityFieldSeg];
        $odoo_search_activity_id = $models->execute_kw($db, $uid, $password,
            'res.partner.industry', 'search_read',
            array(array(array('name', '=', $ActivityFieldSeg_name))),
            array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'), 'limit'=>1));
        $ActivityFieldSeg_odoo = $odoo_search_activity_id[0]['id'] or False;

        if ($RefName != False){
            $Name_odoo = $RefName;
        } else{
            $Name_odoo = $Name;
        }

        $odoo_id = $models->execute_kw($db, $uid, $password,
            'res.partner', 'create',
            array(array(
                    'company_type'=>'company',
                    'name'=>$Name_odoo,
                    'public_name'=>$RefName,
                    'legal_name'=>$Name,
                    'legal_status'=>$LegalForm_odoo,
                    'creation_date'=>$CreationDate,
                    'industry_id'=>$ActivityField_odoo,
                    'detailed_activity'=>$ActivityDescription,
                    'employees_number'=>$EFT,
                    'website'=>$site,
                    'email'=>$mail,
                    'phone'=>$phone,
                    'street'=>$address,
                    'street2'=>$addressComplement,
                    'zip'=>$NPA,
                    'city'=>$city,
                    'country_id'=>$country_odoo,
                    'wallet_accounts'=>$wallets,
                    'pep'=>$PEP_odoo,
                    'pepr'=>$PEPRelated_odoo,
                    'comment'=>$Notes,
                    'leman_inscription_id'=>$id,
                    'free_member'=>'True',
                    'electronic_account'=>$electronic_account_odoo,
                )
            )
        );
        if (is_int($ActivityFieldSeg_odoo)){
            $models->execute_kw($db, $uid, $password,'res.partner', 'write',
                array(array($odoo_id), array('secondary_industry_ids'=>array(array(4,$ActivityFieldSeg_odoo)))));
        }
        if (is_int($odoo_id)){
            echo '<p>Export inscription entreprise:'.$odoo_id.'</p>';
        } else{
            echo '<p>Export inscription entreprise: Erreur</p>';
        }
        if ($newsletter_list_odoo){
            $odoo_mailing_contact_id = $models->execute_kw($db, $uid, $password,
                'mail.mass_mailing.contact', 'create',
                array(array(
                        'partner_id'=>$odoo_id,
                        'list_ids'=>array(array(4,$newsletter_list_odoo)),

                    )
                )
            );
            if (is_int($odoo_mailing_contact_id)){
                echo '<p>Inscription newsletter:'.$odoo_mailing_contact_id.'</p>';
            } else{
                echo '<p>Inscription newsletter: Erreur</p>';
            }
        }
        $odoo_contact_id = $models->execute_kw($db, $uid, $password,
            'res.partner', 'create',
            array(array(
                    'type'=>'contact',
                    'leman_contact_type'=>'contact',
                    'parent_id'=>$odoo_id,
                    'lastname'=>$Contact,
                    'firstname'=>$ContactSurname,
                    'gender'=>$ContactGender_odoo,
                    'email'=>$mail,
                )
            )
        );
        if (is_int($odoo_contact_id)){
            echo '<p>Export personne de contact:'.$odoo_contact_id.'</p>';
        } else{
            echo '<p>Export personne de contact: Erreur</p>';
        }
        if ($p_address != $address){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $p_country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $p_country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_postal_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'postal',
                        'parent_id'=>$odoo_id,
                        'street'=>$p_address,
                        'street2'=>$p_addressComplement,
                        'zip'=>$p_NPA,
                        'city'=>$p_city,
                        'country_id'=>$p_country_odoo,
                    )
                )
            );
            if (is_int($odoo_postal_id)){
                echo '<p>Export adresse postale:'.$odoo_postal_id.'</p>';
            } else{
                echo '<p>Export adresse postale: Erreur</p>';
            }
        }
        if ($ST_1_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_1_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_1_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_1_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_1_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_st_1_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ts',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$ST_1_LastName,
                        'firstname'=>$ST_1_FirstName,
                        'birthdate_date'=>$ST_1_BirthDate,
                        'nationality_id'=>$ST_1_Citizenship_odoo,
                        'street'=>$ST_1_Address,
                        'street2'=>$ST_1_ComplAddress,
                        'zip'=>$ST_1_ZIP,
                        'city'=>$ST_1_City,
                        'country_id'=>$ST_1_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_st_1_id)){
                echo '<p>Export tiers subordonné:'.$odoo_st_1_id.'</p>';
            } else{
                echo '<p>Export tiers subordonné: Erreur</p>';
            }
        }
        if ($ST_2_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_2_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_2_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_2_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_2_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_st_2_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ts',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$ST_2_LastName,
                        'firstname'=>$ST_2_FirstName,
                        'birthdate_date'=>$ST_2_BirthDate,
                        'nationality_id'=>$ST_2_Citizenship_odoo,
                        'street'=>$ST_2_Address,
                        'street2'=>$ST_2_ComplAddress,
                        'zip'=>$ST_2_ZIP,
                        'city'=>$ST_2_City,
                        'country_id'=>$ST_2_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_st_2_id)){
                echo '<p>Export tiers subordonné:'.$odoo_st_2_id.'</p>';
            } else{
                echo '<p>Export tiers subordonné: Erreur</p>';
            }
        }
        if ($ST_3_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_3_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_3_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_3_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_3_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_st_3_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ts',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$ST_3_LastName,
                        'firstname'=>$ST_3_FirstName,
                        'birthdate_date'=>$ST_3_BirthDate,
                        'nationality_id'=>$ST_3_Citizenship_odoo,
                        'street'=>$ST_3_Address,
                        'street2'=>$ST_3_ComplAddress,
                        'zip'=>$ST_3_ZIP,
                        'city'=>$ST_3_City,
                        'country_id'=>$ST_3_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_st_3_id)){
                echo '<p>Export tiers subordonné:'.$odoo_st_3_id.'</p>';
            } else{
                echo '<p>Export tiers subordonné: Erreur</p>';
            }
        }
        if ($ST_4_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_4_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_4_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $ST_4_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $ST_4_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_st_4_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ts',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$ST_4_LastName,
                        'firstname'=>$ST_4_FirstName,
                        'birthdate_date'=>$ST_4_BirthDate,
                        'nationality_id'=>$ST_4_Citizenship_odoo,
                        'street'=>$ST_4_Address,
                        'street2'=>$ST_4_ComplAddress,
                        'zip'=>$ST_4_ZIP,
                        'city'=>$ST_4_City,
                        'country_id'=>$ST_4_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_st_4_id)){
                echo '<p>Export tiers subordonné:'.$odoo_st_4_id.'</p>';
            } else{
                echo '<p>Export tiers subordonné: Erreur</p>';
            }
        }
    }

    if ($aed == 'Autre'){
        if ($AED_1_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_1_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_1_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_1_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_1_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_ade_1_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ade',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$AED_1_LastName,
                        'firstname'=>$AED_1_FirstName,
                        'birthdate_date'=>$AED_1_BirthDate,
                        'nationality_id'=>$AED_1_Citizenship_odoo,
                        'street'=>$AED_1_Address,
                        'street2'=>$AED_1_ComplAddress,
                        'zip'=>$AED_1_ZIP,
                        'city'=>$AED_1_City,
                        'country_id'=>$AED_1_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_ade_1_id)){
                echo '<p>Export ayant droit économique:'.$odoo_ade_1_id.'</p>';
            } else{
                echo '<p>Export ayant droit économique: Erreur</p>';
            }
        }
        if ($AED_2_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_2_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_2_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_2_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_2_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_ade_2_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ade',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$AED_2_LastName,
                        'firstname'=>$AED_2_FirstName,
                        'birthdate_date'=>$AED_2_BirthDate,
                        'nationality_id'=>$AED_2_Citizenship_odoo,
                        'street'=>$AED_2_Address,
                        'street2'=>$AED_2_ComplAddress,
                        'zip'=>$AED_2_ZIP,
                        'city'=>$AED_2_City,
                        'country_id'=>$AED_2_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_ade_2_id)){
                echo '<p>Export ayant droit économique:'.$odoo_ade_2_id.'</p>';
            } else{
                echo '<p>Export ayant droit économique: Erreur</p>';
            }
        }
        if ($AED_3_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_3_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_3_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_3_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_3_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_ade_3_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ade',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$AED_3_LastName,
                        'firstname'=>$AED_3_FirstName,
                        'birthdate_date'=>$AED_3_BirthDate,
                        'nationality_id'=>$AED_3_Citizenship_odoo,
                        'street'=>$AED_3_Address,
                        'street2'=>$AED_3_ComplAddress,
                        'zip'=>$AED_3_ZIP,
                        'city'=>$AED_3_City,
                        'country_id'=>$AED_3_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_ade_3_id)){
                echo '<p>Export ayant droit économique:'.$odoo_ade_3_id.'</p>';
            } else{
                echo '<p>Export ayant droit économique: Erreur</p>';
            }
        }
        if ($AED_4_LastName != False){
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_4_Country))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_4_Country_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_search_country = $models->execute_kw($db, $uid, $password,
                'res.country', 'search_read',
                array(array(array('name', '=', $AED_4_Citizenship))),
                array('fields'=>array('id'), 'context'=>array('lang'=>'fr_FR'),'limit'=>1));
            $AED_4_Citizenship_odoo = $odoo_search_country[0]['id'] or False;
            $odoo_ade_4_id = $models->execute_kw($db, $uid, $password,
                'res.partner', 'create',
                array(array(
                        'type'=>'other',
                        'leman_contact_type'=>'ade',
                        'parent_id'=>$odoo_id,
                        'lastname'=>$AED_4_LastName,
                        'firstname'=>$AED_4_FirstName,
                        'birthdate_date'=>$AED_4_BirthDate,
                        'nationality_id'=>$AED_4_Citizenship_odoo,
                        'street'=>$AED_4_Address,
                        'street2'=>$AED_4_ComplAddress,
                        'zip'=>$AED_4_ZIP,
                        'city'=>$AED_4_City,
                        'country_id'=>$AED_4_Country_odoo,
                    )
                )
            );
            if (is_int($odoo_ade_4_id)){
                echo '<p>Export ayant droit économique:'.$odoo_ade_4_id.'</p>';
            } else{
                echo '<p>Export ayant droit économique: Erreur</p>';
            }
        }
    }

    }
   
?>
