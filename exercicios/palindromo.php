<?php
$original = "ana";
$ehPalindromo = true;

// conseguimos acessar cada caractere através do índice da string
// echo $palavra[0]; // ana
// a 

$palavra = str_replace(' ', '', $original);
$palavra = strtolower($palavra);

for ($i = 0; $i < strlen($palavra) / 2; $i++) {
    // strlen de palavra tem o -1 pra n pegar o índice fora do array no final
    if ($palavra[$i] != $palavra[strlen($palavra) - 1 - $i]) {
        $ehPalindromo = false;
        break;
    }
}

echo $ehPalindromo ? "\n$original é um palíndromo\n\n" : "\n$original não é um palíndromo\n";
?>