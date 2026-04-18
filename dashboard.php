    <?php
/**
 * ARQUIVO: dashboard.php
 * FUNÇÃO: Painel principal pós-login com indicadores e resumos
 * 
 * EQUIVALENTE JAVA: HomeController - página inicial após autenticação
 */

// 1. PROTEGE A PÁGINA (OBRIGATÓRIO)
require_once 'inc/sessao.php';

// 2. INICIALIZA VARIÁVEIS PARA OS CARDS
$totalProdutos = 0;
$totalProdutosAtivos = 0;
$totalProdutosInativos = 0;
$valorTotalEstoque = 0.0;
$produtosBaixoEstoque = 0;
$produtosSemEstoque = 0;
$totalUsuariosAtivos = 0;
$totalUsuariosInativos = 0;

// 3. CALCULA MÉTRICAS DE PRODUTOS
if (isset($_SESSION['produtos']) && is_array($_SESSION['produtos'])) {
    
    foreach ($_SESSION['produtos'] as $produto) {
        $totalProdutos++;
        
        // Verifica se produto está ativo
        if ($produto['ativo'] === true) {
            $totalProdutosAtivos++;
            
            // Calcula valor em estoque
            $valorTotalEstoque += floatval($produto['preco']) * intval($produto['estoque']);
            
            // Classifica nível de estoque
            $estoque = intval($produto['estoque']);
            if ($estoque == 0) {
                $produtosSemEstoque++;
            } elseif ($estoque < 5) {
                $produtosBaixoEstoque++;
            }
        } else {
            $totalProdutosInativos++;
        }
    }
}

// 4. CALCULA MÉTRICAS DE USUÁRIOS
if (isset($_SESSION['usuarios']) && is_array($_SESSION['usuarios'])) {
    foreach ($_SESSION['usuarios'] as $usuario) {
        if ($usuario['ativo'] === true) {
            $totalUsuariosAtivos++;
        } else {
            $totalUsuariosInativos++;
        }
    }
}

// 5. PREPARA ÚLTIMOS PRODUTOS (para tabela)
$ultimosProdutos = [];
if (isset($_SESSION['produtos'])) {
    $produtosInvertidos = array_reverse($_SESSION['produtos']);
    $ultimosProdutos = array_slice($produtosInvertidos, 0, 5);
}

// 6. PREPARA ÚLTIMOS LOGS (para tabela de auditoria)
$ultimosLogs = [];
if (isset($_SESSION['logs'])) {
    $logsInvertidos = array_reverse($_SESSION['logs']);
    $ultimosLogs = array_slice($logsInvertidos, 0, 10);
}

// 7. FORMATA SAUDAÇÃO PERSONALIZADA
$nomeCompleto = $_SESSION['usuario_nome'];
$partesNome = explode(' ', $nomeCompleto);
$primeiroNome = $partesNome[0];

$horaAtual = intval(date('H'));
if ($horaAtual < 12) {
    $saudacao = 'Bom dia';
} elseif ($horaAtual < 18) {
    $saudacao = 'Boa tarde';
} else {
    $saudacao = 'Boa noite';
}

// 8. CARREGA O CABEÇALHO HTML
include 'inc/cabecalho.php';
?>

<!-- ============================================ -->
<!-- CONTEÚDO PRINCIPAL DO DASHBOARD              -->
<!-- ============================================ -->

<!-- Título com Saudação -->
<div style="margin-bottom: 25px;">
    <h1 style="color: #2c3e50; margin-bottom: 5px; font-size: 28px; font-weight: 300;">
        <?= $saudacao ?>, <?= htmlspecialchars($primeiroNome) ?>! 👋
    </h1>
    <p style="color: #7f8c8d; font-size: 14px;">
        📅 <?= date('d/m/Y') ?> • 
        🕐 Último acesso: <?= date('H:i:s') ?> • 
        🔐 Perfil: <strong><?= ucfirst($_SESSION['usuario_perfil']) ?></strong>
    </p>
</div>

