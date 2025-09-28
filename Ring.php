<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Ringi pindala</title>
</head>
<body>
    <form method="post">
        Raadius: <input type="number" name="raadius" step="any" required>
        <br><br>
        <button type="submit">Arvuta pindala</button>
    </form>

    <?php
    function ringiPindala($r) {
        return pi() * $r * $r;
    }

    if ($_POST) {
        $raadius = $_POST["raadius"];
        $pindala = ringiPindala($raadius);
        echo "<h3>Raadiusega {$raadius} ringi pindala on: {$pindala}</h3>";
    }
    ?>
</body>
</html>
