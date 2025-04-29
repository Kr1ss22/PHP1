<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülesanded</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2>Tervitus</h2>
<?php
function tervitus() {
    echo "Tere päiksekesekene!";
}
tervitus();
?>

<h2>Liitu uudiskirjaga</h2>
<?php
function uudiskiri() {
    echo '<form method="post" class="form-inline">
            <div class="form-group mb-2">
                <label for="email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Sisesta oma email">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Liitu</button>
          </form>';
}
uudiskiri();
?>

<h2>Kasutajanimi ja email</h2>
<?php
function looEmail($kasutajanimi) {
    $kasutajanimi = strtolower($kasutajanimi);
    $email = $kasutajanimi . "@hkhk.edu.ee";
    $kood = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 7);
    return $email . " - Kood: " . $kood;
}
echo looEmail("KasutajaNimi");
?>

<h2>Arvud</h2>
<?php
function looArvud($algus, $lopp, $samm = 1) {
    for ($i = $algus; $i <= $lopp; $i += $samm) {
        echo $i . " ";
    }
}
looArvud(2, 8);
echo "<br>";
looArvud(2, 8, 3);
?>

<h2>Ristküliku pindala</h2>
<form method="get" class="form-inline">
    <div class="form-group mb-2">
        <label for="pikkus" class="sr-only">Pikkus</label>
        <input type="number" class="form-control" id="pikkus" name="pikkus" placeholder="Pikkus">
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <label for="laius" class="sr-only">Laius</label>
        <input type="number" class="form-control" id="laius" name="laius" placeholder="Laius">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Arvuta pindala</button>
</form>
<?php
function ristkylikuPindala($pikkus, $laius) {
    return $pikkus * $laius;
}
if (!empty($_GET['pikkus']) && !empty($_GET['laius'])) {
    $pikkus = $_GET['pikkus'];
    $laius = $_GET['laius'];
    echo "Ristküliku pindala on: " . ristkylikuPindala($pikkus, $laius);
}
?>

<h2>Isikukood</h2>
<form method="get" class="form-inline">
    <div class="form-group mb-2">
        <label for="isikukood" class="sr-only">Isikukood</label>
        <input type="text" class="form-control" id="isikukood" name="isikukood" placeholder="Isikukood">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Kontrolli</button>
</form>
<?php
function kontrolliIsikukood($isikukood) {
    if (strlen($isikukood) == 11) {
        $sugu = (int)$isikukood[0] % 2 == 0 ? "Naine" : "Mees";
        $aasta = substr($isikukood, 1, 2);
        $kuu = substr($isikukood, 3, 2);
        $paev = substr($isikukood, 5, 2);
        $sunniaeg = $paev . "." . $kuu . "." . $aasta;
        return "Isikukood on õige pikkusega. Sugu: $sugu, Sünniaeg: $sunniaeg";
    } else {
        return "Isikukood ei ole õige pikkusega.";
    }
}
if (!empty($_GET['isikukood'])) {
    $isikukood = $_GET['isikukood'];
    echo kontrolliIsikukood($isikukood);
}
?>

<h2>Head mõtted</h2>
<?php
function headMotted() {
    $alus = ["Elu", "Armastus", "Õnn"];
    $oeldis = ["on", "toob", "leiab"];
    $sihitis = ["rõõmu", "rahu", "edu"];
    
    $randomAlus = $alus[array_rand($alus)];
    $randomOeldis = $oeldis[array_rand($oeldis)];
    $randomSihitis = $sihitis[array_rand($sihitis)];
    
    return "$randomAlus $randomOeldis $randomSihitis.";
}
echo headMotted();
?>

</body>
</html>