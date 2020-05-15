<?php

$uploal_limit_MB=3.5;


$url_charte ="https://drive.leman-en-transition.org/s/fR3SYaFQQo6GCqH#pdfviewer";

$url_cgu = "https://drive.leman-en-transition.org/s/FKNBCipArfE9gTE#pdfviewer";


$cotisation_i_ch=50;
$cotisation_i_fr=15;
$cotisation_e_ch=[0=>75,2=>200,10=>400,30=>1000];
$cotisation_e_fr=[0=>60,2=>160,10=>320,30=>800];

// apply change
$json = file_get_contents('https://api.exchangeratesapi.io/latest?symbols=CHF');
$rates = json_decode($json);
$eur_chf = $rates->rates->CHF;
$eur_chf *=1.01;   //1% de frais

$cotisation_i_fr_lem=round($cotisation_i_fr*$eur_chf, 2);
$cotisation_e_fr_lem=[];
foreach ($cotisation_e_fr as $etp => $value){
    $cotisation_e_fr_lem[$etp] = round($value*$eur_chf, 2);
}
    
   



function makeHead($type){
    echo'
<meta charset="UTF-8">';

if ($type==1){
    echo' 
    <title>Léman électronique | Ouverture compte</title>
    <meta name="Description" content="Page de demande d\'ouverture d\'un compte en Léman electronique">';
} else if ($type==0) {
    echo' 
    <title>Adhésion | Monnaie Léman</title>
    <meta name="Description" content="Page de demande d\'adhésion à l\'Association Monnie Léman">';
}  else if ($type==10) {
    echo' 
    <title>Administration | Monnaie Léman</title>';
} 

echo'
<meta name="Keywords" content="Léman,MLC">
<meta http-equiv="Content-Type" content="text/html">
<meta http-equiv="Content-Language" content="fr">
<meta http-equiv="window-target" content="_blank">
<meta name="Author" content="Com-Chain">
<meta name="Copyright" content="Com-Chain-2020">

<meta name="revisit-after" content="1 days">
<meta name="Publisher" content="Monnaie Léman">
<meta name="Robots" content="all, index, follow">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=1.0)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=1.0)">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="css/public.css?v=1">
 <script type="text/javascript">
   /* if (window.location.protocol == "http:") {
        var restOfUrl = window.location.href.substr(5);
        window.location = "https:" + restOfUrl;
    }*/
</script>
<script>

</script>
';

}


