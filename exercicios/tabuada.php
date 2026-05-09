<?php

    $numero = 5; // Número para o qual queremos a tabuada

    echo "Tabuada do $numero:<br>";

    for ($i = 1; $i <= 10; $i++) {
        $resultado = $numero * $i;
        echo "$numero x $i = $resultado<br>";
    }

?>
