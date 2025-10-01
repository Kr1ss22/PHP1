<?php
// ==================================================
// OSTUKORVI LISAMINE - siia suunatakse kui vajutatakse "Lisa ostukorvi"
// ==================================================

// session_start() peab olema faili alguses, et kasutada $_SESSION muutujat
// $_SESSION hoiab andmeid serveri poolel terve veebilehe kasutamise ajal
session_start();

// ==================================================
// TOOTE LISAMINE OSTUKORVI
// ==================================================

// Kontrollime kas vormiandmed saadeti GET meetodiga
// GET meetod edastab andmed URL parameetrite kaudu (nähtavad aadressireal)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Kontrollime kas ostukorv on juba olemas, kui mitte, siis loome selle
    if (!isset($_SESSION['ostukorv'])) {
        // Loome tühja massiivi ostukorvi jaoks
        $_SESSION['ostukorv'] = [];
    }
    
    // ==================================================
    // VORMIST TULEVATE ANDMETE KONTROLLIMINE
    // ==================================================
    
    // Kontrollime, kas kõik vajalikud andmed on saadetud
    $andmed_olemas = isset($_GET['toote_nimi']) && isset($_GET['hind']) && isset($_GET['yhik']);
    
    if ($andmed_olemas) {
        // ==================================================
        // ANDMETE PUHASTAMINE JA ETTEVALMISTAMINE
        // ==================================================
        
        // Võtame vormist andmed ja puhastame need
        // trim() eemaldab tyhjad tähemärgid algusest ja lopust
        $toote_nimi = trim($_GET['toote_nimi']);
        
        // floatval() muudab teksti komakohaga arvuks (15.50 → 15.5)
        $toote_hind = floatval($_GET['hind']);
        
        // Määrame koguse vaikimisi 1-ks (kui pole määratud)
        $toote_kogus = isset($_GET['kogus']) ? intval($_GET['kogus']) : 1;
        
        // Võtame ühiku (kg, tk, m² jne)
        $toote_yhik = isset($_GET['yhik']) ? trim($_GET['yhik']) : '';
        
        // ==================================================
        // UNIKAALSE VÕTME LOOMINE
        // ==================================================
        
        // Loome unikaalse võtme toote jaoks
        // md5() loob räsi toote nimest - see on alati sama sama nime korral
        // Näiteks: "Tsement" → "8a7b9c5d..."
        $toote_voti = md5($toote_nimi);
        
        // ==================================================
        // TOOTE LISAMINE VÕI KOGUSE SUURENDAMINE
        // ==================================================
        
        // Kontrollime kas toode on juba ostukorvis
        if (isset($_SESSION['ostukorv'][$toote_voti])) {
            // Kui toode on juba olemas, siis suurendame kogust
            $_SESSION['ostukorv'][$toote_voti]['kogus'] += $toote_kogus;
        } else {
            // Kui toode pole veel ostukorvis, siis lisame uue toote
            $_SESSION['ostukorv'][$toote_voti] = [
                'nimi' => $toote_nimi,     // Toote nimi
                'hind' => $toote_hind,     // Toote hind
                'kogus' => $toote_kogus,   // Kogus (tavaliselt 1)
                'yhik' => $toote_yhik      // Ühik (kg, tk jne)
            ];
        }
        
        // Määrame eduka teate
        $teade_tekst = 'Toode lisatud ostukorvi!';
        
    } else {
        // Kui kõik andmed pole olemas
        $teade_tekst = 'Viga toote lisamisel!';
    }
}

// ==================================================
// KASUTAJA TAGASISUUNAMINE
// ==================================================

// Suuname kasutaja tagasi eelmisele lehele
// $_SERVER['HTTP_REFERER'] sisaldab eelmise lehe aadressi
// Kui seda pole, siis läheme toodete lehele
$tagasi_lehele = $_SERVER['HTTP_REFERER'] ?? 'tooted.php';

// header() funktsioon suunab kasutaja teisele lehele
// See peab olema enne HTML-i väljastamist!
header("Location: $tagasi_lehele");

// exit() lõpetab skripti töö - oluline suunamise järel
// Ilma selleta jätkuks PHP kood töötamist
exit();
?>