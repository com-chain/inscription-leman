<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

$how_to_file ="./resources/Biletujo_Marche_a_suivre_creation_compte.pdf";

function getHtmlFooter() {
  return '<br/><br/>
<span class="" style="color: rgb(31, 87, 148);"></span>
<span style="color:#2f6aa6">
<b>Monnaie Léman</b><br/>
Rue des Savoises 15 |&nbsp;1205 Genève |&nbsp;
<a target="_blank" href="https://monnaie-leman.org/" style="color:#2f6aa6" >monnaie-leman.org</a>
</span>
<br/><br/>
<span style="color:#2f6aa6">
<b>Découvrez les&nbsp;
<a target="_blank" href="https://monnaie-leman.org/comment-ca-marche-carte-reseau" style="color:#2f6aa6">450 professionnels</a>&nbsp;qui acceptent les lémans&nbsp;!
</b><br/>
1600 membres | 10\'000&nbsp;utilisat-rice/eur-s&nbsp;|&nbsp;150\'000 lémans en circulation
</span>
<br/><br/><span style="color:#2f6aa6">
<b>Devenez&nbsp;
<a target="_blank" href="https://monnaie-leman.org/inscription/adhesion.php" style="color:#2f6aa6">membre ou sympathisant-e</a>&nbsp;! |&nbsp;Rejoignez nos groupes locaux !
</b>
<br/>
<br/>

<img apple-inline="yes" height="74" width="210" apple-width="yes" apple-height="yes" src="data:image/png;base64,R0lGODlh0gBKAPf/AABxuv///wBxuQBwufGLIQBwuvGKIQBhsQBltIKr2ABrt/3v4DqSyfrUrfCKIPKTMP748dzs9vOeRfnJmfjDjf3t3eXo9frRqPbw+VOSy/awaf/8+l2l0yR9wHSl1fe+g3u12/CKIfrauPOaPwBuuPGPKP3w4Rt0vHmm1QBarvnNofKRLvvewPzlzTuFxQBst63I5vGMJKvF5PWqXf35/fvev/jIlg5tuDKCw/zm0P759PKUMvjFkPOcQmyt1wByuvvcvPWsYfnQpf/+/f769vSkURp/wPa2dPnz+/769fzp1POfR/3y5/727vKXOPKQK/SoWP706frWsfSiTfa0cPSlU/nLnGGf0vzo09Pm8/3x5O3q9rvZ7PSgSZXE4unz+fKVNPSmVvDu+PaybGSXziR5vvvhxf717POYOvOhTKC94f3w4g95vqLL5vrZtv3r2ABntfrXsgBoth2BwrfX7P7z6PWuZPvfwvWpWhR8v/vdvuLo9f738POYO/jCiZG03aG63yWGxPObP7bJ583j8WCm1PnNnkqOyYux2wBjs//9/P3s2vGOJy1/wgBsuGyf0vziyIG53BN1vPCKIrHE5ABdsPKWN/r4/PSnWAVwurPN6PjHk9vj8oy/3//798PR6va4eJm73wt3vPOjT//+//SjUfOgS83W7LnK502Sy/CLIGip1RVvukGVy/GNJfe8f/GUNDePyfH3+/77/lmWzfrVr9nh8f7z50uJx73L6CuJxaXA4luazwduufCLIVah0Z3I5ABptfGMIxp7v0CHxvGLIIe83+Pv90aLyPOjUfe6fPz9/vvbuwJyuq/S6Z294D6JxwZ0vEOIx/a4dsDc7vn8/fOZPPe/hZnG40mazfGVNgVzu+zt+ApwujF+wZDB4cDO6dTc7wNotvzjyvzkzNjp9PazbgJxu5e13YS63g92vd/k89/n9fOlVA9yu/KVNwBiswBvuMrZ7ajP53Se0Yev2frTq8bf8PSoV/CLJAVruAtitAByuf3+/lOOyf///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InV1aWQ6NUQyMDg5MjQ5M0JGREIxMTkxNEE4NTkwRDMxNTA4QzgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QTREOTA1MjU0QUU3MTFFOEE2QzQ4NjIzMzU4MEZBNTYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTREOTA1MjQ0QUU3MTFFOEE2QzQ4NjIzMzU4MEZBNTYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgSWxsdXN0cmF0b3IgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RkQ3RjExNzQwNzIwNjgxMThDMTRDRUE3RjVCM0RENkQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RkM3RjExNzQwNzIwNjgxMThDMTRDRUE3RjVCM0RENkQiLz4gPGRjOnRpdGxlPiA8cmRmOkFsdD4gPHJkZjpsaSB4bWw6bGFuZz0ieC1kZWZhdWx0Ij5JbXByZXNzaW9uPC9yZGY6bGk+IDwvcmRmOkFsdD4gPC9kYzp0aXRsZT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u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" >
<br/>
<br/>

<b style="color:#ee8e29">FAIRE UN DON EN E-LEMAN</b>
<br/>
<span style="color:#2f6aa6">Depuis l\'App&nbsp;Biletujo, scannez notre clé publique (e-IBAN) !
<br/>(ou copiez-la:&nbsp;0x15a18329381cdf1919d51d05834920585066646f)</font>
</span>
<br/>
<br/>

<img apple-inline="yes"  height="90" width="90" apple-width="yes" apple-height="yes" src="data:image/png;base64,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">
<br/>
<br/>
<b style="color:#ee8e29">FAIRE UN DON EN MONNAIES ALTERNATIVES</b>
<br/><span style="color:#2f6aa6">IBAN&nbsp;Monnaie Léman&nbsp;Suisse (CHF): CH22 0839 0034 3841 1010 0<br/>
IBAN Monnaie Léman France (EUR):&nbsp;FR7613825002 0008 0092 2674 657</span>';
}