<!-- ============================================ -->
<!-- CARDS DE INDICADORES (4 colunas)             -->
<!-- ============================================ -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    
    <!-- Card 1: Total de Produtos -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 5px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                    📦 TOTAL PRODUTOS
                </p>
                <h2 style="font-size: 36px; margin: 0; font-weight: bold;">
                    <?= $totalProdutosAtivos ?>
                </h2>
                <p style="opacity: 0.8; font-size: 12px; margin-top: 5px;">
                    +<?= $totalProdutosInativos ?> inativos
                </p>
            </div>
            <div style="font-size: 48px; opacity: 0.5;">📦</div>
        </div>
    </div>
    
    <!-- Card 2: Valor em Estoque -->
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
                color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 5px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                    💰 VALOR EM ESTOQUE
                </p>
                <h2 style="font-size: 28px; margin: 0; font-weight: bold;">
                    R$ <?= number_format($valorTotalEstoque, 2, ',', '.') ?>
                </h2>
                <p style="opacity: 0.8; font-size: 12px; margin-top: 5px;">
                    Custo total inventário
                </p>
            </div>
            <div style="font-size: 48px; opacity: 0.5;">💰</div>
        </div>
    </div>
    
    <!-- Card 3: Alertas de Estoque -->
    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); 
                color: #333; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 5px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                    ⚠️ ALERTAS ESTOQUE
                </p>
                <h2 style="font-size: 36px; margin: 0; font-weight: bold; 
                           color: <?= ($produtosBaixoEstoque + $produtosSemEstoque) > 0 ? '#d63031' : '#00b894' ?>;">
                    <?= $produtosBaixoEstoque + $produtosSemEstoque ?>
                </h2>
                <p style="opacity: 0.8; font-size: 12px; margin-top: 5px;">
                    <?= $produtosBaixoEstoque ?> baixo • <?= $produtosSemEstoque ?> zerado
                </p>
            </div>
            <div style="font-size: 48px; opacity: 0.5;">⚠️</div>
        </div>
    </div>
    
    <!-- Card 4: Usuários Ativos -->
    <div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); 
                color: #333; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 5px; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                    👥 USUÁRIOS ATIVOS
                </p>
                <h2 style="font-size: 36px; margin: 0; font-weight: bold;">
                    <?= $totalUsuariosAtivos ?>
                </h2>
                <p style="opacity: 0.8; font-size: 12px; margin-top: 5px;">
                    +<?= $totalUsuariosInativos ?> inativos
                </p>
            </div>
            <div style="font-size: 48px; opacity: 0.5;">👥</div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- SEÇÃO DE TABELAS (2 colunas)                 -->
<!-- ============================================ -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    
    <!-- Tabela 1: Últimos Produtos Cadastrados -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px 20px 15px 20px; border-bottom: 1px solid #eee; 
                    display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #2c3e50; font-size: 18px;">📋 Últimos Produtos</h3>
            <a href="/produtos/listar.php" style="color: #667eea; text-decoration: none; font-size: 14px; font-weight: 500;">
                Ver todos →
            </a>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: #555;">Produto</th>
                    <th style="padding: 12px; text-align: right; font-size: 13px; color: #555;">Preço</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; color: #555;">Estoque</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ultimosProdutos)): ?>
                    <tr>
                        <td colspan="3" style="padding: 30px; text-align: center; color: #999;">
                            📭 Nenhum produto cadastrado
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ultimosProdutos as $p): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center;">
                                <span style="font-size: 20px; margin-right: 10px;">
                                    <?= $p['categoria'] == 'Informática' ? '💻' : 
                                        ($p['categoria'] == 'Periféricos' ? '🖱️' : 
                                        ($p['categoria'] == 'Monitores' ? '🖥️' : '📦')) ?>
                                </span>
                                <div>
                                    <strong style="color: #2c3e50;"><?= htmlspecialchars($p['nome']) ?></strong><br>
                                    <small style="color: #999;"><?= $p['codigo'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px; text-align: right; font-weight: bold; color: #2c3e50;">
                            R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?php 
                            $estoque = $p['estoque'];
                            if ($estoque == 0) {
                                $corFundo = '#dc3545';
                                $corTexto = 'white';
                                $texto = 'Zerado';
                            } elseif ($estoque < 5) {
                                $corFundo = '#ffc107';
                                $corTexto = '#333';
                                $texto = $estoque;
                            } else {
                                $corFundo = '#28a745';
                                $corTexto = 'white';
                                $texto = $estoque;
                            }
                            ?>
                            <span style="background: <?= $corFundo ?>; color: <?= $corTexto ?>; 
                                         padding: 4px 10px; border-radius: 20px; font-size: 12px; 
                                         font-weight: bold; min-width: 50px; display: inline-block;">
                                <?= $texto ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (!empty($ultimosProdutos)): ?>
        <div style="padding: 12px 20px; background: #f8f9fa; border-top: 1px solid #eee; text-align: center;">
            <a href="/produtos/criar.php" style="color: #28a745; text-decoration: none; font-weight: 500;">
                ➕ Adicionar novo produto
            </a>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Tabela 2: Logs de Atividade -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px 20px 15px 20px; border-bottom: 1px solid #eee;">
            <h3 style="margin: 0; color: #2c3e50; font-size: 18px;">📝 Atividades Recentes</h3>
        </div>
        
        <div style="max-height: 400px; overflow-y: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php if (empty($ultimosLogs)): ?>
                        <tr>
                            <td style="padding: 30px; text-align: center; color: #999;">
                                📭 Nenhuma atividade registrada
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ultimosLogs as $log): ?>
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td style="padding: 12px;">
                                <div style="display: flex; align-items: flex-start;">
                                    <span style="font-size: 20px; margin-right: 10px;">
                                        <?php 
                                        if (strpos($log['acao'], 'Login') !== false) echo '🔐';
                                        elseif (strpos($log['acao'], 'Criou') !== false) echo '➕';
                                        elseif (strpos($log['acao'], 'Editou') !== false) echo '✏️';
                                        elseif (strpos($log['acao'], 'Excluiu') !== false) echo '🗑️';
                                        else echo '📌';
                                        ?>
                                    </span>
                                    <div style="flex: 1;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                            <strong style="color: #2c3e50; font-size: 13px;">
                                                <?= htmlspecialchars($log['usuario']) ?>
                                            </strong>
                                            <span style="color: #999; font-size: 11px;">
                                                <?= htmlspecialchars($log['data']) ?>
                                            </span>
                                        </div>
                                        <p style="color: #666; font-size: 13px; margin: 0;">
                                            <?= htmlspecialchars($log['acao']) ?>
                                        </p>
                                        <small style="color: #999; font-size: 10px;">
                                            IP: <?= htmlspecialchars($log['ip']) ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- AÇÕES RÁPIDAS                               -->
