<?php
// ==================================================
// EHITUSMATERJALIDE KALKULAATOR
// ==================================================
// Siin saab arvutada välja millised materjalid ja kui palju on vaja
// erinevat tüüpi ehitustööde jaoks (vundament, seinad, katus)

// Määrame lehe pealkirja
$lehe_pealkiri = "Kalkulaator";

// Lisame ühise päise faili (navigatsioon, CSS lingid jne)
include "pais.php";

// Muutuja kalkulatsiooni tulemuste jaoks
$arvutuse_tulemus = null;  // Algul pole tulemusi

// ==================================================
// VORMI TÖÖTLEMINE - käivitatakse kui kasutaja vajutab "Arvuta materjalid"
// ==================================================

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["pindala"])) {
    
    // ==================================================
    // ANDMETE LUGEMINE VORMIST
    // ==================================================
    
    // Võtame kasutaja sisestatud andmed vormist
    $sisestatud_pindala = floatval($_GET["pindala"]);    // Pindala meetrites (nt 25.5)
    $valitud_tyyp = $_GET["tyyp"];                       // Ehituse tüüp (vundament/seinad/katus)
    $pusikliendi_soodustus = isset($_GET["pusiklient"]); // Kas märgitud püsikliendi checkbox?
    
    // Kontrollime kas pindala on suurem kui 0
    if ($sisestatud_pindala > 0) {
        
        // ==================================================
        // MATERJALIDE NIMEKIRJA KOOSTAMINE
        // ==================================================
        
        // Loome tühja massiivi materjalide jaoks
        $materjalide_nimekiri = [];
        
        // Vastavalt valitud tüübile määrame vajalikud materjalid ja kogused
        switch($valitud_tyyp) {
        // Vastavalt valitud tüübile määrame vajalikud materjalid ja kogused
        switch($valitud_tyyp) {
            // VUNDAMENDI MATERJALID
            case "vundament":
                $materjalide_nimekiri = [
                    // Betoon: 0.3 kuupmeetrit iga ruutmeetri kohta
                    ["nimi" => "Betoon", "kogus" => $sisestatud_pindala * 0.3, "yhik" => "m³", "hind" => 95.00],
                    // Armatuur: 8 meetrit iga ruutmeetri kohta  
                    ["nimi" => "Armatuur", "kogus" => $sisestatud_pindala * 8, "yhik" => "m", "hind" => 1.85],
                ];
                break;
                
            // SEINTE MATERJALID
            case "seinad":
                $materjalide_nimekiri = [
                    // Plokid: 12.5 tükki iga ruutmeetri kohta
                    ["nimi" => "Plokid", "kogus" => $sisestatud_pindala * 12.5, "yhik" => "tk", "hind" => 3.20],
                    // Krohv: 3 kg iga ruutmeetri kohta
                    ["nimi" => "Krohv", "kogus" => $sisestatud_pindala * 3, "yhik" => "kg", "hind" => 8.90],
                ];
                break;
                
            // KATUSE MATERJALID  
            case "katus":
                $materjalide_nimekiri = [
                    // Katuseplaadid: 1.15 ruutmeetrit iga ruutmeetri kohta (juurde 15% kadu)
                    ["nimi" => "Katuseplaadid", "kogus" => $sisestatud_pindala * 1.15, "yhik" => "m²", "hind" => 15.75],
                    // Puitmaterjal: 0.8 kuupmeetrit iga ruutmeetri kohta
                    ["nimi" => "Puitmaterjal", "kogus" => $sisestatud_pindala * 0.8, "yhik" => "m³", "hind" => 4.20],
                ];
                break;
        }
        
        // ==================================================
        // SUMMADE ARVUTAMINE
        // ==================================================
        
        $kogu_summa = 0;    // Lõplik summa (võib olla soodustusega)
        $algne_summa = 0;   // Algne summa (enne soodustust)
        
        // Käime kõik materjalid läbi ja arvutame igaühe summa
        foreach ($materjalide_nimekiri as &$yks_materjal) {
            // Iga materjali summa = kogus × hind
            $yks_materjal["summa"] = $yks_materjal["kogus"] * $yks_materjal["hind"];
            
            // Liidame algse summa juurde
            $algne_summa += $yks_materjal["summa"];
        }
        
        // ==================================================
        // PÜSIKLIENDI SOODUSTUSE ARVUTAMINE
        // ==================================================
        
        // Kui kasutaja on püsiklient, anname 10% soodustust
        if ($pusikliendi_soodustus) {
            $kogu_summa = $algne_summa * 0.9;  // 90% algsest summast = 10% soodustus
        } else {
            $kogu_summa = $algne_summa;        // Soodustust pole
        }
        
        // ==================================================
        // TULEMUSTE KOKKUPANEK
        // ==================================================
        
        // Paneme kõik arvutuse andmed ühte massiivi
        $arvutuse_tulemus = [
            "materjalid" => $materjalide_nimekiri,      // Kõik materjalid koguste ja hindadega
            "algne_summa" => $algne_summa,              // Summa enne soodustust
            "kogusumma" => $kogu_summa,                 // Lõplik summa (võib olla soodustusega)
            "pindala" => $sisestatud_pindala,           // Kasutaja sisestatud pindala
            "tyyp" => $valitud_tyyp,                    // Valitud ehituse tüüp
            "pusiklient" => $pusikliendi_soodustus      // Kas püsiklient või mitte
        ];
        
        // ==================================================
        // KALKULATSIOONI SALVESTAMINE FAILI
        // ==================================================
        
        // Koostame rea salvestamiseks faili (eraldatud "|" märkidega)
        $salvestamise_rida = date("Y-m-d H:i:s") . "|" .        // Kuupäev ja kellaaeg
                            $sisestatud_pindala . " m²|" .       // Pindala
                            ucfirst($valitud_tyyp) . "|" .       // Ehituse tüüp (suure algustähega)
                            number_format($kogu_summa, 2) . "€|" . // Kogusumma
                            ($pusikliendi_soodustus ? "Püsiklient" : "Tavaline") . "\n"; // Kliendi tüüp
        
        // Salvestame kalkulatsiooni andmed orders.txt faili
        // FILE_APPEND lisab rea faili lõppu (ei kirjuta üle)
        file_put_contents("orders.txt", $salvestamise_rida, FILE_APPEND);
    }
}
?>

<!-- ==================================================
     HTML OSA ALGAB SIIT
     ================================================== -->

<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center mb-5">Ehitusmaterjalide kalkulaator</h1>
                
                <!-- ==================================================
                     KALKULATSIOONI VORM
                     ================================================== -->
                
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Vorm saadab andmed GET meetodiga -->
                        <form method="GET">
                            
                            <!-- PINDALA SISESTAMINE -->
                            <div class="mb-3">
                                <label for="pindala" class="form-label">Pindala (m²) *</label>
                                <!-- number - ainult numbrid, step="0.1" lubab komakohi -->
                                <input type="number" class="form-control" id="pindala" name="pindala" 
                                       step="0.1" min="1" max="1000" required 
                                       value="<?php echo isset($_GET["pindala"]) ? $_GET["pindala"] : ""; ?>">
                            </div>
                            
                            <!-- EHITUSE TÜÜBI VALIMINE -->
                            <div class="mb-3">
                                <label for="tyyp" class="form-label">Ehituse tüüp *</label>
                                <select class="form-select" id="tyyp" name="tyyp" required>
                                    <option value="">Vali tüüp...</option>
                                    <!-- Iga valik jääb valituks pärast vormi saatmist -->
                                    <option value="vundament" <?php echo (isset($_GET["tyyp"]) && $_GET["tyyp"] == "vundament") ? "selected" : ""; ?>>Vundament</option>
                                    <option value="seinad" <?php echo (isset($_GET["tyyp"]) && $_GET["tyyp"] == "seinad") ? "selected" : ""; ?>>Seinad</option>
                                    <option value="katus" <?php echo (isset($_GET["tyyp"]) && $_GET["tyyp"] == "katus") ? "selected" : ""; ?>>Katus</option>
                                </select>
                            </div>
                            
                            <!-- PÜSIKLIENDI SOODUSTUS -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <!-- Checkbox püsikliendi soodustuse jaoks -->
                                    <input class="form-check-input" type="checkbox" id="pusiklient" name="pusiklient" 
                                           <?php echo (isset($_POST["pusiklient"])) ? "checked" : ""; ?>>
                                    <label class="form-check-label" for="pusiklient">
                                        <strong class="text-success">Püsikliendi soodustus -10%</strong>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- ARVUTAMISE NUPP -->
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-calculator"></i> Arvuta materjalid
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- ==================================================
                     KALKULATSIOONI TULEMUSED
                     ================================================== -->
                     
                <!-- Näitame tulemusi ainult siis kui kalkulatsioon on tehtud -->
                <?php if ($arvutuse_tulemus): ?>
                <div class="card">
                    <!-- TULEMUSTE PÄIS -->
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Kalkulatsiooni tulemused</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- ÜLDANDMED -->
                        <p class="mb-3">
                            <strong>Pindala:</strong> <?php echo $arvutuse_tulemus["pindala"]; ?> m² | 
                            <strong>Tüüp:</strong> <?php echo ucfirst($arvutuse_tulemus["tyyp"]); ?>
                            <!-- Kui on püsiklient, näitame märki -->
                            <?php if ($arvutuse_tulemus["pusiklient"]): ?>
                                | <span class="badge bg-success">Püsiklient</span>
                            <?php endif; ?>
                        </p>
                        
                        <!-- MATERJALIDE TABEL -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Materjal</th>
                                        <th>Kogus</th>
                                        <th>Ühik</th>
                                        <th>Hind</th>
                                        <th>Summa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Käime kõik materjalid läbi ja näitame neid tabelis -->
                                    <?php foreach ($arvutuse_tulemus["materjalid"] as $materjal): ?>
                                    <tr>
                                        <td><?php echo $materjal["nimi"]; ?></td>
                                        <!-- number_format(arv, kohti, komakohade_eraldaja, tuhandete_eraldaja) -->
                                        <td><?php echo number_format($materjal["kogus"], 2, ",", " "); ?></td>
                                        <td><?php echo $materjal["yhik"]; ?></td>
                                        <td><?php echo number_format($materjal["hind"], 2, ",", " "); ?>€</td>
                                        <td><strong><?php echo number_format($materjal["summa"], 2, ",", " "); ?>€</strong></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                
                                <!-- TABELI JALUS KOGUSUMMAGA -->
                                <tfoot>
                                <!-- TABELI JALUS KOGUSUMMAGA -->
                                <tfoot>
                                    <!-- Kui on püsiklient, näitame ka soodustuse detaile -->
                                    <?php if ($arvutuse_tulemus["pusiklient"]): ?>
                                    <tr>
                                        <th colspan="4">Summa enne soodustust:</th>
                                        <th><?php echo number_format($arvutuse_tulemus["algne_summa"], 2, ",", " "); ?>€</th>
                                    </tr>
                                    <tr class="table-success">
                                        <th colspan="4">Püsikliendi soodustus (-10%):</th>
                                        <!-- Arvutame soodustuse summa: algne - lõplik -->
                                        <th>-<?php echo number_format($arvutuse_tulemus["algne_summa"] - $arvutuse_tulemus["kogusumma"], 2, ",", " "); ?>€</th>
                                    </tr>
                                    <?php endif; ?>
                                    
                                    <!-- LÕPLIK KOGUSUMMA -->
                                    <tr class="table-primary">
                                        <th colspan="4">KOKKU:</th>
                                        <th><?php echo number_format($arvutuse_tulemus["kogusumma"], 2, ",", " "); ?>€</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- LISAINFO JA NUPUD -->
                        <div class="mt-4">
                            <!-- KINNITUSE TEADE -->
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> Kalkulatsioon on salvestatud!
                            </div>
                            
                            <!-- VÄIKE TEKST JA NUPP -->
                            <p class="text-muted"><small>* Hinnad on orienteeruvad ja võivad muutuda.</small></p>
                            <a href="tooted.php" class="btn btn-success">
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
