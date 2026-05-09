<?php

    $numeros = [10, 20, 30, 40, 50]; // Array de números

    echo "Percorrendo o array usando um loop foreach:<br>";

    echo "Números no array: ";

    // Percorrendo o array usando um loop foreach
    foreach ($numeros as $numero) {
        echo "$numero ";
    }

    echo "<br><br>Percorrendo o array usando um loop for:<br>";

    // Percorrendo o array usando um loop for
    for ($i = 0; $i < count($numeros); $i++) {
        echo "Número na posição $i: " . $numeros[$i] . "<br>";
    }

?>