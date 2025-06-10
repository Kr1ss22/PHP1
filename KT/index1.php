<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>kmustkivi.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .navbar {
            background-color: #e9ecef;
        }
        .navbar-brand {
            margin-left: 20px;
            color: #000;
        }
        .navbar-nav {
            margin-right: 20px;
        }
        .navbar-nav .nav-link {
            color: #000;
            margin-right: 20px; 
        }
        .navbar-nav .nav-item:last-child .nav-link {
            margin-right: 0;
        }
        .bi-bag {
            color: #000;
        }

        .banner-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .banner {
            position: relative;
            width: 49%;
            height: 333px;
            overflow: hidden;
        }
        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .banner-text {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: white;
        }
        .banner-text h2 {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .banner-text p.alampealkiri {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .banner-text p.lisainfo {
            font-size: 15px;
            font-weight: bold;
        }
        .banner-text button {
            background-color: transparent;
            border: 1px solid white;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
            text-align: left;
            margin-left: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 10px;
            height: 400px;
        }
        .product-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 10px;
        }
        .product-card .card-body {
            padding: 0;
            text-align: left;
        }
        .product-card h5 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 5px;
        }
        .product-card p {
            font-size: 1rem;
            color: #00bfff;
            font-weight: bold;
            margin-bottom: 0;
        }

        .parimad-pakkumised {
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .navbar .container-fluid, footer .container {
            max-width: 1400px;
            margin: 0 auto; 
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand p-2" href="index.php">kmustkivi.com</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['leht'] ?? '') === 'avaleht' ? 'active' : '' ?>" href="index1.php">Avaleht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['leht'] ?? '') === 'pood' ? 'active' : '' ?>" href="pood.php">Pood</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['leht'] ?? '') === 'kontakt' ? 'active' : '' ?>" href="kontakt.php">Kontakt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['leht'] ?? '') === 'admin' ? 'active' : '' ?>" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item text-center mt-2">
                        <i class="bi bi-bag"></i>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // Bannerid ainult avalehe jaoks
    $bannerid = [
        ['pilt' => 'img/pilt1.jpg', 'pealkiri' => 'parim pakkumine', 'alampealkiri' => 'osta 1 saad 1', 'lisainfo' => 'The best classic dress is on sale at coro'],
        ['pilt' => 'img/pilt2.jpg', 'pealkiri' => 'kevad/suvi', 'alampealkiri' => 'kÃµik rohelised', 'lisainfo' => '20% soodsamalt'],
        ['pilt' => 'img/pilt3.jpg', 'pealkiri' => 'suur allahindlus', 'alampealkiri' => 'kuni 50% alla', 'lisainfo' => 'Ainult tÃ¤na!'],
        ['pilt' => 'img/pilt4.jpg', 'pealkiri' => 'uus kollektsioon', 'alampealkiri' => 'vaata uusimaid tooteid', 'lisainfo' => 'Tule ja inspireeru!'],
        ['pilt' => 'img/pilt5.jpg', 'pealkiri' => 'eripakkumine', 'alampealkiri' => 'eriline valik', 'lisainfo' => 'Ainult valitud tooted!']
    ];

    if (!empty($_GET['leht'])) {
        $leht = htmlspecialchars($_GET['leht']);
        $lubatud = ['pood', 'kontakt', 'admin'];
        if (in_array($leht, $lubatud)) {
            include($leht . '.php');
        } else {
            echo '<h1 class="text-center mt-4">Lehte ei eksisteeri!</h1>';
        }
    } else {
        // Bannerite kuvamine ainult avalehel
        $banner1 = $bannerid[array_rand($bannerid)];
        $banner2 = $bannerid[array_rand($bannerid)];
        while ($banner1 === $banner2) {
            $banner2 = $bannerid[array_rand($bannerid)];
        }
        ?>
        <div class="container banner-container">
            <div class="banner">
                <img src="<?= $banner1['pilt']; ?>" alt="Banner 1">
                <div class="banner-text">
                    <p class="alampealkiri"><?= $banner1['pealkiri']; ?></p>
                    <h2><?= $banner1['alampealkiri']; ?></h2>
                    <p class="lisainfo"><?= $banner1['lisainfo']; ?></p>
                    <button>Vaata lÃ¤hemalt</button>
                </div>
            </div>
            <div class="banner">
                <img src="<?= $banner2['pilt']; ?>" alt="Banner 2">
                <div class="banner-text">
                    <p class="alampealkiri"><?= $banner2['pealkiri']; ?></p>
                    <h2><?= $banner2['alampealkiri']; ?></h2>
                    <p class="lisainfo"><?= $banner2['lisainfo']; ?></p>
                    <button>Tutvu lÃ¤hemalt</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row text-center mt-5 mb-5">
                <h2 class="parimad-pakkumised">Parimad pakkumised</h2>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php
                if ($csv = fopen("tooted.csv", "r")) {
                    fgetcsv($csv);
                    while ($andmed = fgetcsv($csv)) {
                        echo "
                        <div class='col'>
                            <div class='product-card'>
                                <img src='{$andmed[0]}' class='card-img-top' alt='{$andmed[1]}'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$andmed[1]}</h5>
                                    <p class='card-text'>{$andmed[2]}â‚¬</p>
                                </div>
                            </div>
                        </div>";
                    }
                    fclose($csv);
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>

    <footer>
        <div class="container">
            <p>kmustkivi.com</p>
        </div>
    </footer>
</body>
</html>
