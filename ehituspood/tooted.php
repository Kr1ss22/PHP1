<?php
// ==================================================
// TOODETE LEHT - siin näidatakse kõiki ehitusmaterjale
// ==================================================

// Määrame lehe pealkirja
$lehe_pealkiri = "Tooted";

// Lisame ühise päise faili (navigatsioon, CSS lingid jne)
include "pais.php";

// Kontrollime kas on teade sessionist (näiteks "Toode lisatud ostukorvi!")
if (isset($_SESSION["teade"])) {
    $teade = $_SESSION["teade"];  // Võtame teate
    unset($_SESSION["teade"]);   // Kustutame teate, et see ei kordeks
}
?>

<main>
    <div class="container my-5">
        <h1 class="text-center mb-5">Meie tooted</h1>
        
        <!-- EDUKATEADE (kui toode lisati ostukorvi) -->
        <?php if (isset($teade)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($teade); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <!-- OTSINGUVÄLI -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form method="GET">
                    <div class="input-group">
                        <!-- Otsingu sisestusväli -->
                        <input type="text" class="form-control" name="otsing" 
                               placeholder="Otsi tooteid..." 
                               value="<?php echo isset($_GET["otsing"]) ? htmlspecialchars($_GET["otsing"]) : ""; ?>">
                        
                        <!-- Otsingununupp -->
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Otsi
                        </button>
                        
                        <!-- Tühistamise nupp (nähtav ainult kui otsitakse) -->
                        <?php if (isset($_GET["otsing"]) && !empty($_GET["otsing"])): ?>
                        <a href="tooted.php" class="btn btn-outline-secondary">Tühista</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="row"><?php
            // ==================================================
            // TOODETE LAADIMINE FAILIST
            // ==================================================
            
            $tooted_massiiv = [];  // Alustame tühja massiiviga
            
            // Avame materjalid.csv faili lugemiseks
            $fail_link = fopen("materjalid.csv", "r");
            
            if ($fail_link !== FALSE) {  // Kui fail avas edukalt
            if ($fail_link !== FALSE) {  // Kui fail avas edukalt
                // Loeme esimese rea (päised: toote_nimi, hind, ühik jne)
                $paised = fgetcsv($fail_link, 1000, ";");
                
                // Loeme kõik järgmised read (tooted)
                while (($andmed = fgetcsv($fail_link, 1000, ";")) !== FALSE) {
                    // Kombineerime päised ja andmed üheks massiiviks
                    // Näiteks: ["toote_nimi" => "Tsement", "hind" => "15.50", "ühik" => "kg"]
                    $tooted_massiiv[] = array_combine($paised, $andmed);
                }
                fclose($fail_link);  // Sulgeme faili
                
                // ==================================================
                // OTSINGUFUNKTSIONAALSUS
                // ==================================================
                
                $otsingu_sonad = "";
                if (isset($_GET["otsing"]) && !empty($_GET["otsing"])) {
                    $otsingu_sonad = strtolower(trim($_GET["otsing"]));  // Muudame väiketähtedeks
                    
                    // Filtreerime tooted - jätame ainult need, mille nimes on otsisõna
                    $tooted_massiiv = array_filter($tooted_massiiv, function($toode) use ($otsingu_sonad) {
                        $toote_nimi = strtolower($toode["toote_nimi"]);
                        return strpos($toote_nimi, $otsingu_sonad) !== false;  // Kas nimi sisaldab otsisõna?
                    });
                }
                
                // Võtame ainult esimesed 12 toodet (et leht ei ole liiga pikk)
                $tooted_massiiv = array_slice($tooted_massiiv, 0, 12);
                
                // Pildi ID (et igal tootel oleks erinev pilt)
                $pildi_id = 100;
                
                // ==================================================
                // TOODETE KUVAMINE
                // ==================================================
                
                // Käime kõik tooted läbi ja näitame neid
                foreach ($tooted_massiiv as $yks_toode):
                    // Genereerime juhusliku pildi URL-i
                    $pildi_url = "https://picsum.photos/300/200?random=" . $pildi_id++;
            ?>
            <!-- ÜKS TOODE (Bootstrap card) -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <!-- TOOTE PILT -->
                    <img src="<?php echo $pildi_url; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($yks_toode["toote_nimi"]); ?>" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <!-- TOOTE NIMI -->
                        <h5 class="card-title"><?php echo htmlspecialchars($yks_toode["toote_nimi"]); ?></h5>
                        
                        <!-- TOOTE KIRJELDUS (sama kõigil) -->
                        <p class="card-text text-muted small mb-3">Kvaliteetne ehitusmaterjal professionaalseks kasutamiseks.</p>
                        
                        <div class="mt-auto">
                            <!-- HIND JA ÜHIK -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 text-primary mb-0"><?php echo $yks_toode["hind"]; ?>€</span>
                                <small class="text-muted"><?php echo $yks_toode["ühik"]; ?></small>
                            </div>
                            
                            <!-- OSTUKORVI LISAMISE VORM -->
                            <form method="GET" action="ostukorvi_lisamine.php" class="d-grid">
                                <!-- Peidetud väljad toote andmetega -->
                                <input type="hidden" name="toote_nimi" value="<?php echo htmlspecialchars($yks_toode["toote_nimi"]); ?>">
                                <input type="hidden" name="hind" value="<?php echo $yks_toode["hind"]; ?>">
                                <input type="hidden" name="yhik" value="<?php echo $yks_toode["ühik"]; ?>">
                                
                                <!-- LISA OSTUKORVI NUPP -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-plus"></i> Lisa ostukorvi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;  // Lõpetame toodete läbikäimise
                
                // ==================================================
                // KUI TOOTEID EI LEITUD
                // ==================================================
                if (empty($tooted_massiiv)):
            ?>
            <!-- TOODETE MITTELEIUMISE TEADE -->
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>Tooteid ei leitud</h4>
                    <p>Proovige muuta otsingusõna või <a href="tooted.php">vaadake kõiki tooteid</a>.</p>
                </div>
            </div>
            <?php 
                endif;  // Lõpetame toodete puudumise kontrollimise
            } else {
                // Kui fail ei avanenud
                echo "<div class=\"col-12\"><div class=\"alert alert-danger\">Toodete fail ei ole kättesaadav.</div></div>";
            }
            ?>
        </div>
        
        <!-- OTSINGUTULEMUSTE INFO -->
        <?php if (isset($_GET["otsing"]) && !empty($_GET["otsing"]) && !empty($tooted_massiiv)): ?>
        <div class="text-center mt-4">
            <p class="text-muted">
                Leiti <?php echo count($tooted_massiiv); ?> toodet otsingule: 
                <strong>"<?php echo htmlspecialchars($_GET["otsing"]); ?>"</strong>
            </p>
        </div>
        <?php endif; ?>
        
        <!-- TAGASI AVALEHELE NUPP -->
        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-house"></i> Tagasi avalehele
            </a>
        </div>
    </div>
</main>

<?php 
// Lisame ühise jaluse faili (footer, JavaScript lingid jne)
include "jalus.php"; 
?>
