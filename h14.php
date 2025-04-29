<?php
$kataloog = 'php14_pildid';
$pildid = [];

if (is_dir($kataloog)) {
    $asukoht = opendir($kataloog);
    while ($rida = readdir($asukoht)) {
        if ($rida !== '.' && $rida !== '..') {
            $pildid[] = $rida;
        }
    }
    closedir($asukoht);
}

$suvapildi_suurus = 400;
$pisi_laius = 120;
$pisi_korgus = 90;
$veergudearv = 16;


function pildisuurus($pildi_aadress, $max_laius, $max_korgus) {
    global $laius, $korgus;
    $pildi_andmed = getimagesize($pildi_aadress);

    $laius = $pildi_andmed[0];
    $korgus = $pildi_andmed[1];

    if ($laius <= $max_laius && $korgus <= $max_korgus) {
        $ratio = 1;
    } elseif ($laius > $korgus) {
        $ratio = $max_laius / $laius;
    } else {
        $ratio = $max_korgus / $korgus;
    }

    $laius = round($laius * $ratio);
    $korgus = round($korgus * $ratio);
}

$suvapilt = $pildid[array_rand($pildid)];
$suva_asukoht = "$kataloog/$suvapilt";
pildisuurus($suva_asukoht, $suvapildi_suurus, $suvapildi_suurus);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harjutus14</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-4">

        <h1 class="mb-4">Suvaline pilt</h1>
        
        <img src="<?php echo $suva_asukoht; ?>" alt="Suvaline pilt" class="img-fluid mb-4" width="<?php echo $laius; ?>" height="<?php echo $korgus; ?>">

        <h1>Suvalised pisipildid</h1>
        <div class="row mt-5 mb-5">

            <?php 
            $piltide_arv = 0;
            do {
                $suvalinePisipilt = $pildid[array_rand($pildid)];
                $pisipildiTee = "$kataloog/$suvalinePisipilt";
                pildisuurus($pisipildiTee, $pisi_laius, $pisi_korgus);
            ?>

            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <a href="<?php echo $pisipildiTee; ?>" target="_blank"><img src="<?php echo $pisipildiTee; ?>" alt="Pisipilt" class="img-fluid" width="<?php echo $laius; ?>" height="<?php echo $korgus; ?>"></a>
            </div>

            <?php 
                $piltide_arv++;
            } while ($piltide_arv < $veergudearv); 
            ?>
        </div>
        
        <button onclick="location.reload();" class="btn btn-primary mt-4 mb-5">Uuenda pilte</button>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>