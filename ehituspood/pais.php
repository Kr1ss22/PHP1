<?php
// ==================================================
// PÄISE FAIL - seda kaasatakse iga lehe algusesse
// ==================================================
// Sisaldab navigatsiooni, CSS linke ja HTML päist

// $_SESSION on PHP globaalne muutuja, mis hoiab kasutaja andmeid serveri poolel
// Peab olema kõige esimene rida, et kasutada sessiooni
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Lehe pealkiri - kombineerib "Ehituspood" + lehe spetsiifilise pealkirjaga -->
    <title>Ehituspood - <?php echo isset($lehe_pealkiri) ? $lehe_pealkiri : 'Avaleht'; ?></title>
    
    <!-- Bootstrap CSS - ilusate stiilidega raamistik -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap ikoonid - nupud ja dekoratsioon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- ==================================================
         NAVIGATSIOONI RIBA
         ================================================== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- LOGO JA ETTEVÕTTE NIMI -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                <!-- Juhuslik logo pilt -->
                <img src="https://picsum.photos/40/40?random=20" 
                     alt="Ehituspood Logo" 
                     class="rounded-circle me-2" 
                     style="width: 32px; height: 32px; object-fit: cover;">
                <!-- Ettevõtte nimi - lühendatud väikestel ekraanidel -->
                <span class="d-none d-sm-inline">Ehituspood</span>  <!-- Suured ekraanid -->
                <span class="d-sm-none">EM</span>                   <!-- Väikesed ekraanid -->
            </a>
            
            <!-- HAMBURGER MENÜÜ NUPP (mobiilis) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- NAVIGATSIOONI MENÜÜ -->
            <!-- NAVIGATSIOONI MENÜÜ -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- VASAKPOOLSED LINGID -->
                <ul class="navbar-nav me-auto">
                    <!-- AVALEHE LINK -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                            <i class="bi bi-house"></i> Avaleht
                        </a>
                    </li>
                    
                    <!-- TOODETE LEHE LINK -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'tooted.php' ? 'active' : ''; ?>" href="tooted.php">
                            <i class="bi bi-box"></i> Tooted
                        </a>
                    </li>
                    
                    <!-- KALKULAATORI LINK -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kalkulaator.php' ? 'active' : ''; ?>" href="kalkulaator.php">
                            <i class="bi bi-calculator"></i> Kalkulaator
                        </a>
                    </li>
                    
                    <!-- KONTAKTI LEHE LINK -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kontakt.php' ? 'active' : ''; ?>" href="kontakt.php">
                            <i class="bi bi-envelope"></i> Kontakt
                        </a>
                    </li>
                </ul>
                </ul>
                
                <!-- PAREMPOOLSED LINGID -->
                <ul class="navbar-nav">
                    <!-- OSTUKORVI LINK -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="ostukorv.php">
                            <i class="bi bi-cart3"></i> Ostukorv 
                            <?php 
                            // ==================================================
                            // OSTUKORVI MÄRK - näitab mitu toodet on ostukorvis
                            // ==================================================
                            
                            // Kontrollime kas ostukorvis on tooteid
                            // $_SESSION['ostukorv'] hoiab kõike ostukorvi tooteid massiivina
                            if (isset($_SESSION['ostukorv']) && count($_SESSION['ostukorv']) > 0): 
                            ?>
                                <!-- Kollane märk toodete arvuga -->
                                <!-- Kollane märk toodete arvuga -->
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    <!-- Näitame mitu tüüpi toodet on ostukorvis -->
                                    <?php echo count($_SESSION['ostukorv']); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>