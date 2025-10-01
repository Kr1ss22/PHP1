<?php
// ==================================================
// OSTUKORVI LEHT - siin saab vaadata ja muuta ostukorvi sisu
// ==================================================

// Määrame lehe pealkirja
$lehe_pealkiri = "Ostukorv";

// Lisame ühise päise faili (navigatsioon, CSS lingid jne)
include "pais.php";

// Loome muutujad teadete jaoks
$eduteade = "";  // Roheline teade (edukas toiming)
$veateade = "";  // Punane teade (viga)

// ==================================================
// KASUTAJA TOIMINGUTE TÖÖTLEMINE
// ==================================================
// Kui kasutaja on midagi teinud (nuppu vajutanud), siis töötleme seda

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Kontrollime millist nuppu kasutaja vajutas
    
    // 1. KAS KASUTAJA TAHAB TOODET EEMALDADA?
    if (isset($_GET["eemaldamine"])) {
        // Võtame toote võtme (ID)
        $toote_voti = $_GET["toote_voti"];
        
        // Kontrollime kas see toode on tõesti ostukorvis
        if (isset($_SESSION["ostukorv"][$toote_voti])) {
            // Eemaldame toote ostukorvist
            unset($_SESSION["ostukorv"][$toote_voti]);
            $eduteade = "Toode on eemaldatud!";
        }
    } 
    
    // 2. KAS KASUTAJA TAHAB KOGU OSTUKORVI TÜHJENDADA?
    elseif (isset($_GET["tyhjendamine"])) {
        // Teeme ostukorvi tühjaks
        $_SESSION["ostukorv"] = [];
        $eduteade = "Ostukorv on tühjendatud!";
    } 
    
    // 3. KAS KASUTAJA TAHAB TOOTE KOGUST MUUTA?
    elseif (isset($_GET["koguse_muutmine"])) {
        $toote_voti = $_GET["toote_voti"];
        $uus_kogus = (int)$_GET["kogus"];  // Muudame numbri täisarvuks
        
        if ($uus_kogus > 0) {
            // Kui kogus on suurem kui 0, siis uuendame
            $_SESSION["ostukorv"][$toote_voti]["kogus"] = $uus_kogus;
            $eduteade = "Kogus on uuendatud!";
        } else {
            // Kui kogus on 0, siis eemaldame toote
            unset($_SESSION["ostukorv"][$toote_voti]);
            $eduteade = "Toode on eemaldatud!";
        }
    // 4. KAS KASUTAJA TAHAB TELLIMUST VORMISTADA?
    elseif (isset($_GET["vormista_tellimus"])) {
        // TELLIMUSE VORMISTAMINE
        
        // Kontrollime kas ostukorvis on midagi
        if (isset($_SESSION["ostukorv"]) && !empty($_SESSION["ostukorv"])) {
            
            // Võtame kliendi andmed vormist
            $eesnimi = isset($_GET["eesnimi"]) ? trim($_GET["eesnimi"]) : "";
            $perenimi = isset($_GET["perenimi"]) ? trim($_GET["perenimi"]) : "";
            $email = isset($_GET["email"]) ? trim($_GET["email"]) : "";
            
            // Kontrollime kas kõik väljad on täidetud
            if (empty($eesnimi) || empty($perenimi) || empty($email)) {
                $veateade = "Palun täida kõik väljad!";
            } else {
                // TELLIMUSE KOODI GENEREERIMINE
                // Kood näeb välja nagu: 2025100101 (aasta + kuu + päev + järjekord)
                
                $aasta = date("Y");    // 2025
                $kuu = date("m");      // 10 (oktoober)
                $paev = date("d");     // 01
                
                // Loeme mitu tellimust on täna juba tehtud
                $tanahased_tellimused = 0;
                $tanane_kuupaev = date("Y-m-d");  // 2025-10-01
                
                // Kui orders.txt fail on olemas, siis loeme sealt
                if (file_exists("orders.txt")) {
                    $faili_sisu = file_get_contents("orders.txt");
                    // Loeme mitu korda esineb tänast kuupäeva
                    $tanahased_tellimused = substr_count($faili_sisu, "KUUPÄEV: " . $tanane_kuupaev);
                }
                
                // Järgmine tellimus on +1
                $jargmine_number = $tanahased_tellimused + 1;
                
                // Teeme tellimuse koodi: 2025100101, 2025100102 jne
                $tellimuse_kood = $aasta . $kuu . $paev . sprintf("%02d", $jargmine_number);
                
                // TELLIMUSE ANDMETE KOOSTAMINE
                $tellimuse_kuupaev = date("Y-m-d H:i:s");
                $tellimuse_sisu = "TELLIMUS: " . $tellimuse_kood . "\n";
                $tellimuse_sisu .= "KUUPÄEV: " . $tanane_kuupaev . " " . date("H:i:s") . "\n";
                $tellimuse_sisu .= "KLIENT: " . $eesnimi . " " . $perenimi . "\n";
                $tellimuse_sisu .= "EMAIL: " . $email . "\n";
                $tellimuse_sisu .= "=====================================\n";
                
                // TOODETE LOETELU KOOSTAMINE
                $kogusumma = 0;
                foreach ($_SESSION["ostukorv"] as $toode) {
                    $summa = $toode["hind"] * $toode["kogus"];  // Arvutame toote kogusumma
                    $kogusumma += $summa;  // Liidame üldsummale
                    
                    // Lisame toote info tellimuse tekstile
                    $tellimuse_sisu .= $toode["nimi"] . " - " . $toode["kogus"] . " " . $toode["yhik"] . " x " . $toode["hind"] . "€ = " . number_format($summa, 2) . "€\n";
                }
                
                // Lisame kogusumma
                $tellimuse_sisu .= "-------------------------------------\n";
                $tellimuse_sisu .= "KOKKU: " . number_format($kogusumma, 2) . "€\n";
                $tellimuse_sisu .= "=====================================\n\n";
                
                // TELLIMUSE SALVESTAMINE FAILI
                $fail_link = fopen("orders.txt", "a");  // "a" tähendab lisa faili lõppu
                if ($fail_link !== FALSE) {
                    fwrite($fail_link, $tellimuse_sisu);  // Kirjutame andmed faili
                    fclose($fail_link);  // Sulgeme faili
                    
                    // Tühjendame ostukorvi pärast edukat tellimust
                    $_SESSION["ostukorv"] = [];
                    $eduteade = "Tellimus on edukalt vormistatud! Tellimuse kood: " . $tellimuse_kood . ". Täname, " . $eesnimi . "!";
                } else {
                    $veateade = "Viga tellimuse salvestamisel!";
                }
            }
        } else {
            $veateade = "Ostukorv on tühi!";
        }
    }
}

