<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülesanded</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2>Kuupäev ja kellaaeg</h2>
<?php
// Kuva kuupäev ja kellaaeg formaadis 20.03.2023 17:31
echo date("d.m.Y H:i");
?>

<h2>Vanus</h2>
<form method="get" class="form-inline">
    <div class="form-group mb-2">
        <label for="birth_year" class="sr-only">Sünniaasta</label>
        <input type="number" class="form-control" id="birth_year" name="birth_year" placeholder="Sünniaasta">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Arvuta vanus</button>
</form>
<?php
if (!empty($_GET['birth_year'])) {
    $birth_year = $_GET['birth_year'];
    $current_year = date("Y");
    $age = $current_year - $birth_year;
    echo "Kasutaja on või saab sellel aastal $age aastat vanaks.";
}
?>

<h2>Kooliaasta lõpuni</h2>
<?php
// Mitu päeva on käesoleva kooliaasta lõpuni?
$today = new DateTime();
$end_of_school_year = new DateTime('2025-06-30');
$interval = $today->diff($end_of_school_year);
echo "2025 kooliaasta lõpuni on jäänud " . $interval->days . " päeva!";
?>

<h2>Aastaaeg</h2>
<?php
// Väljasta vastavalt aastaajale pilt (kevad, suvi, sügis, talv)
$month = date("n");
$season = "";
$image_path = ""; // Määrame pildi tee

if ($month >= 3 && $month <= 5) {
    $season = "kevad";
    $image_path = "kevad.jpg"; // Kevade pilt
} elseif ($month >= 6 && $month <= 8) {
    $season = "suvi";
    $image_path = "suvi.jpg"; // Suve pilt
} elseif ($month >= 9 && $month <= 11) {
    $season = "sügis";
    $image_path = "sügis.jpg"; // Sügise pilt
} else {
    $season = "talv";
    $image_path = "talv.jpg"; // Talve pilt
}

echo "<p>Praegune aastaaeg: <strong>$season</strong></p>";
echo "<img src='$image_path' alt='$season' class='img-fluid'>";
?>

</body>
</html>
