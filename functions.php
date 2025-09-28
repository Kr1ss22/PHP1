<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <title>Ristküliku kalkulaator</title>
</head>
<body>
  <form method="post">
    Laius: <input type="number" name="laius" ><br><br>
    Kõrgus: <input type="number" name="korgus" ><br><br>
    <button type="submit">Arvuta</button>
  </form>

  <?php
  function ristkylik($laius, $korgus) {
      $pindala = $laius * $korgus;
      $umbermoot = 2 * ($laius + $korgus);
      return ["pindala" => $pindala, "umbermoot" => $umbermoot];
  }

  if ($_POST) {
      $laius = $_POST["laius"];
      $korgus = $_POST["korgus"];
      $tulemus = ristkylik($laius, $korgus);

      echo "<h3>Pindala: {$tulemus['pindala']}<br>Ümbermõõt: {$tulemus['umbermoot']}</h3>";
  }
  ?>
</body>
</html>