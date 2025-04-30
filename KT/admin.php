<?php
session_start();

if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = true;
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index1.php">Kmustkivi.com</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index1.php">Avaleht</a></li>
                    <li class="nav-item"><a class="nav-link" href="index1.php?leht=pood">Pood</a></li>
                    <li class="nav-item"><a class="nav-link" href="index1.php?leht=kontakt">Kontakt</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="admin.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark">Toote Haldus</h1>
        </div>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm mb-5">
            <h2 class="h4 fw-bold text-dark mb-4">Lisa uus toode</h2>
            <div class="mb-3">
                <label class="form-label fw-bold">Toote nimi:</label>
                <input type="text" name="toote_nimi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Toote hind:</label>
                <input type="number" name="toote_hind" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Toote pilt:</label>
                <input type="file" name="toote_pilt" class="form-control" accept=".png, .jpg, .jpeg" required>
            </div>
            <button type="submit" name="lisa" class="btn btn-success w-100">Lisa toode</button>
        </form>

        <h2 class="h4 fw-bold text-dark mb-4">Praegused tooted</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            function andmed() {
                $tooted = [];
                $csv = fopen("tooted.csv", "r");
                if ($csv !== false) {
                    fgetcsv($csv); // Pealkirjade vahelejätmine
                    while ($rida = fgetcsv($csv)) {
                        $tooted[] = $rida;
                    }
                    fclose($csv);
                }
                return $tooted;
            }

            function salvesta($tooted) {
                $csv = fopen("tooted.csv", "w");
                if ($csv !== false) {
                    fputcsv($csv, ["pilt", "toode", "hind"]);
                    foreach ($tooted as $toode) {
                        fputcsv($csv, $toode);
                    }
                    fclose($csv);
                }
            }

            if (isset($_POST['lisa'])) {
                $toote_nimi = $_POST['toote_nimi'];
                $toote_hind = $_POST['toote_hind'];
                $pilt = $_FILES['toote_pilt'];
                $asukoht = "img/";
                $pildi_nimi = $asukoht . basename($pilt['name']);

                if (move_uploaded_file($pilt['tmp_name'], $pildi_nimi)) {
                    $tooted = andmed();
                    $tooted[] = [$pildi_nimi, $toote_nimi, $toote_hind];
                    salvesta($tooted);
                } else {
                    echo "<div class='alert alert-danger'>Pildi üleslaadimine ebaõnnestus.</div>";
                }
            }

            if (isset($_GET['kustuta'])) {
                $kustuta = $_GET['kustuta'];
                $tooted = andmed();
                if (isset($tooted[$kustuta])) {
                    unset($tooted[$kustuta]);
                    $tooted = array_values($tooted); // indeksid uuesti järjestada
                    salvesta($tooted);
                }
            }

            $tooted = andmed();
            foreach ($tooted as $index => $toode) {
                echo "
                <div class='col'>
                    <div class='card h-100 shadow-sm'>
                        <img src='{$toode[0]}' class='card-img-top' alt='{$toode[1]}'>
                        <div class='card-body'>
                            <h5 class='card-title fw-bold'>{$toode[1]}</h5>
                            <p class='card-text'>{$toode[2]}€</p>
                            <a href='admin.php?kustuta={$index}' class='btn btn-danger w-100'>Kustuta</a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
