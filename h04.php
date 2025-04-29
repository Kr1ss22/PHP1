<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulesanded</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2 class="mb-3">Jagamine</h2>
<form method="get" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="number" class="form-control" name="num1" placeholder="Arv 1">
    </div>
    <div class="col-auto">
        <input type="number" class="form-control" name="num2" placeholder="Arv 2">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Jaga</button>
    </div>
</form>
<?php
if (!empty($_GET['num1']) && !empty($_GET['num2'])) {
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
    if ($num2 == 0) {
        echo '<div class="alert alert-warning">Jagamine nulliga ei ole lubatud!</div>';
    } else {
        $result = $num1 / $num2;
        echo "<div class='alert alert-success'>$num1 jagatud $num2-ga on $result</div>";
    }
}
?>

<h2 class="mt-5 mb-3">Vanus</h2>
<form method="get" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="number" class="form-control" name="age1" placeholder="Vanus 1">
    </div>
    <div class="col-auto">
        <input type="number" class="form-control" name="age2" placeholder="Vanus 2">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Vordle</button>
    </div>
</form>
<?php
if (!empty($_GET['age1']) && !empty($_GET['age2'])) {
    $age1 = $_GET['age1'];
    $age2 = $_GET['age2'];
    if ($age1 > $age2) {
        echo "<div class='alert alert-success'>Esimene isik on vanem.</div>";
    } elseif ($age1 < $age2) {
        echo "<div class='alert alert-success'>Teine isik on vanem.</div>";
    } else {
        echo "<div class='alert alert-success'>Molemad on uhevanused.</div>";
    }
}
?>

<h2 class="mt-5 mb-3">Ristkulik voi ruut</h2>
<form method="get" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="number" class="form-control" name="side1" placeholder="Kulg 1">
    </div>
    <div class="col-auto">
        <input type="number" class="form-control" name="side2" placeholder="Kulg 2">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Kontrolli</button>
    </div>
</form>
<?php
if (!empty($_GET['side1']) && !empty($_GET['side2'])) {
    $side1 = $_GET['side1'];
    $side2 = $_GET['side2'];
    if ($side1 == $side2) {
        echo "<div class='alert alert-success'>See on ruut.</div>";
    } else {
        echo "<div class='alert alert-success'>See on ristkulik.</div>";
    }
}
?>

<h2 class="mt-5 mb-3">Juubel</h2>
<form method="get" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="number" class="form-control" name="birth_year" placeholder="Sunniaasta">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Kontrolli</button>
    </div>
</form>
<?php
if (!empty($_GET['birth_year'])) {
    $birth_year = $_GET['birth_year'];
    $current_year = date("Y");
    $age = $current_year - $birth_year;
    if ($age % 10 == 0) {
        echo "<div class='alert alert-success'>$age on juubeliaasta!</div>";
    } else {
        echo "<div class='alert alert-success'>$age ei ole juubeliaasta.</div>";
    }
}
?>

<h2 class="mt-5 mb-3">Hinne</h2>
<form method="get" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="number" class="form-control" name="points" placeholder="Punktid">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Kontrolli</button>
    </div>
</form>
<?php
if (isset($_GET['points'])) {
    $points = $_GET['points'];
    if ($points === '') {
        echo "<div class='alert alert-danger'>SISESTA OMA PUNKTID!</div>";
    } else {
        switch (true) {
            case ($points > 10):
                echo "<div class='alert alert-success'>SUPER!</div>";
                break;
            case ($points >= 5 && $points <= 9):
                echo "<div class='alert alert-success'>TEHTUD!</div>";
                break;
            case ($points < 5):
                echo "<div class='alert alert-warning'>KASIN!</div>";
                break;
            default:
                echo "<div class='alert alert-danger'>SISESTA OMA PUNKTID!</div>";
                break;
        }
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
