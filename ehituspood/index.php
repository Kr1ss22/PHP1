<?php
$lehe_pealkiri = "Ehituspood";
include "pais.php";
?>

<main>
    <div id="reklaam_carousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $reklaam_pildid = glob("reklaam/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            if (empty($reklaam_pildid)) {
                $reklaam_pildid = [
                    "https://picsum.photos/1200/400?random=1",
                    "https://picsum.photos/1200/400?random=2",
                    "https://picsum.photos/1200/400?random=3"
                ];
            }
            shuffle($reklaam_pildid);
            foreach ($reklaam_pildid as $pildi_indeks => $pildi_tee):
            ?>
            <div class="carousel-item <?php echo $pildi_indeks === 0 ? "active" : ""; ?>">
                <img src="<?php echo $pildi_tee; ?>" class="d-block w-100" alt="Reklaam" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Kvaliteetsed ehitusmaterjalid</h3>
                    <p>Parimate hindadega Eestis</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#reklaam_carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reklaam_carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Ehituspood</h1>
                <p class="lead mb-4">Leia kõik vajalikud ehitusmaterjalid ühest kohast. Soodsad hinnad ja kiire tarne üle Eesti.</p>
                <div class="d-flex gap-3">
                    <a href="tooted.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-box"></i> Vaata tooteid
                    </a>
                    <a href="kalkulaator.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-calculator"></i> Kalkulaator
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://picsum.photos/500/400?random=10" 
                     class="img-fluid rounded shadow" 
                     alt="Ehitusmaterjalid" 
                     style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>

    <div class="bg-primary text-white py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <h2 class="fw-bold">500+</h2>
                    <p class="mb-0">Tooteid</p>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <h2 class="fw-bold">15+</h2>
                    <p class="mb-0">Aastat kogemust</p>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <h2 class="fw-bold">1000+</h2>
                    <p class="mb-0">Rahullikku klienti</p>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <h2 class="fw-bold">24/7</h2>
                    <p class="mb-0">Tugi</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Populaarsed tooted</h2>
        <div class="row">
            <?php
            $tooted_massiiv = [];
            $fail_link = fopen("materjalid.csv", "r");
            if ($fail_link !== FALSE) {
                $paised = fgetcsv($fail_link, 1000, ";");
                while (($andmed = fgetcsv($fail_link, 1000, ";")) !== FALSE) {
                    $tooted_massiiv[] = array_combine($paised, $andmed);
                }
                fclose($fail_link);
                shuffle($tooted_massiiv);
                $tooted_massiiv = array_slice($tooted_massiiv, 0, 3);
            }
            $pildi_id = 50; // Alustame pildi ID-ga 50
            foreach ($tooted_massiiv as $yks_toode):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://picsum.photos/300/200?random=<?php echo $pildi_id++; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($yks_toode["toote_nimi"]); ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($yks_toode["toote_nimi"]); ?></h5>
                        <p class="card-text">Kvaliteetne ehitusmaterjal professionaalseks kasutamiseks.</p>
                        <p class="card-text">
                            <strong class="text-primary fs-5"><?php echo $yks_toode["hind"]; ?>€</strong>
                            <small class="text-muted">/ <?php echo $yks_toode["ühik"]; ?></small>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="tooted.php" class="btn btn-primary btn-sm">Vaata rohkem</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="tooted.php" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right"></i> Vaata kõiki tooteid
            </a>
        </div>
    </div>
</main>

<?php include "jalus.php"; ?>
