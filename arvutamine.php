<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kütuse kalkulaator</title>
</head>
<body>
    <form method="post">
        Kütuse hind: 
        <input type="text" name="kutusehind"><br><br>

        Liitrid kokku: 
        <input type="text" name="liitrid"><br><br>

        <button type="submit">Arvuta</button>
    </form>

    <?php
    if ($_POST) {
        $kutusehind = $_POST["kutusehind"];
        $liitrid = $_POST["liitrid"];
        $kokku = $kutusehind * $liitrid;

        echo "Hind: $kutusehind € liiter<br>";
        echo "Liitrid: $liitrid L<br>";
        echo "Kokku: $kokku €";
    }
    ?>
</body>
</html>