function gatAltFoolter() {
    return "
    
Monnaie Léman
Rue des Savoises 15 | 1205 Genève |  monnaie-leman.org

Découvrez les 450 professionnels qui acceptent les lémans !
1600 membres | 10'000 utilisat-rice/eur-s | 150'000 lémans en circulation

Devenez membre ou sympathisant-e ! | Rejoignez nos groupes locaux !

FAIRE UN DON EN E-LEMAN
Depuis l'App Biletujo, scannez notre clé publique (e-IBAN) !
(ou copiez-la: 0x15a18329381cdf1919d51d05834920585066646f)


FAIRE UN DON EN MONNAIES ALTERNATIVES
IBAN Monnaie Léman Suisse (CHF): CH22 0839 0034 3841 1010 0
IBAN Monnaie Léman France (EUR): FR7613825002 0008 0092 2674 657";
}

function getBody($name, $type) {
     if ($type==1) {
       
        return '<font face="HelveticaNeue-Light">

<span style="color:#2f6aa6" >Bonjour '.$name.'</span>,
<br/><br/>
Merci pour votre inscription !
<br/><br/>
Suivez ces 2 étapes:
<br/>
1.&nbsp;<span style="color:#2f6aa6">Créez</span>&nbsp;votre compte électronique&nbsp;depuis votre ordinateur sur la Web App&nbsp;
<a target="_blank" href="https://wallet.monnaie-leman.org/" style="color:#2f6aa6">Biletujo</a>&nbsp;
(<a target="_blank" href="https://wallet.monnaie-leman.org/" style="color:#2f6aa6">https://wallet.monnaie-leman.org</a>) avec ces&nbsp;2 documents (au format PDF):
<br/>
- un&nbsp;<i style="color:#2f6aa6">Code d\'autorisation personnel</i>,<br/>
- une&nbsp;<i style="color:#2f6aa6">Marche à suivre:&nbsp;création et synchronisation d\'un compte sur l\'application Biletujo</i>.<br/>
<br/>

2.&nbsp;<span style="color:#2f6aa6">Synchronisez</span>&nbsp;(le cas échéant) votre compte électronique sur vos autres appareils, smartphones et/ou tablettes.
<br/><br/>
<i >Extrait du document:</i> <i style="color:#2f6aa6">Marche à suivre:&nbsp;création et synchronisation d\'un compte sur l\'application Biletujo</i>:<br/>

<span style="color:#ee8e29">Monnaie Léman ne possède&nbsp;pas les mots de passe</span>.&nbsp;Vous seul-e-s en êtes responsable-s. Si vous le perdez, votre compte ne sera plus disponible. Nous vous conseillons de le sauvegarder à un endroit sécurisé et/ou de donner rapidement procuration à un proche sur votre compte.<br/>
<span style="color:#2f6aa6">Le ficher ".dat" que vous devez sauvegarder</span>, lors de l\'ouverture du compte ou une fois votre compte ouvert sur la page "Compte", vous permet de sauvegarder le contenu de votre compte en cas de perte de votre appareil&nbsp;(smartphone/ordinateur), mais aussi d\'installer votre compte sur plusieurs appareils de manière synchronisée.
<br/><br/>

Pour <span style="color:#2f6aa6">obtenir des e-lémans</span>, prière d\'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: "e-Léman"). Votre compte sera crédité dans les deux jours ouvrables.
<br/><br/>
Tout en vous souhaitant de belles affaires en lémans électroniques, nous vous adressons nos salutations les plus cordiales.'.getHtmlFooter().'</font>';
    } else {
      return '<font face="HelveticaNeue-Light">

<span style="color:#2f6aa6" >Bonjour '.$name.'</span>,
<br/><br/>
Merci pour votre inscription !
<br/><br/>
Suivez ces 2 étapes:
<br/>
1.&nbsp;<span style="color:#2f6aa6">Créez</span>&nbsp;votre compte électronique&nbsp;depuis votre ordinateur sur la Web App&nbsp;
<a target="_blank" href="https://wallet.monnaie-leman.org/" style="color:#2f6aa6">Biletujo</a>&nbsp;
(<a target="_blank" href="https://wallet.monnaie-leman.org/" style="color:#2f6aa6">https://wallet.monnaie-leman.org</a>) avec ces&nbsp;2 documents (au format PDF):
<br/>
- un&nbsp;<i style="color:#2f6aa6">Code d\'autorisation personnel</i>,<br/>
- une&nbsp;<i style="color:#2f6aa6">Marche à suivre:&nbsp;création et synchronisation d\'un compte sur l\'application Biletujo</i>.<br/>
<br/>

2.&nbsp;<span style="color:#2f6aa6">Synchronisez</span>&nbsp;(le cas échéant) votre compte électronique sur vos autres appareils, smartphones et/ou tablettes.
<br/><br/>
<i >Extrait du document:</i> <i style="color:#2f6aa6">Marche à suivre:&nbsp;création et synchronisation d\'un compte sur l\'application Biletujo</i>:<br/>

<span style="color:#ee8e29">Monnaie Léman ne possède&nbsp;pas les mots de passe</span>.&nbsp;Vous seul-e-s en êtes responsable-s. Si vous le perdez, votre compte ne sera plus disponible. Nous vous conseillons de le sauvegarder à un endroit sécurisé et/ou de donner rapidement procuration à un proche sur votre compte.<br/>
<span style="color:#2f6aa6">Le ficher ".dat" que vous devez sauvegarder</span>, lors de l\'ouverture du compte ou une fois votre compte ouvert sur la page "Compte", vous permet de sauvegarder le contenu de votre compte en cas de perte de votre appareil&nbsp;(smartphone/ordinateur), mais aussi d\'installer votre compte sur plusieurs appareils de manière synchronisée.
<br/><br/>

Pour <span style="color:#2f6aa6">obtenir des e-lémans</span>, prière d\'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: "e-Léman"). Votre compte sera crédité dans les deux jours ouvrables.
<br/><br/>
Tout en vous souhaitant de belles affaires en lémans électroniques, nous vous adressons nos salutations les plus cordiales.'.getHtmlFooter().'</font>';
    }
}

function getAltBody($name, $type) {
    if ($type==1) {
      return "Bonjour ".$name.",

Merci pour votre inscription !

Suivez ces 2 étapes:
1. Créez votre compte électronique depuis votre ordinateur sur la Web App  Biletujo  (https://wallet.monnaie-leman.org) avec ces 2 documents (au format PDF):
- un Code d'autorisation personnel,
- une Marche à suivre: création et synchronisation d'un compte sur l'application Biletujo.

2. Synchronisez (le cas échéant) votre compte électronique sur vos autres appareils, smartphones et/ou tablettes.

Extrait du document: \"Marche à suivre: création et synchronisation d'un compte sur l'application Biletujo\":
Monnaie Léman ne possède pas les mots de passe. Vous seul-e-s en êtes responsable-s. Si vous le perdez, votre compte ne sera plus disponible. Nous vous conseillons de le sauvegarder à un endroit sécurisé et/ou de donner rapidement procuration à un proche sur votre compte.
Le ficher \".dat\" que vous devez sauvegarder, lors de l'ouverture du compte ou une fois votre compte ouvert sur la page \"Compte\", vous permet de sauvegarder le contenu de votre compte en cas de perte de votre appareil (smartphone/ordinateur), mais aussi d'installer votre compte sur plusieurs appareils de manière synchronisée.

Pour obtenir des e-lémans, prière d'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: \"e-Léman\"). Votre compte sera crédité dans les deux jours ouvrables.

Tout en vous souhaitant de belles affaires en lémans électroniques, nous vous adressons nos salutations les plus cordiales.".gatAltFoolter();
    } else {
      return  "Bonjour ".$name.",

Merci pour votre inscription !

Suivez ces 2 étapes:
1. Créez votre compte électronique depuis votre ordinateur sur la Web App  Biletujo  (https://wallet.monnaie-leman.org) avec ces 2 documents (au format PDF):
- un Code d'autorisation personnel,
- une Marche à suivre: création et synchronisation d'un compte sur l'application Biletujo.

2. Synchronisez (le cas échéant) votre compte électronique sur vos autres appareils, smartphones et/ou tablettes.

Extrait du document: \"Marche à suivre: création et synchronisation d'un compte sur l'application Biletujo\":
Monnaie Léman ne possède pas les mots de passe. Vous seul-e-s en êtes responsable-s. Si vous le perdez, votre compte ne sera plus disponible. Nous vous conseillons de le sauvegarder à un endroit sécurisé et/ou de donner rapidement procuration à un proche sur votre compte.
Le ficher \".dat\" que vous devez sauvegarder, lors de l'ouverture du compte ou une fois votre compte ouvert sur la page \"Compte\", vous permet de sauvegarder le contenu de votre compte en cas de perte de votre appareil (smartphone/ordinateur), mais aussi d'installer votre compte sur plusieurs appareils de manière synchronisée.

Pour obtenir des e-lémans, prière d'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: \"e-Léman\"). Votre compte sera crédité dans les deux jours ouvrables.

Tout en vous souhaitant de belles affaires en lémans électroniques, nous vous adressons nos salutations les plus cordiales.".gatAltFoolter();
    }
    
}

function getSubject($type) {
    if ($type==1) {
        return 'Léman électronique: création de votre compte professionnel';
    } else {
        return 'Léman électronique: création de votre compte personnel';
    }
    
}


function sendConfirmationMail($to_address, $code_file, $name, $type) {
$from_address = 'ne-pas-repondre@monnaie-leman.org'; 
$from_name = 'Ne pas repondre - Monnaie Leman';  

$host = "myMailHost";
$host_login = $from_address;
$host_password = "myMailPassword";

$code_file_name ="Leman_electronique_Code_autorisation.pdf";
$how_to_file_name ="Marche_a_suivre_creation_compte.pdf";
$how_to_file ="./resources/Biletujo_Marche_a_suivre_creation_compte.pdf";


    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    // Enable verbose debug output
        $mail->isSMTP();                           
        $mail->Host       = $host;                   
        $mail->SMTPAuth   = true;                 // Enable SMTP authentication
        $mail->Username   = $host_login;                    
        $mail->Password   = $host_password;                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // for TLS =>  PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;                           // for TLS =>  587

        //Recipients
        $mail->setFrom($from_address, $from_name);
        $mail->addAddress($to_address);               // Name is optional
        // $mail->addReplyTo('reply@example.com', 'Name');
        // $mail->addCC('cc@example.com');
        $mail->addBCC($from_address);

        // Attachments
        $mail->addAttachment($code_file, $code_file_name, 'base64', 'application/pdf');         
        $mail->addAttachment($how_to_file, $how_to_file_name, 'base64', 'application/pdf');    

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = getSubject($type);
        $mail->Body    = getBody($name, $type);
        $mail->AltBody = getAltBody($name, $type);

        $mail->send();
   } catch (Exception $e) {
       throw new Exception('Mail Error :'.$mail->ErrorInfo);
   }

}



function getUnlockSubject($type) {
    if ($type==1) {
        return 'Léman électronique: activation de votre compte professionnel';
    } else {
        return 'Léman électronique: activation de votre compte personnel';
    }
}

function getUnlockBody($name, $type, $wallet) {
    if ($type==1) {
      return '<font face="HelveticaNeue-Light">

<span style="color:#2f6aa6" >Bonjour '.$name.'</span>,
<br/><br/>
Votre compte électronique <i style="color:#2f6aa6" >Biletujo</i> (Monnaie Léman)  <span style="color:#2f6aa6" >'.$wallet.'</span> est actif!
<br/><br/>
Vous pouvez désormais payer vos fournisseurs de manière électronique en utilisant leur clé publique se présentant:<br/>
- sous forme de QR code à scanner;<br/>
- sous forme d\'une suite de caractères (0x15a1...) à saisir;<br/>
ou, en sélectionnant la clé publique du fournisseur que vous aurez déjà enregistré dans vos contacts (pictogramme).
<br/><br/>
A l\'inverse, vous pouvez recevoir des lémans électroniques lorsque vos clients/membres utilisent votre clé publique:<br/>
- scannent votre QR code;<br/>
- saisissent la suite de caractères (0x15a1…) correspondante;<br/>
ou, vous sélectionnent parmi leurs contacts (pictogramme).
<br/><br/>
Un défraiement est facturé sur les transactions:<br/>
- 1% à la charge du vendeur dans le commerce de détail,<br/>
- 0.5% entre deux entreprises,<br/>
- 0% d\'une entreprise à un particulier (salaire) ou entre deux particuliers.
<br/><br/>
Vous trouverez les <span style="color:#2f6aa6">commerces et entreprises</span> qui pourront vous accueillir et accepter vos lémans électroniques sur la <a target="_blank" href="https://monnaie-leman.org/comment-ca-marche-carte-reseau" style="color:#2f6aa6">Carte du réseau</a> de notre <a target="_blank" href="https://monnaie-leman.org" style="color:#2f6aa6">site Internet</a> (voir rubrique MOYEN DE PAIEMENT).
<br/><br/>
Pour <span style="color:#2f6aa6">obtenir des e-lémans</span>, prière d\'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: "e-Léman"). Votre compte sera crédité dans les deux jours ouvrables.
<br/><br/>
Nous vous conseillons également d\'<a target="_blank" href="https://monnaie-leman.org/inscription/inscription.php" style="color:#2f6aa6">ouvrir un compte personnel</a> sans frais pour les particuliers ainsi vous pourrez vous verser une partie de votre salaire et faire vos achats privés.
<br/><br/>
Tout en vous souhaitant du plaisir avec les lémans électroniques, nous vous adressons nos salutations les plus cordiales.'.getHtmlFooter().'</font>';
    } else  {
      return '<font face="HelveticaNeue-Light">

<span style="color:#2f6aa6" >Bonjour '.$name.'</span>,
<br/><br/>
Votre compte électronique <i style="color:#2f6aa6" >Biletujo</i> (Monnaie Léman)  <span style="color:#2f6aa6" >'.$wallet.'</span> est actif!
<br/><br/>
Pour <span style="color:#2f6aa6">obtenir des e-lémans</span>, prière d\'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: "e-Léman"). Votre compte sera crédité dans les deux jours ouvrables.
<br/><br/>
Vous trouverez les <span style="color:#2f6aa6">commerces et entreprises</span> qui pourront vous accueillir et accepter vos lémans électroniques sur la <a target="_blank" href="https://monnaie-leman.org/comment-ca-marche-carte-reseau" style="color:#2f6aa6">Carte du réseau</a> de notre <a target="_blank" href="https://monnaie-leman.org" style="color:#2f6aa6">site Internet</a> (voir rubrique MOYEN DE PAIEMENT).
<br/><br/>
Savez-vous que vous pouvez demander de recevoir une partie de votre salaire en lémans ?<br/>
(Nous avons préparé une lettre type si besoin.)
<br/><br/>
Nous restons bien volontiers à votre disposition pour tout complément d\'information.
<br/><br/>
Avec nos salutations cordiales.'.getHtmlFooter().'</font>';
    } 
  
}

function getUnlockAltBody($name, $type, $wallet) {
    if ($type==1) {
      return "Bonjour ".$name.",
        
Votre compte électronique Biletujo (Monnaie Léman) ".$wallet." est actif!

Vous pouvez désormais payer vos fournisseurs de manière électronique en utilisant leur clé publique se présentant:
- sous forme de QR code à scanner;
- sous forme d'une suite de caractères (0x15a1...) à saisir;
ou, en sélectionnant la clé publique du fournisseur que vous aurez déjà enregistré dans vos contacts (pictogramme).

A l'inverse, vous pouvez recevoir des lémans électroniques lorsque vos clients/membres utilisent votre clé publique:
- scannent votre QR code;
- saisissent la suite de caractères (0x15a1…) correspondante;
ou, vous sélectionnent parmi leurs contacts (pictogramme).

Un défraiement est facturé sur les transactions:
- 1% à la charge du vendeur dans le commerce de détail,
- 0.5% entre deux entreprises,
- 0% d'une entreprise à un particulier (salaire) ou entre deux particuliers.

Vous trouverez les commerces et entreprises avec qui vous pourrez échanger des lémans électroniques sur la Carte du réseau de notre site Internet (https://monnaie-leman.org voir rubrique MOYEN DE PAIEMENT).

Pour obtenir des e-lémans, prière d'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: \"e-Léman\"). Votre compte sera crédité dans les deux jours ouvrables.

Nous vous conseillons également d'ouvrir un compte personnel sans frais pour les particuliers ainsi vous pourrez vous verser une partie de votre salaire et faire vos achats privés.

Tout en vous souhaitant du plaisir avec les lémans électroniques, nous vous adressons nos salutations les plus cordiales.".gatAltFoolter();
    } else {
      return  "Bonjour ".$name.",
        
Votre compte électronique Biletujo (Monnaie Léman) ".$wallet." est actif!

Pour obtenir des e-lémans, prière d'effectuer un versement sur le compte de Monnaie Léman à la Banque Alternative Suisse (IBAN: CH49 0839 0034 3841 1000 2, mention: \"e-Léman\"). Votre compte sera crédité dans les deux jours ouvrables.

Vous trouverez les commerces et entreprises qui pourront vous accueillir et accepter vos lémans électroniques sur la Carte du réseau de notre site Internet (https://monnaie-leman.org voir rubrique MOYEN DE PAIEMENT).

Savez-vous que vous pouvez demander de recevoir une partie de votre salaire en lémans ?
(Nous avons préparé une lettre type si besoin.)

Nous restons bien volontiers à votre disposition pour tout complément d'information.".gatAltFoolter();
    }}


function sendUnlockingMail($to_address, $wallet, $name, $type) {
    $from_address = 'ne-pas-repondre@monnaie-leman.org'; 
    $from_name = 'Ne pas repondre - Monnaie Leman';  

    $host = "myMailHost";
    $host_login = $from_address;
    $host_password = "myMailPassword";

  

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    // Enable verbose debug output
        $mail->isSMTP();                           
        $mail->Host       = $host;                   
        $mail->SMTPAuth   = true;                 // Enable SMTP authentication
        $mail->Username   = $host_login;                    
        $mail->Password   = $host_password;                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // for TLS =>  PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;                           // for TLS =>  587

        //Recipients
        $mail->setFrom($from_address, $from_name);
        $mail->addAddress($to_address);               // Name is optional
        // $mail->addReplyTo('reply@example.com', 'Name');
        // $mail->addCC('cc@example.com');
        $mail->addBCC($from_address);

       
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = getUnlockSubject($type);
        $mail->Body    = getUnlockBody($name, $type, $wallet);
        $mail->AltBody = getUnlockAltBody($name, $type, $wallet);

        $mail->send();
   } catch (Exception $e) {
       throw new Exception('Mail Error :'.$mail->ErrorInfo);
   }
}

?>
