<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harjutus1</title>
</head>
<body>

<?php
// Kristjan Mustkivi
$nimi = "Imre";
$sa = 2007;
$tk = "Skorpion";

echo $nimi . " " . $sa . " " . $tk . "<br>";
echo "$nimi $sa $tk <br>";
printf("%s %d %s <br>", $nimi, $sa, $tk);
echo "\"It's My Life\" - Dr. Alban<br>";
?>

<pre>
<?php
echo " (\\ /)\n";
echo " ( -.-)\n";
echo " o_(\")(\")\n";
?>
</pre>

<h1>Harjutus 2</h1>

<?php
$a = 10;
$b = 20;

printf("%d + %d = %d <br>", $a, $b, $a + $b);
printf("%d - %d = %d <br>", $a, $b, $a - $b);
printf("%d * %d = %d <br>", $a, $b, $a * $b);
printf("%d / %d = %.2f <br>", $a, $b, $a / $b);
?>
<h2>Teisendamine</h2>
<form method="get">
    number  <input type="number" name="nr" ><br>
            <input type="submit" class="btn-alert" value="Teisenda"><br>
</form>
<?php
if (isset($_GET["nr"])) {
    $nr = $_GET["nr"];
    printf("%dmm on %0.2f cm<br>", $nr, $nr/10);
    printf("%dmm on %0.2f m<br>", $nr, $nr/1000);
}
?>
<h2>Kolmnurk</h2>
<form method="get">
    a  <input type="number" name="a" ><br>
    b  <input type="number" name="b" ><br>
    <input type="submit" class="btn-success" value="Arvuta"><br>
</form>
<?php
if (isset($_GET["a"]) && isset($_GET["b"])) {
    $a = $_GET["a"];
    $b = $_GET["b"];
    $c = sqrt(pow($a, 2) + pow($b, 2));
    $p = $a + $b + $c;
    $s = ($a * $b) / 2;
    echo "kolmnurga pindala on <br>".$s;
    echo "kolmnurga ümbermõõt on ".$p;
}
?>

<h2>Trapetsi ja rombi arvutused</h2>
<form method="get">
    Trapetsi alus a: <input type="number" name="trap_a" step="0.1"><br>
    Trapetsi alus b: <input type="number" name="trap_b" step="0.1"><br>
    Trapetsi kõrgus h: <input type="number" name="trap_h" step="0.1"><br>
    Rombi külg: <input type="number" name="romb_side" step="0.1"><br>
    <input type="submit" class="btn-calculate" value="Arvuta"><br>
</form>
<?php
if (isset($_GET["trap_a"]) && isset($_GET["trap_b"]) && isset($_GET["trap_h"]) && isset($_GET["romb_side"])) {
    $trap_a = $_GET["trap_a"];
    $trap_b = $_GET["trap_b"];
    $trap_h = $_GET["trap_h"];
    $romb_side = $_GET["romb_side"];

    // Trapetsi pindala
    $trap_area = (($trap_a + $trap_b) / 2) * $trap_h;
    // Rombi ümbermõõt
    $romb_perimeter = 4 * $romb_side;

    echo "Trapetsi pindala on " . round($trap_area, 1) . " ruutühikut.<br>";
    echo "Rombi ümbermõõt on " . round($romb_perimeter, 1) . " ühikut.<br>";
}
?>
</body>
</html>