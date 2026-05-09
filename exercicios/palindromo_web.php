<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Verificador de Palíndromo</title>
</head>
<body>
    <h1>Verificador de Palíndromo</h1>
    
    <form method="POST" action="">
        <label>Digite uma palavra:</label>
        <input type="text" name="palavra" required>
        <button type="submit">Verificar</button>
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $original = $_POST['palavra'];
        $ehPalindromo = true;

        $palavra = str_replace(' ', '', $original);
        $palavra = strtolower($palavra);
        
        for ($i = 0; $i < strlen($palavra) / 2; $i++) {
            if ($palavra[$i] != $palavra[strlen($palavra) - 1 - $i]) {
                $ehPalindromo = false;
                break;
            }
        }
        
        echo "<hr>";
        
        if ($ehPalindromo) {
            echo "<p style='color: green'>$original É UM PALÍNDROMO!</p>";
        } else {
            echo "<p style='color: red'>$original NÃO É UM PALÍNDROMO!</p>";
        }
    }
    ?>
</body>
</html>