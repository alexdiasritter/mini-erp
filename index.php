<?php
// Inicia ou recupera a sessão atual
session_start();

// Verifica se o usuário JÁ ESTÁ logado
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    // Se estiver logado, manda direto pro painel principal
    header('Location: dashboard.php');
    exit; // CRÍTICO: Para o script aqui. Sem isso, o código continua rodando!
} else {
    // Se NÃO estiver logado, manda pro login
    header('Location: login.php');
    exit;
}
?>