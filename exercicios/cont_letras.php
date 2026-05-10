<?php

$palavra = "dpviowdnlxkmaaaaspdjrijapsisdouvnghcda";
$acumulador = 0;

for($i = 0; $i < strlen($palavra); $i++) {
    if ($palavra[$i] == "a") {
        $acumulador++;
    }
}

echo "\na palavra repete a letra 'A' $acumulador vezes\n\n"

?>