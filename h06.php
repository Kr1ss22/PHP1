<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülesanded</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2>Genereeri</h2>
<?php

for ($i = 1; $i <= 100; $i++) {
    echo $i . ". ";
    if ($i % 10 == 0) {
        echo "<br>";
    }
}
?>

<h2>Rida</h2>
<?php

for ($i = 0; $i < 10; $i++) {
    echo "*";
}
?>

<h2>Rida II</h2>
<?php

for ($i = 0; $i < 10; $i++) {
    echo "*<br>";
}
?>

<h2>Ruut</h2>
<form method="get" class="form-inline">
    <div class="form-group mb-2">
        <label for="size" class="sr-only">Suurus</label>
        <input type="number" class="form-control" id="size" name="size" placeholder="Suurus">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Loo ruut</button>
</form>
<?php
if (!empty($_GET['size'])) {
    $size = $_GET['size'];
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            echo "* ";
        }
        echo "<br>";
    }
}
?>

<h2>Kahanev</h2>
<?php

for ($i = 10; $i >= 1; $i--) {
    echo $i . "<br>";
}
?>

<h2>Kolmega jagunevad</h2>
<?php

for ($i = 1; $i <= 100; $i++) {
    if ($i % 3 == 0) {
        echo $i . " ";
    }
}
?>

<h2>Massiivid ja tsüklid</h2>
<?php

$poiste_massiiv = ["Mati", "Kalle", "Jüri", "Peeter", "Toomas"];
$tudrukute_massiiv = ["Mari", "Kati", "Liisa", "Anne", "Eva"];


for ($i = 0; $i < count($poiste_massiiv); $i++) {
    echo $poiste_massiiv[$i] . " ja " . $tudrukute_massiiv[$i] . "<br>";
}
?>

<h2>Massiivid ja tsüklid (Bonus)</h2>
<?php

$poiste_koopia = $poiste_massiiv;
$tudrukute_koopia = $tudrukute_massiiv;


shuffle($poiste_koopia);
shuffle($tudrukute_koopia);

for ($i = 0; $i < count($poiste_koopia); $i++) {
    echo $poiste_koopia[$i] . " ja " . $tudrukute_koopia[$i] . "<br>";
}
?>

</body>
</html>