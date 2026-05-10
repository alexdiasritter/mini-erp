<?php

$palavra = "dpviowdnlxkmaaspdjrijapsisdouvnghcda";
$vogais = ['a' => 0, 'e' => 0, 'i' => 0, 'o' => 0, 'u' => 0];

for ($i = 0; $i < strlen($palavra); $i++) {

    $letra = strtolower($palavra[$i]);

    if (isset($vogais[$letra])) {
        $vogais[$letra]++;
    }
}

foreach ($vogais as $vogal => $quantidade) {
    echo "Vogal '$vogal': $quantidade vez(es)\n";
}

?>