$country ='        <option value =""></option>
        <option value ="Suisse">Suisse</option>
	    <option value ="France">France</option>
	    <option value ="Allemagne">Allemagne</option>
	    <option value ="Espagne">Espagne</option>
	    <option value ="Italie">Italie</option>
	    <option value ="Portugal">Portugal</option>
	    <optgroup label="--------">
	    <option value ="Afrique du Sud">Afrique du Sud</option>
	    <option value ="Afghanistan">Afghanistan</option>
	    <option value ="Albanie">Albanie</option>
	    <option value ="Algérie">Algérie</option>
	    <option value ="Allemagne">Allemagne</option>
	    <option value ="Andorre">Andorre</option>
	    <option value ="Angola">Angola</option>
	    <option value ="Antigua-et-Barbuda">Antigua-et-Barbuda</option>
	    <option value ="Arabie Saoudite">Arabie Saoudite</option>
	    <option value ="Argentine">Argentine</option>
	    <option value ="Arménie">Arménie</option>
	    <option value ="Australie">Australie</option>
	    <option value ="Autriche">Autriche</option>
	    <option value ="Azerbaïdjan">Azerbaïdjan</option>
	    <option value ="Bahamas">Bahamas</option>
	    <option value ="Bahreïn">Bahreïn</option>
	    <option value ="Bangladesh">Bangladesh</option>
	    <option value ="Barbade">Barbade</option>
	    <option value ="Belgique">Belgique</option>
	    <option value ="Belize">Belize</option>
	    <option value ="Bénin">Bénin</option>
	    <option value ="Bhoutan">Bhoutan</option>
	    <option value ="Biélorussie">Biélorussie</option>
	    <option value ="Birmanie">Birmanie</option>
	    <option value ="Bolivie">Bolivie</option>
	    <option value ="Bosnie-Herzégovine">Bosnie-Herzégovine</option>
	    <option value ="Botswana">Botswana</option>
	    <option value ="Brésil">Brésil</option>
	    <option value ="Brunei">Brunei</option>
	    <option value ="Bulgarie">Bulgarie</option>
	    <option value ="Burkina Faso">Burkina Faso</option>
	    <option value ="Burundi">Burundi</option>
	    <option value ="Cambodge">Cambodge</option>
	    <option value ="Cameroun">Cameroun</option>
	    <option value ="Canada">Canada</option>
	    <option value ="Cap-Vert">Cap-Vert</option>
	    <option value ="Chili">Chili</option>
	    <option value ="Chine">Chine</option>
	    <option value ="Chypre">Chypre</option>
	    <option value ="Colombie">Colombie</option>
	    <option value ="Comores">Comores</option>
	    <option value ="Corée du Nord">Corée du Nord</option>
	    <option value ="Corée du Sud">Corée du Sud</option>
	    <option value ="Costa Rica">Costa Rica</option>
	    <option value ="Côte d’Ivoire">Côte d’Ivoire</option>
	    <option value ="Croatie">Croatie</option>
	    <option value ="Cuba">Cuba</option>
	    <option value ="Danemark">Danemark</option>
	    <option value ="Djibouti">Djibouti</option>
	    <option value ="Dominique">Dominique</option>
	    <option value ="Égypte">Égypte</option>
	    <option value ="Émirats arabes unis">Émirats arabes unis</option>
	    <option value ="Équateur">Équateur</option>
	    <option value ="Érythrée">Érythrée</option>
	    <option value ="Eswatini">Eswatini</option>
	    <option value ="Estonie">Estonie</option>
	    <option value ="États-Unis">États-Unis</option>
	    <option value ="Éthiopie">Éthiopie</option>
	    <option value ="Fidji">Fidji</option>
	    <option value ="Finlande">Finlande</option>
	    <option value ="Gabon">Gabon</option>
	    <option value ="Gambie">Gambie</option>
	    <option value ="Géorgie">Géorgie</option>
	    <option value ="Ghana">Ghana</option>
	    <option value ="Grèce">Grèce</option>
	    <option value ="Grenade">Grenade</option>
	    <option value ="Guatemala">Guatemala</option>
	    <option value ="Guinée">Guinée</option>
	    <option value ="Guinée équatoriale">Guinée équatoriale</option>
	    <option value ="Guinée-Bissau">Guinée-Bissau</option>
	    <option value ="Guyana">Guyana</option>
	    <option value ="Haïti">Haïti</option>
	    <option value ="Honduras">Honduras</option>
	    <option value ="Hongrie">Hongrie</option>
	    <option value ="Îles Cook">Îles Cook</option>
	    <option value ="Îles Marshall">Îles Marshall</option>
	    <option value ="Inde">Inde</option>
	    <option value ="Indonésie">Indonésie</option>
	    <option value ="Irak">Irak</option>
	    <option value ="Iran">Iran</option>
	    <option value ="Irlande">Irlande</option>
	    <option value ="Islande">Islande</option>
	    <option value ="Israël">Israël</option>
	    <option value ="Jamaïque">Jamaïque</option>
	    <option value ="Japon">Japon</option>
	    <option value ="Jordanie">Jordanie</option>
	    <option value ="Kazakhstan">Kazakhstan</option>
	    <option value ="Kenya">Kenya</option>
	    <option value ="Kirghizistan">Kirghizistan</option>
	    <option value ="Kiribati">Kiribati</option>
	    <option value ="Koweït">Koweït</option>
	    <option value ="Laos">Laos</option>
	    <option value ="Lesotho">Lesotho</option>
	    <option value ="Lettonie">Lettonie</option>
	    <option value ="Liban">Liban</option>
	    <option value ="Liberia">Liberia</option>
	    <option value ="Libye">Libye</option>
	    <option value ="Liechtenstein">Liechtenstein</option>
	    <option value ="Lituanie">Lituanie</option>
	    <option value ="Luxembourg">Luxembourg</option>
	    <option value ="Macédoine">Macédoine</option>
	    <option value ="Madagascar">Madagascar</option>
	    <option value ="Malaisie">Malaisie</option>
	    <option value ="Malawi">Malawi</option>
	    <option value ="Maldives">Maldives</option>
	    <option value ="Mali">Mali</option>
	    <option value ="Malte">Malte</option>
	    <option value ="Maroc">Maroc</option>
	    <option value ="Maurice">Maurice</option>
	    <option value ="Mauritanie">Mauritanie</option>
	    <option value ="Mexique">Mexique</option>
	    <option value ="Micronésie">Micronésie</option>
	    <option value ="Moldavie">Moldavie</option>
	    <option value ="Monaco">Monaco</option>
	    <option value ="Mongolie">Mongolie</option>
	    <option value ="Monténégro">Monténégro</option>
	    <option value ="Mozambique">Mozambique</option>
	    <option value ="Namibie">Namibie</option>
	    <option value ="Nauru">Nauru</option>
	    <option value ="Népal">Népal</option>
	    <option value ="Nicaragua">Nicaragua</option>
	    <option value ="Niger">Niger</option>
	    <option value ="Nigeria">Nigeria</option>
	    <option value ="Niue">Niue</option>
	    <option value ="Norvège">Norvège</option>
	    <option value ="Nouvelle-Zélande">Nouvelle-Zélande</option>
	    <option value ="Oman">Oman</option>
	    <option value ="Ouganda">Ouganda</option>
	    <option value ="Ouzbékistan">Ouzbékistan</option>
	    <option value ="Pakistan">Pakistan</option>
	    <option value ="Palaos">Palaos</option>
	    <option value ="Palestine">Palestine</option>
	    <option value ="Panama">Panama</option>
	    <option value ="Papouasie-Nouvelle-Guinée">Papouasie-Nouvelle-Guinée</option>
	    <option value ="Paraguay">Paraguay</option>
	    <option value ="Pays-Bas">Pays-Bas</option>
	    <option value ="Pérou">Pérou</option>
	    <option value ="Philippines">Philippines</option>
	    <option value ="Pologne">Pologne</option>
	    <option value ="Qatar">Qatar</option>
	    <option value ="République centrafricaine">République centrafricaine</option>
	    <option value ="République démocratique du Congo">République démocratique du Congo</option>
	    <option value ="République Dominicaine">République Dominicaine</option>
	    <option value ="République du Congo">République du Congo</option>
	    <option value ="République tchèque">République tchèque</option>
	    <option value ="Roumanie">Roumanie</option>
	    <option value ="Royaume-Uni">Royaume-Uni</option>
	    <option value ="Russie">Russie</option>
	    <option value ="Rwanda">Rwanda</option>
	    <option value ="Saint-Kitts-et-Nevis">Saint-Kitts-et-Nevis</option>
	    <option value ="Saint-Vincent-et-les-Grenadines">Saint-Vincent-et-les-Grenadines</option>
	    <option value ="Sainte-Lucie">Sainte-Lucie</option>
	    <option value ="Saint-Marin">Saint-Marin</option>
	    <option value ="Salomon">Salomon</option>
	    <option value ="Salvador">Salvador</option>
	    <option value ="Samoa">Samoa</option>
	    <option value ="São Tomé-et-Principe">São Tomé-et-Principe</option>
	    <option value ="Sénégal">Sénégal</option>
	    <option value ="Serbie">Serbie</option>
	    <option value ="Seychelles">Seychelles</option>
	    <option value ="Sierra Leone">Sierra Leone</option>
	    <option value ="Singapour">Singapour</option>
	    <option value ="Slovaquie">Slovaquie</option>
	    <option value ="Slovénie">Slovénie</option>
	    <option value ="Somalie">Somalie</option>
	    <option value ="Soudan">Soudan</option>
	    <option value ="Soudan du Sud">Soudan du Sud</option>
	    <option value ="Sri Lanka">Sri Lanka</option>
	    <option value ="Suède">Suède</option>
	    <option value ="Suriname">Suriname</option>
	    <option value ="Syrie">Syrie</option>
	    <option value ="Tadjikistan">Tadjikistan</option>
	    <option value ="Tanzanie">Tanzanie</option>
	    <option value ="Tchad">Tchad</option>
	    <option value ="Thaïlande">Thaïlande</option>
	    <option value ="Timor oriental">Timor oriental</option>
	    <option value ="Togo">Togo</option>
	    <option value ="Tonga">Tonga</option>
	    <option value ="Trinité-et-Tobago">Trinité-et-Tobago</option>
	    <option value ="Tunisie">Tunisie</option>
	    <option value ="Turkménistan">Turkménistan</option>
	    <option value ="Turquie">Turquie</option>
	    <option value ="Tuvalu">Tuvalu</option>
	    <option value ="Ukraine">Ukraine</option>
	    <option value ="Uruguay">Uruguay</option>
	    <option value ="Vanuatu">Vanuatu</option>
	    <option value ="Vatican">Vatican</option>
	    <option value ="Venezuela">Venezuela</option>
	    <option value ="Viêt Nam">Viêt Nam</option>
	    <option value ="Yémen">Yémen</option>
	    <option value ="Zambie">Zambie</option>
	    <option value ="Zimbabwe">Zimbabwe</option>
	    </optgroup>';

