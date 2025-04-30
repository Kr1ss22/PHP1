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
        <h1>Harjutus 06</h1>
        <div class="row">
            <div class="col-md-4">
                <?php

                echo "<h2>1. Genereeri</h2>";

                $number = 1;
                do{
                    echo $number.' '; 
                    $number++;	
                } while($number <=100);

                echo "<br>";
                echo "<br>";
                $arv = 1;
                while($arv <=10){
                    echo $arv.'<br>'; 
                    $arv++;	
                }

                echo "<br>";

                $arv1 = 1;
                while($arv1 <=10){
                    echo "$arv1. "; 
                    $arv1++;	
                }

                echo "<br>";
                echo "<br>";

                echo "<h2>2. Rida</h2>";


                for($pikkus=1; $pikkus<=10; $pikkus++){ 
                    echo '*';
                }

                echo "<br>";
                echo "<br>";

                echo "<h2>3. Rida II</h2>";


                for($pikkus=1; $pikkus<=10; $pikkus++){ 
                    echo '*<br>';
                }

                echo "<br>";

                echo "<h2>4. Ruut</h2>";

                for($rida=1; $rida<=5; $rida++){ 
                    for($veerg=1; $veerg<=5; $veerg++){ 
                            echo '* ';	
                        }
                    echo '<br>';
                }
                echo "<br>";

                echo "<h2>5. Kahanev</h2>";

                $kahanev = 10;
                while($kahanev >=1){
                    echo $kahanev.'<br>'; 
                    $kahanev--;	
                }
                
                echo "<br>";

                echo "<h2>6. Kolmega jagunevad</h2>";

                $number = 1;
                do{
                    if($number % 3 == 0){
                        echo $number.' '; 
                    }
                    $number++;	
                } while($number <=100);

                echo "<br>";

                echo "<h2>7. Kolmega jagunevad</h2>";

                $naised = array('Mario', 'Tehvan', 'Roomet');

                $mehed = array('Agata', 'rohkem', 'eitea');

                for($kogus=0; $kogus<count($naised); $kogus++){
                    echo $naised[$kogus].' - '.$mehed[$kogus].'<br>';
                }

                echo "<br>";


                ?>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
