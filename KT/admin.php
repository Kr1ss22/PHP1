<?php
session_start();

// Lihtne sessioonikontroll
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = true;
}

// Funktsioon toodete lugemiseks CSV-st
function andmed() {
    $tooted = [];
    if (($csv = fopen("tooted.csv", "r")) !== false) {
        fgetcsv($csv); // pealkirjarida
        while ($rida = fgetcsv($csv)) {
            $tooted[] = $rida;
        }
        fclose($csv);
    }
    return $tooted;
}

// Funktsioon toodete salvestamiseks CSV-sse
function salvesta($tooted) {
    if (($csv = fopen("tooted.csv", "w")) !== false) {
        fputcsv($csv, ["pilt", "toode", "hind"]);
        foreach ($tooted as $toode) {
            fputcsv($csv, $toode);
        }
        fclose($csv);
    }
}

// Kustutamine
if (isset($_GET['kustuta'])) {
    $kustuta = (int)$_GET['kustuta'];
    $tooted = andmed();
    if (isset($tooted[$kustuta])) {
        // Kustutame ka pildi, kui see on olemas
        if (file_exists($tooted[$kustuta][0])) {
            unlink($tooted[$kustuta][0]);
        }
        unset($tooted[$kustuta]);
        $tooted = array_values($tooted); // taastame indeksid
        salvesta($tooted);
        header("Location: admin.php");
        exit;
    }
}

// Uue toote lisamine
$veateade = "";

if (isset($_POST['lisa'])) {
    $toote_nimi = $_POST['toote_nimi'];
    $toote_hind = $_POST['toote_hind'];
    $pilt = $_FILES['toote_pilt'];
    $asukoht = "img/";

    // Loome kausta, kui see puudub
    if (!is_dir($asukoht)) {
        mkdir($asukoht, 0777, true);
    }

    // Kontrollime vigu
    if ($pilt['error'] !== UPLOAD_ERR_OK) {
        $veateade = "Pildi Ã¼leslaadimine ebaÃµnnestus. Veakood: {$pilt['error']}";
    } else {
        // Turvalise pildinime tegemine
        $pildi_nimi = $asukoht . time() . "_" . basename($pilt['name']);
        // Ãœleslaadimine
        if (move_uploaded_file($pilt['tmp_name'], $pildi_nimi)) {
            $tooted = andmed();
            $tooted[] = [$pildi_nimi, $toote_nimi, $toote_hind];
            salvesta($tooted);
            header("Location: admin.php");
            exit;
        } else {
            $veateade = "move_uploaded_file ebaÃµnnestus.";
        }
    }
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
        <a class="navbar-brand fw-bold" href="index.php">Kmustkivi.com</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index1.php">Avaleht</a></li>
                <li class="nav-item"><a class="nav-link" href="pood.php?leht=pood">Pood</a></li>
                <li class="nav-item"><a class="nav-link" href="kontakt.php?leht=kontakt">Kontakt</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold" href="admin.php">Admin</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">Toote Haldus</h1>
    </div>

    <!-- Toote lisamise vorm -->
    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm mb-5">
        <h2 class="h4 fw-bold text-dark mb-4">Lisa uus toode</h2>

        <?php if (!empty($veateade)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($veateade) ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label fw-bold">Toote nimi:</label>
            <input type="text" name="toote_nimi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Toote hind (â‚¬):</label>
            <input type="number" step="0.01" name="toote_hind" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Toote pilt:</label>
            <input type="file" name="toote_pilt" class="form-control" accept=".png, .jpg, .jpeg" required>
        </div>

        <button type="submit" name="lisa" class="btn btn-success w-100">Lisa toode</button>
    </form>

    <!-- Olemasolevad tooted -->
    <h2 class="h4 fw-bold text-dark mb-4">Praegused tooted</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        $tooted = andmed();
        foreach ($tooted as $index => $toode):
            $hind = number_format((float)$toode[2], 2, ',', ' ');
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($toode[0]) ?>" class="card-img-top" alt="<?= htmlspecialchars($toode[1]) ?>">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($toode[1]) ?></h5>
                        <p class="card-text"><?= $hind ?> &euro;</p>
                        <a href="?kustuta=<?= $index ?>" class="btn btn-danger w-100">Kustuta</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
