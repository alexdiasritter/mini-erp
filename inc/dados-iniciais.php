<?php
/**
 * ARQUIVO: inc/dados-iniciais.php
 * FUNÇÃO: Popular o sistema com dados mock (falsos) para teste
 * 
 * EQUIVALENTE JAVA: Uma classe que insere registros no H2 Database
 * quando a aplicação sobe pela primeira vez.
 */

// =============================================
// 1. TABELA DE USUÁRIOS (Simulando SELECT * FROM usuarios)
// =============================================
$_SESSION['usuarios'] = [
    // Cada item do array é um registro (linha da tabela)
    [
        'id' => 1,
        'nome' => 'Administrador',
        'email' => 'admin@empresa.com',
        'senha' => '123456',        // EM PRODUÇÃO: Use password_hash()
        'perfil' => 'admin',         // 'admin' ou 'usuario'
        'ativo' => true
    ],
    [
        'id' => 2,
        'nome' => 'João Silva',
        'email' => 'joao@empresa.com',
        'senha' => '123456',
        'perfil' => 'usuario',
        'ativo' => true
    ],
    [
        'id' => 3,
        'nome' => 'Maria Santos',
        'email' => 'maria@empresa.com',
        'senha' => '123456',
        'perfil' => 'usuario',
        'ativo' => true
    ],
    [
        'id' => 4,
        'nome' => 'Carlos Inativo',
        'email' => 'carlos@empresa.com',
        'senha' => '123456',
        'perfil' => 'usuario',
        'ativo' => false            // Usuário desativado - não consegue logar
    ]
];

// =============================================
// 2. TABELA DE PRODUTOS (Simulando SELECT * FROM produtos)
// =============================================
$_SESSION['produtos'] = [
    [
        'id' => 1,
        'codigo' => 'NOTE-001',
        'nome' => 'Notebook Dell Inspiron 15',
        'preco' => 3599.90,
        'estoque' => 8,
        'categoria' => 'Informática',
        'ativo' => true
    ],
    [
        'id' => 2,
        'codigo' => 'MOUSE-022',
        'nome' => 'Mouse Logitech MX Master 3S',
        'preco' => 89.90,
        'estoque' => 45,
        'categoria' => 'Periféricos',
        'ativo' => true
    ],
    [
        'id' => 3,
        'codigo' => 'TECL-105',
        'nome' => 'Teclado Mecânico Redragon Kumara',
        'preco' => 249.99,
        'estoque' => 23,
        'categoria' => 'Periféricos',
        'ativo' => true
    ],
    [
        'id' => 4,
        'codigo' => 'MONI-004',
        'nome' => 'Monitor LG 24" Full HD',
        'preco' => 799.00,
        'estoque' => 12,
        'categoria' => 'Monitores',
        'ativo' => true
    ],
    [
        'id' => 5,
        'codigo' => 'SSD-256',
        'nome' => 'SSD Kingston 480GB',
        'preco' => 219.90,
        'estoque' => 3,              // Estoque baixo (vai aparecer alerta no dashboard)
        'categoria' => 'Armazenamento',
        'ativo' => true
    ],
    [
        'id' => 6,
        'codigo' => 'IMPR-009',
        'nome' => 'Impressora HP DeskJet 2776',
        'preco' => 329.90,
        'estoque' => 0,              // Sem estoque
        'categoria' => 'Impressão',
        'ativo' => false            // Produto inativo (não aparece nas listas)
    ]
];

// =============================================
// 3. TABELA DE LOGS (Auditoria - Quem fez o quê)
// =============================================
$_SESSION['logs'] = [
    [
        'data' => date('d/m/Y H:i:s', strtotime('-2 hours')), // 2 horas atrás
        'usuario' => 'Administrador',
        'acao' => 'Sistema inicializado com dados mock',
        'ip' => '127.0.0.1'
    ],
    [
        'data' => date('d/m/Y H:i:s', strtotime('-1 hour')),
        'usuario' => 'Administrador',
        'acao' => 'Login realizado',
        'ip' => '127.0.0.1'
    ]
];

// =============================================
// 4. CONFIGURAÇÕES GLOBAIS (Opcional)
// =============================================
$_SESSION['config'] = [
    'nome_empresa' => 'Mini ERP Ltda',
    'versao_sistema' => '1.0.0',
    'data_criacao' => date('Y-m-d')
];
?>