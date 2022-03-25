<?php
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
?>