function getCountry($country,$selected){

    $sel=$country;
    
    $pos = strpos($sel,'"'.$selected.'"');
    if ($pos>0){
        $pos=$pos + strlen($selected)+2;
        $begin= substr ( $sel , 0, $pos );
        $end= substr ( $sel , $pos );
        $sel = $begin.' selected="selected"'.$end;
    }
    return $sel;
}

$activity_sector ='
<option value =""></option>
<option value ="ActivitésCitoyennesAdvocacy">Activités Citoyennes & Advocacy</option>
<option value ="AdministratifAudit">Administratif & Audit</option>
<option value ="AgricultureProducteurs">Agriculture & Producteurs</option>
<option value ="AlimentationEpicerie">Alimentation & Epicerie</option>
<option value ="Artisanat">Artisanat</option>
<option value ="BarRestauration">Bar & Restauration</option>
<option value ="CommunicationGraphismeDessinImpression">Communication, Graphisme, Dessin, Impression</option>
<option value ="Culture">Culture</option>
<option value ="EducationFormation">Education & Formation</option>
<option value ="Energie">Energie</option>
<option value ="Événementiel">Événementiel</option>
<option value ="FournituresEquipement">Fournitures & Equipement</option>
<option value ="HabillementBeauté">Habillement & Beauté</option>
<option value ="HumanitaireCaritatif">Humanitaire & Caritatif</option>
<option value ="InformatiqueElectronique">Informatique & Electronique</option>
<option value ="LogementConstruction">Logement & Construction</option>
<option value ="MobilitéTransport">Mobilité & Transport</option>
<option value ="NettoyageGestionDéchets">Nettoyage & Gestion déchets</option>
<option value ="PresseMédias">Presse & Médias</option>
<option value ="RéparationSAV">Réparation & SAV</option>
<option value ="SantéBienêtre">Santé & Bien-être</option>
<option value ="Services">Services à la personne</option>
<option value ="TourismeLoisirs">Tourisme & Loisirs</option>
';

