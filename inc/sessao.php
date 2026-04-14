<?php
/**
 * ARQUIVO: inc/sessao.php
 * FUNÇÃO: Proteger páginas contra acesso não autorizado
 */

// 1. INICIA A SESSÃO (se ainda não foi iniciada)
//    session_status() === PHP_SESSION_NONE é como verificar
//    if (session == null) { session = request.getSession(); }
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. VERIFICA SE O USUÁRIO ESTÁ LOGADO
//    isset() = verifica se a chave EXISTE no array
//    (evita erro se $_SESSION estiver vazia)
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    
    // 3. SE NÃO ESTIVER LOGADO: REDIRECIONA PARA LOGIN
    //    Guarda a URL que o usuário tentou acessar (para redirecionar depois do login)
    //    $_SERVER['REQUEST_URI'] = URL completa (ex: /produtos/editar.php?id=5)
    $_SESSION['url_tentada'] = $_SERVER['REQUEST_URI'];
    
    // 4. REDIRECIONA PARA LOGIN
    header('Location: /login.php');
    
    // 5. MATA O SCRIPT IMEDIATAMENTE
    //    Equivalente a: return; no meio de um método void
    exit;
}

// Se chegou até aqui, usuário está logado. Continua carregando a página normalmente.
?>