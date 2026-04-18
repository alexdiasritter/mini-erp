<?php
/**
 * ARQUIVO: inc/cabecalho.php
 * FUNÇÃO: Template HTML comum a todas as páginas internas
 * 
 * EQUIVALENTE JAVA: layout.html do Thymeleaf ou header.jsp
 * 
 * PRÉ-REQUISITO: A sessão já deve estar iniciada (via sessao.php)
 *                e $_SESSION['usuario_nome'] deve existir.
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini ERP - Sistema de Gestão</title>
    
    <!-- CSS INTERNO (Comum em sistemas legados PHP) -->
    <style>
        /* RESET BÁSICO */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
        }
        
        /* ===== TOPO (Header) ===== */
        .topo {
            background: #2c3e50;
            color: white;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .topo h1 {
            font-size: 20px;
            font-weight: 500;
        }
        
        .topo .usuario-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .topo .usuario-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .topo .usuario-info .perfil-badge {
            background: <?= $_SESSION['usuario_perfil'] === 'admin' ? '#e74c3c' : '#3498db' ?>;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .topo .btn-sair {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .topo .btn-sair:hover {
            background: #c0392b;
        }
        
        /* ===== CONTAINER PRINCIPAL (Flexbox) ===== */
        .container {
            display: flex;
            min-height: calc(100vh - 60px); /* Altura total menos topo */
        }
        
        /* ===== MENU LATERAL ===== */
        .menu-lateral {
            width: 260px;
            background: #34495e;
            padding: 20px 0;
        }
        
        .menu-lateral ul {
            list-style: none;
        }
        
        .menu-lateral li {
            margin-bottom: 2px;
        }
        
        .menu-lateral a {
            display: block;
            padding: 12px 25px;
            color: #ecf0f1;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .menu-lateral a:hover {
            background: #2c3e50;
            border-left-color: #3498db;
            padding-left: 30px;
        }
        
        .menu-lateral a.ativo {
            background: #2c3e50;
            border-left-color: #e74c3c;
            font-weight: bold;
        }
        
        .menu-lateral .divisor {
            height: 1px;
            background: #4a627a;
            margin: 15px 0;
        }
        
        .menu-lateral .menu-titulo {
            color: #95a5a6;
            font-size: 12px;
            text-transform: uppercase;
            padding: 5px 25px;
            margin-top: 10px;
            letter-spacing: 1px;
        }
        
        /* ===== CONTEÚDO PRINCIPAL ===== */
        .conteudo {
            flex: 1;
            padding: 30px;
            background: #f4f6f9;
        }
        
        /* ===== ELEMENTOS REUTILIZÁVEIS ===== */
        .page-title {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 300;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .card-header h2, .card-header h3 {
            color: #2c3e50;
            margin: 0;
        }
        
        /* Tabelas */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        .table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #dee2e6;
            font-size: 14px;
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        /* Botões */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            margin: 2px;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0069d9;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        
        .btn-warning:hover {
            background: #e0a800;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        /* Alertas / Mensagens */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left-color: #ffc107;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }
        
        /* Formulários */
        .form-group {
            margin-bottom: 18px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        /* Badges / Tags */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .badge-info {
            background: #17a2b8;
            color: white;
        }
        
        /* Utilitários */
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-muted {
            color: #6c757d;
        }
        
        .mb-1 { margin-bottom: 10px; }
        .mb-2 { margin-bottom: 20px; }
        .mb-3 { margin-bottom: 30px; }
        .mt-1 { margin-top: 10px; }
        .mt-2 { margin-top: 20px; }
        .mt-3 { margin-top: 30px; }
        
        /* Grid para Cards */
        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- TOPO DO SISTEMA -->
    <div class="topo">
        <h1>🏢 <?= $_SESSION['config']['nome_empresa'] ?? 'Mini ERP' ?></h1>
        <div class="usuario-area">
            <div class="usuario-info">
                <span>👤 <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                <span class="perfil-badge"><?= $_SESSION['usuario_perfil'] ?></span>
            </div>
            <a href="/logout.php" class="btn-sair">🚪 Sair</a>
        </div>
    </div>
    
    <!-- CONTAINER FLEX (Menu + Conteúdo) -->
    <div class="container">
        <!-- MENU LATERAL -->
        <div class="menu-lateral">
            <ul>
                <li><a href="/dashboard.php" <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'class="ativo"' : '' ?>>
                    📊 Dashboard
                </a></li>
                
                <li class="divisor"></li>
                <li class="menu-titulo">Produtos</li>
                
                <li><a href="/produtos/listar.php" <?= strpos($_SERVER['PHP_SELF'], '/produtos/listar') !== false ? 'class="ativo"' : '' ?>>
                    📦 Listar Produtos
                </a></li>
                <li><a href="/produtos/criar.php" <?= strpos($_SERVER['PHP_SELF'], '/produtos/criar') !== false ? 'class="ativo"' : '' ?>>
                    ➕ Novo Produto
                </a></li>
                
                <?php if ($_SESSION['usuario_perfil'] === 'admin'): ?>
                <li class="divisor"></li>
                <li class="menu-titulo">Administração</li>
                
                <li><a href="/usuarios/listar.php" <?= strpos($_SERVER['PHP_SELF'], '/usuarios/') !== false ? 'class="ativo"' : '' ?>>
                    👥 Gerenciar Usuários
                </a></li>
                <?php endif; ?>
                
                <li class="divisor"></li>
                <li class="menu-titulo">Relatórios</li>
                
                <li><a href="/relatorios/produtos.php" <?= strpos($_SERVER['PHP_SELF'], '/relatorios/') !== false ? 'class="ativo"' : '' ?>>
                    📈 Relatório de Produtos
                </a></li>
            </ul>
        </div>
        
        <!-- ÁREA DE CONTEÚDO PRINCIPAL -->
        <div class="conteudo">
            <!-- Mensagens Flash (via GET) -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success">
                    ✅ <?= htmlspecialchars($_GET['msg']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger">
                    ❌ <?= htmlspecialchars($_GET['erro']) ?>
                </div>
            <?php endif; ?>