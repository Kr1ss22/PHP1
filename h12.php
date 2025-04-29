<!doctype html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHP Harjutused</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
<body>
    <div class="container">
        <h1>Harjutus 11</h1>
        <div class="row">
            <div class="col-md-4">

                <h2>Sõiduaeg</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta oma nimi!</label>
                        <input type="text" class="form-control" name="kasutaja">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sõidu alustus aeg: [hh:mm]</label>
                        <input type="text" class="form-control" name="algus">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sõidu lõpetamise aeg: [hh:mm]</label>
                        <input type="text" class="form-control" name="lopp">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form> 


                <?php

                if (isset($_GET["kasutaja"]) && isset($_GET["algus"]) && isset($_GET["lopp"])) {
                    $kasutaja = $_GET["kasutaja"];
                    $algus = $_GET["algus"];
                    $lopp = $_GET["lopp"];
                    $algus = explode(":", $algus);
                    $lopp = explode(":", $lopp);
                    $algus = $algus[0] * 60 + $algus[1];
                    $lopp = $lopp[0] * 60 + $lopp[1];
                    $soiduaeg = $lopp - $algus;
                    $tunnid = floor($soiduaeg / 60);
                    $minutid = $soiduaeg % 60;
                    echo "Tere, $kasutaja! Teie sõiduaeg on $tunnid tundi ja $minutid minutit.";
                }

                ?>



                <h2>Palkade võrdlus</h2>

                <?php

                $allikas = 'csv/tootajad.csv';

                $fail = fopen($allikas, 'r');

                $meeste_palk = 0;
                $naiste_palk = 0;
                $meeste_arv = 0;
                $naiste_arv = 0;
                $meeste_max = 0;
                $naiste_max = 0;

                while (($rida = fgetcsv($fail, 1000, ';')) !== false) {
                    if (count($rida) < 3) {
                        continue;
                    }
                    
                    $nimi = trim($rida[0]);
                    $sugu = trim($rida[1]);
                    $palk = floatval($rida[2]);

                    if ($sugu === 'm') {
                        $meeste_palk += $palk;
                        $meeste_arv++;
                        if ($palk > $meeste_max) {
                            $meeste_max = $palk;
                        }
                    } elseif ($sugu === 'n') {
                        $naiste_palk += $palk;
                        $naiste_arv++;
                        if ($palk > $naiste_max) {
                            $naiste_max = $palk;
                        }
                    }
                }

                fclose($fail);

                $meeste_keskmine = ($meeste_arv > 0) ? ($meeste_palk / $meeste_arv) : 0;
                $naiste_keskmine = ($naiste_arv > 0) ? ($naiste_palk / $naiste_arv) : 0;

                echo "Meeste keskmine palk on " . number_format($meeste_keskmine, 2) . " ja kõige suurem palk on " . number_format($meeste_max, 2) . ".<br>";
                echo "Naiste keskmine palk on " . number_format($naiste_keskmine, 2) . " ja kõige suurem palk on " . number_format($naiste_max, 2) . ".";

                ?>


            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>