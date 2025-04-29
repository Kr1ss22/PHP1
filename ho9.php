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
<form method="post" class="form-inline">
    <div class="form-group mb-2">
        <label for="name" class="sr-only">Nimi</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Sisesta oma nimi">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Tervita</button>
</form>
<?php
if (!empty($_POST['name'])) {
    $name = ucfirst(strtolower($_POST['name']));
    echo "Tere, $name!";
}
?>

<h2>Tähed punktidega</h2>
<form method="post" class="form-inline">
    <div class="form-group mb-2">
        <label for="text" class="sr-only">Tekst</label>
        <input type="text" class="form-control" id="text" name="text" placeholder="Sisesta tekst">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Lisa punktid</button>
</form>
<?php
if (!empty($_POST['text'])) {
    $text = strtoupper($_POST['text']);
    $text_with_dots = implode('.', str_split($text)) . '.';
    echo $text_with_dots;
}
?>

<h2>Ropud sõnad</h2>
<form method="post" class="form-inline">
    <div class="form-group mb-2">
        <label for="message" class="sr-only">Sõnum</label>
        <input type="text" class="form-control" id="message" name="message" placeholder="Sisesta sõnum">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Kuva sõnum</button>
</form>
<?php
if (!empty($_POST['message'])) {
    $message = $_POST['message'];
    $bad_words = ['noob', 'loll', 'idioot']; // 
    $clean_message = str_ireplace($bad_words, '***', $message);
    echo $clean_message;
}
?>

<h2>Emaili genereerimine</h2>
<form method="post" class="form-inline">
    <div class="form-group mb-2">
        <label for="firstname" class="sr-only">Eesnimi</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Eesnimi">
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <label for="lastname" class="sr-only">Perenimi</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Perenimi">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Genereeri email</button>
</form>
<?php
if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
    $firstname = strtolower($_POST['firstname']);
    $lastname = strtolower($_POST['lastname']);
    $search = ['ä', 'ö', 'ü', 'õ'];
    $replace = ['a', 'o', 'y', 'o'];
    $firstname = str_replace($search, $replace, $firstname);
    $lastname = str_replace($search, $replace, $lastname);
    $email = $firstname . '.' . $lastname . '@hkhk.edu.ee';
    echo $email;
}
?>

</body>
</html>