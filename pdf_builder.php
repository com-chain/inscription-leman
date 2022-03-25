<?php
require('fpdf/fpdf.php');
require_once 'str.php';
require_once 'pdf_class.php';

function getPDF($code, $mysqli, $local) {


    $res = validMember($mysqli, $code);
    if ($res['Valid']!=True){
        echo "Hello!";
        exit;
    }
    
    $signature_handler = new CurrencySignatureHandler("Monnaie-Leman", "myPathToPrivateKeyPemFile", "resources/wide-logo_CHF.png");
    if ($res['Curr']=="EUR") {
        $signature_handler = new CurrencySignatureHandler("Leman-EU", "file://../id_rsa_eu.pem", "resources/wide-logo_EUR.png");
    }

    $do_output_file = $local;

/*
    class PDF extends FPDF
    {
    
    public string $logo_path;
    
    public function __construct(string $logo_path) {
        
        parent::__construct();
        $this->logo_path = $logo_path;
    }
    
    function Font(){
       // $this->AddFont('HelveticaLt','','/HelveticaLt.php');
    }

    // En-tête
    function Header()
    {
        // Logo
        $this->Image($this->logo_path,10,6,50);
        // Police Arial gras 15
        $this->SetFont('Arial','B',14);
        // Décalage à droite
        // $this->Cell(73);
        // Titre
        $this->SetXY (15,25);
        $this->Cell(0,10,utf8_decode('Léman électronique: code d\'autorisation personnel'),0,0,'C');
        // Saut de ligne
        $this->Ln(12);
        $this->AjoutBoldParagraphe('Attention, ce document est à conserver précieusement dans vos dossiers !');
    }

    // Pied de page
    function Footer()
    {
        $this->SetMargins(15,0,15);
        $this->SetTextColor(0,111,180);
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        $this->SetFont('Helvetica','',8);
        // Numéro de page
        // bleu
        $this->Cell(0,10,utf8_decode('Monnaie Léman | monnaie-leman.org | info@monnaie-leman.org'),0,0,'C',false,'https://monnaie-leman.org/');
    }


    function AjoutText_2($text){
        // Helvetica 10
        $this->SetFont('Helvetica','',9);
        $this->MultiCell(180,5,utf8_decode($text));  
    }

    function AjoutText($text){
        // Helvetica 10
        $this->SetFont('Helvetica','',9);
        $this->Write(5,utf8_decode($text));  
    }

    function AjoutBold($text){
        // Helvetica 10
        $this->SetFont('Helvetica','B',9);
        $this->SetTextColor(240,113,18);
        $this->Write(5,utf8_decode($text));
        $this->SetTextColor(0,0,0);
    }

    function AjoutBold_2($text){
        // Helvetica 10
        $this->SetFont('Helvetica','B',9);
        $this->SetTextColor(240,113,18);
        $this->MultiCell(180,5,utf8_decode($text),0,'C');
        $this->SetTextColor(0,0,0);
    }



    function AjoutLien($text,$liens){
        $this->SetTextColor(0,111,180);
        $this->SetFont('Helvetica','U',9);
        $this->Write(5,utf8_decode($text),$liens);
        $this->SetTextColor(0,0,0);
    }


    function SautDeLigne(){
        $this->Ln();
    }

    function LigneVide(){
        $this->Ln();
        $this->Ln();
    }

    function AjoutParagraphe($text){
        $this->AjoutText_2($text);
        $this->SautDeLigne();
    }


    function AjoutBoldParagraphe($text)
    {
        $this->AjoutBold_2($text);
        $this->SautDeLigne();
    }

    function AjoutCadreParagraphe($text)
    {
        // Helvetica 10
        $this->SetFont('Courier','',9);
        // Sortie du texte justifié
        $this->MultiCell(180,5,utf8_decode($text),1,'C');
        $this->Ln();
    }
    }
    */

    // Instanciation de la classe dérivée
    $pdf = new PDF($signature_handler->getLogoPath());
    $pdf->Font();
    $pdf->SetMargins(15,0);
    $pdf->AliasNbPages();
    $pdf->AddPage();



   

    if ($res['Type']==1){
        $pdf->AjoutText("Bonjour ".$res['Company'].",");
    } else {
        $pdf->AjoutText("Bonjour ".$res['FirstName'].",");
    }

    $pdf->LigneVide();
    $pdf->AjoutText("Ce document contient votre ");
    $pdf->SetFont('Helvetica','I',9);
    $pdf->SetTextColor(0,111,180);
    $pdf->Write(5,utf8_decode("Code d'autorisation personnel"));
    $pdf->SetFont('Helvetica','',9);
    $pdf->SetTextColor(0,0,0);
    $pdf->AjoutText(". Il consiste en une suite de chiffres et de lettres:");



    $pdf->LigneVide();
    $pdf->AjoutCadreParagraphe($signature_handler->getStr($res['code']));

    $pdf->AjoutText("Les personnes physiques (particuliers) et les personnes morales (entreprises, associations y c. raisons individuelles)
reçoivent des codes d'autorisation distincts. Ce code d'autorisation vous ");
    $pdf->SetFont('Helvetica','I',9);
    $pdf->Write(5,utf8_decode("autorise"));
    $pdf->SetFont('Helvetica','',9);



    if ($res['Type']==1){
        $pdf->AjoutText(" à créer au sein de l'application Biletujo un ou des comptes pour votre entreprise. La marche à suivre pour créer votre compte et le synchroniser sur vos différents appareils est décrite en détail dans la ");
     } else {
        $pdf->AjoutText(" à créer au sein de l'application Biletujo autant de comptes personnels que vous le désirez (compte personnel, compte famille, etc.). La marche à suivre pour créer votre compte et le synchroniser sur vos différents appareils est décrite en détail dans la ");
    }

    $pdf->SetFont('Helvetica','I',9);
    $pdf->SetTextColor(0,111,180);
    $pdf->Write(5,utf8_decode("Marche à suivre: création et synchronisation d'un compte sur l'application Biletujo"),'https://monnaie-leman.org/inscription/resources/Biletujo_Marche_a_suivre_creation_compte.pdf');
    $pdf->SetFont('Helvetica','',9);
    $pdf->SetTextColor(0,0,0);
    $pdf->AjoutText(", que nous vous demandons vivement de bien lire. En tous les cas, par prudence, il faut:");
    $pdf->SetMargins(20,0,15);
    $pdf->LigneVide();
    $pdf->AjoutText("1.    Commencer la procédure d'autorisation sur un ordinateur à la page ");

    $pdf->SetMargins(26,0);
    $pdf->AjoutLien('https://wallet.monnaie-leman.org/','https://wallet.monnaie-leman.org/index.html?code='.$signature_handler->getStr($res['code']));
    $pdf->AjoutText(" (2ème icône avec le \"+\").");

    $pdf->SetMargins(20,0,15);
    $pdf->SautDeLigne();
    $pdf->AjoutText('2.    Suivre les instructions pour la création de votre/vos compte/s. ');

    $pdf->SetMargins(26,0,15);
    $pdf->AjoutText('Votre code d\'autorisation personnel ci-dessus {"id":...} vous sera demandé par l\'application lors de l\'ouverture de chaque compte.');

    $pdf->SetMargins(20,0,15);
    $pdf->SautDeLigne();
    $pdf->AjoutText('3.    Une fois votre compte créé, réaliser une ');
    $pdf->SetMargins(26,0,15);
    $pdf->AjoutBold('sauvegarde numérique');
    $pdf->AjoutText(' et une ');
    $pdf->AjoutBold('sauvegarde papier');
    $pdf->AjoutText('.');

    $pdf->SetMargins(20,0,15);
    $pdf->SautDeLigne();
    $pdf->AjoutText('4.    Conserver précieusement les sauvegardes ainsi que le ');
    $pdf->SetMargins(26,0,15);
    $pdf->AjoutBold('mot de passe');
    $pdf->AjoutText(' que vous aurez choisi au moment de la création de chacun de vos comptes.');
    $pdf->SautDeLigne();
    $pdf->AjoutBold('Si vous veniez à perdre vos sauvegardes ou le mot de passe, il ne serait plus possible de récupérer les lémans chargés sur le compte correspondant.');

    $pdf->SetMargins(15,0,15);
    $pdf->LigneVide();
    $pdf->AjoutText('Veuillez prendre note que votre compte devra encore être débloqué avant de pouvoir recevoir et envoyer des lémans.');

    $pdf->LigneVide();



    $pdf->AjoutText('La sauvegarde papier de chaque compte permet d\'y accéder pour synchroniser votre ');
    $pdf->SetFont('Helvetica','I',9);
    $pdf->Write(5,utf8_decode("smartphone"));
    $pdf->SetFont('Helvetica','',9);
    $pdf->AjoutText(' ou votre tablette depuis l\'application Biletujo que vous pouvez télécharger en vous servant des QR ci-dessous. L\'.apk est également disponible sur ');
    $pdf->AjoutLien('https://com-chain.org','https://com-chain.org');
    $pdf->AjoutText('.');
    $pdf->SautDeLigne();



    $pdf->SetY(-46);

    $pdf->Image('resources/Biletujo_Android.png',45,208,40);
    $pdf->Image('resources/Biletujo_Apple.png',120,208,40);
    $pdf->AjoutText("L'");
    $pdf->SetFont('Helvetica','I',9);
    $pdf->SetTextColor(0,111,180);
    $pdf->Write(5,utf8_decode("AIDE du Léman électronique (App & Web App Biletujo)"),'https://wallet.monnaie-leman.org/files/help.pdf');
    $pdf->SetFont('Helvetica','',9);
    $pdf->SetTextColor(0,0,0);
    $pdf->AjoutText(" est accessible, depuis l'application, en cliquant sur l'icône d'aide.");
    $pdf->LigneVide();
    $pdf->AjoutText("Nous vous souhaitons d'heureuses transactions lémaniques !");
    $pdf->SetMargins(110,0,0);
    $pdf->SautDeLigne();
    $pdf-> AjoutText("Monnaie Léman");
    $pdf->SautDeLigne();
    $pdf-> AjoutText("Equipe Administration / IT");


    if ($do_output_file) {
        // save locally for emailing
        $local_file = './Data/img_'.$res['id'].'/Code_'.$res['code'].'.pdf';
        if (file_exists($local_file)){
            unlink($local_file);
        }
        $pdf->Output($local_file,'F');
    } else {
        // output
        $pdf->Output();
    }
}
?>