<!-- ============================================ -->
<div style="display: flex; gap: 10px; margin-bottom: 20px;">
    <a href="/produtos/criar.php" style="background: #28a745; color: white; text-decoration: none; 
                                         padding: 12px 24px; border-radius: 5px; font-weight: 500;
                                         display: inline-flex; align-items: center; gap: 8px;
                                         box-shadow: 0 2px 4px rgba(40,167,69,0.3);">
        ➕ Novo Produto
    </a>
    
    <a href="/produtos/listar.php" style="background: #6c757d; color: white; text-decoration: none; 
                                           padding: 12px 24px; border-radius: 5px; font-weight: 500;
                                           display: inline-flex; align-items: center; gap: 8px;">
        📦 Gerenciar Produtos
    </a>
    
    <?php if ($_SESSION['usuario_perfil'] === 'admin'): ?>
    <a href="/usuarios/listar.php" style="background: #007bff; color: white; text-decoration: none; 
                                          padding: 12px 24px; border-radius: 5px; font-weight: 500;
                                          display: inline-flex; align-items: center; gap: 8px;
                                          box-shadow: 0 2px 4px rgba(0,123,255,0.3);">
        👥 Gerenciar Usuários
    </a>
    <?php endif; ?>
    
    <a href="/relatorios/produtos.php" style="background: #17a2b8; color: white; text-decoration: none; 
                                            padding: 12px 24px; border-radius: 5px; font-weight: 500;
                                            display: inline-flex; align-items: center; gap: 8px;">
        📊 Relatório de Estoque
    </a>
</div>

<!-- ============================================ -->
<!-- INFORMAÇÕES DO SISTEMA (Rodapé do conteúdo) -->
<!-- ============================================ -->
<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; 
            display: flex; justify-content: space-between; color: #999; font-size: 12px;">
    <div>
        🏢 <?= $_SESSION['config']['nome_empresa'] ?? 'Mini ERP' ?> • 
        Versão <?= $_SESSION['config']['versao_sistema'] ?? '1.0.0' ?>
    </div>
    <div>
        📅 Sistema criado em <?= $_SESSION['config']['data_criacao'] ?? date('d/m/Y') ?> • 
        🟢 Online
    </div>
</div>

<?php 
// 9. INCLUI O RODAPÉ
include 'inc/rodape.php'; 
?>