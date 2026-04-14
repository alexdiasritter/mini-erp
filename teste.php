<?php
session_start();
include 'inc/dados-iniciais.php';

echo "<pre>"; // Formata a saída como texto puro (bom para debug)
print_r($_SESSION); // Equivalente a System.out.println(map.toString()) no Java
echo "</pre>";
?>