function getActivitySector($activity_sector,$selected){

    $sel=$activity_sector;
    
    $pos = strpos($sel,'"'.$selected.'"');
    if ($pos>0){
        $pos=$pos + strlen($selected)+2;
        $begin= substr ( $sel , 0, $pos );
        $end= substr ( $sel , $pos );
        $sel = $begin.' selected="selected"'.$end;
    }
    return $sel;
}

$status_juridique ='
<option value =""></option>
    <optgroup label="En Suisse:"> 
        <option value ="CH-Association">Association</option>
	    <option value ="CH-Coopérative">Coopérative</option>
	    <option value ="CH-Fondation">Fondation</option>
	    <option value ="CH-Raison individuelle">Raison individuelle</option>
	    <option value ="CH-SNC">Société en nom collectif (SNC)</option>
	    <option value ="CH-Sàrl">Société à responsabilité limitée (Sàrl)</option>
	    <option value ="CH-SA">Société anonyme (SA)</option>
	    <option value ="CH-Société en commandite">Société en commandite</option>  
	 </optgroup>
	 <optgroup label="En France:">
	    <option value ="FR-Association">Association</option>
	    <option value ="FR-EI">Entreprise individuelle (EI)</option>
	    <option value ="FR-EIRL">Entreprise individuelle à responsabilité limitée (EIRL)</option>
	    <option value ="FR-EURL">Entreprise unipersonnelle à responsabilité limitée (EURL)</option>
	    <option value ="FR-EARL">Exploitation agricole à responsabilité limitée (EARL)</option>
	    <option value ="FR-SARL">Société à responsabilité limitée (SARL)</option>
	    <option value ="FR-SA">Société anonyme (SA)</option>
	    <option value ="FR-SAS">Société par actions simplifiée (SAS)</option>
	    <option value ="FR-SASU">Société par actions simplifiée unipersonnelle (SASU)</option>
	    
	    <option value ="FR-SNC">Société en nom collectif (SNC)</option>
	    
	    <option value ="FR-SCOP">Société coopérative de production (SCOP)</option>
	    <option value ="FR-SCIC">Société coopérative d’intérêt collectif (SCIC)</option>
	    <option value ="FR-SCA">Société en commandite par actions (SCA)</option>
	    <option value ="FR-SCS">Société en commandite simple (SCS)</option>
	    <option value ="FR-SCP">Société civile professionnelle (SCP)</option>
	    <option value ="FR-SCM">Société civile de moyens (SCM)</option>
	    <option value ="FR-SCI">Société civile immobilière (SCI)</option>
	    <option value ="FR-Mutuelle">Mutuelle</option>
	    <option value ="FR-Fondation">Fondation</option>
	 </optgroup>
';

function getJuridicStatus($status_juridique,$selected){

    $sel=$status_juridique;
    
    $pos = strpos($sel,'"'.$selected.'"');
    if ($pos>0){
        $pos=$pos + strlen($selected)+2;
        $begin= substr ( $sel , 0, $pos );
        $end= substr ( $sel , $pos );
        $sel = $begin.' selected="selected"'.$end;
    }
    return $sel;
}


?>