// ==================================================
// KOGUSUMMA ARVUTAMINE
// ==================================================
// Arvutame välja mitu eurot on ostukorvis kokku

$kogusumma = 0;  // Alustame nullist

// Kui ostukorv on olemas ja pole tühi
if (isset($_SESSION["ostukorv"]) && !empty($_SESSION["ostukorv"])) {
    // Käime kõik tooted läbi
    foreach ($_SESSION["ostukorv"] as $toode) {
        // Iga toote puhul: hind × kogus = summa
        $kogusumma += $toode["hind"] * $toode["kogus"];
    }
}
?>

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center mb-5">Ostukorv</h1>
                
                <!-- EDUKA TOIMINGU TEADE (roheline) -->
                <?php if (!empty($eduteade)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($eduteade); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <!-- VEATEAD (punane) -->
                <?php if (!empty($veateade)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($veateade); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <!-- KUI OSTUKORVIS ON TOOTEID -->
                <?php if (isset($_SESSION["ostukorv"]) && !empty($_SESSION["ostukorv"])): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- TOODETE TABEL -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Toode</th>
                                        <th>Hind</th>
                                        <th>Kogus</th>
                                        <th>Summa</th>
                                        <th>Toimingud</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- KÄIME KÕIK OSTUKORVI TOOTED LÄBI -->
                                    <?php foreach ($_SESSION["ostukorv"] as $voti => $toode): ?>
                                    <tr>
                                        <!-- TOOTE NIMI JA ÜHIK -->
                                        <td>
                                            <strong><?php echo htmlspecialchars($toode["nimi"]); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($toode["yhik"]); ?></small>
                                        </td>
                                        
                                        <!-- TOOTE HIND -->
                                        <td><?php echo number_format($toode["hind"], 2, ",", " "); ?>€</td>
                                        
                                        <!-- KOGUSE MUUTMISE VORM -->
                                        <td>
                                            <form method="GET" class="d-inline">
                                                <!-- Peidetud väli, et server teaks millist toodet muudame -->
                                                <input type="hidden" name="toote_voti" value="<?php echo $voti; ?>">
                                                <div class="input-group" style="width: 120px;">
                                                    <!-- Numbri sisestamise väli -->
                                                    <input type="number" class="form-control form-control-sm" 
                                                           name="kogus" value="<?php echo $toode["kogus"]; ?>" 
                                                           min="0" max="999">
                                                    <!-- Kinnitamise nupp -->
                                                    <button type="submit" name="koguse_muutmine" 
                                                            class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        
                                        <!-- TOOTE KOGUSUMMA (hind × kogus) -->
                                        <td>
                                            <strong><?php echo number_format($toode["hind"] * $toode["kogus"], 2, ",", " "); ?>€</strong>
                                        </td>
                                        
                                        <!-- EEMALDAMISE NUPP -->
                                        <td>
                                            <form method="GET" class="d-inline">
                                                <input type="hidden" name="toote_voti" value="<?php echo $voti; ?>">
                                                <button type="submit" name="eemaldamine" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Kas oled kindel?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                
                                <!-- TABELI JALUS - KOGUSUMMA -->
                                <tfoot>
                                    <tr class="table-primary">
                                        <th colspan="3">KOKKU:</th>
                                        <th><?php echo number_format($kogusumma, 2, ",", " "); ?>€</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- OSTUKORVI TOIMINGUTE NUPUD -->
                        <div class="d-flex justify-content-between mt-4">
                            <!-- OSTUKORVI TÜHJENDAMISE NUPP -->
                            <form method="GET">
                                <button type="submit" name="tyhjendamine" 
                                        class="btn btn-outline-danger"
                                        onclick="return confirm('Kas tühjendad kogu ostukorvi?')">
                                    <i class="bi bi-trash"></i> Tühjenda ostukorv
                                </button>
                            </form>
                            
                            <!-- PAREMALE POOL: OSTLEMISE JÄTKAMINE JA TELLIMUSE VORMISTAMINE -->
                            <div>
                                <!-- TAGASI TOODETE LEHELE -->
                                <a href="tooted.php" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-arrow-left"></i> Jätka ostlemist
                                </a>
                                
                                <!-- TELLIMUSE VORMISTAMISE NUPP (avab modali) -->
                                <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="bi bi-credit-card"></i> Vormista tellimus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ==================================================
                     TELLIMUSE VORMISTAMISE MODAL (hüpikaken)
                     ================================================== -->
                <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- VORM KLIENDI ANDMETE SISESTAMISEKS -->
                            <form method="GET">
                                <!-- MODALI PÄIS -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderModalLabel">Tellimuse vormistamine</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <!-- MODALI SISU -->
                                <div class="modal-body">
                                    <p class="text-muted mb-4">Palun sisesta oma andmed tellimuse vormistamiseks:</p>
                                    
                                    <!-- EESNIME VÄLI -->
                                    <div class="mb-3">
                                        <label for="eesnimi" class="form-label">Eesnimi *</label>
                                        <input type="text" class="form-control" id="eesnimi" name="eesnimi" required>
                                    </div>
                                    
                                    <!-- PERENIME VÄLI -->
                                    <div class="mb-3">
                                        <label for="perenimi" class="form-label">Perenimi *</label>
                                        <input type="text" class="form-control" id="perenimi" name="perenimi" required>
                                    </div>
                                    
                                    <!-- E-MAILI VÄLI -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    
                                    <!-- TELLIMUSE KOGUSUMMA -->
                                    <div class="alert alert-info">
                                        <strong>Tellimuse kogusumma: <?php echo number_format($kogusumma, 2, ",", " "); ?>€</strong>
                                    </div>
                                </div>
                                
                                <!-- MODALI JALUS NUPPUDEGA -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tühista</button>
                                    <button type="submit" name="vormista_tellimus" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Kinnita tellimus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- KUI OSTUKORV ON TÜHI -->
                <?php else: ?>
                <div class="text-center">
                    <div class="card">
                        <div class="card-body py-5">
                            <!-- TÜHJA OSTUKORVI IKOON -->
                            <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
                            <h3>Ostukorv on tühi</h3>
                            <p class="text-muted mb-4">Lisa tooteid ostukorvi, et jätkata ostlemist.</p>
                            <!-- NUPP TOODETE LEHELE MINEMISEKS -->
                            <a href="tooted.php" class="btn btn-primary btn-lg">
                                <i class="bi bi-box"></i> Vaata tooteid
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php 
// Lisame ühise jaluse faili (footer, JavaScript lingid jne)
include "jalus.php"; 
?>
