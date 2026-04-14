<?php
/**
 * ARQUIVO: login.php
 * FUNÇÃO: Autenticar usuário e iniciar sessão
 * 
 * EQUIVALENTE JAVA: Método doPost() em um LoginServlet
 * que valida credenciais e cria HttpSession
 */

// 1. INICIA A SESSÃO (OBRIGATÓRIO para usar $_SESSION)
session_start();

// 2. VERIFICA SE O USUÁRIO JÁ ESTÁ LOGADO
//    Se já estiver, não faz sentido ficar na tela de login.
//    Redireciona direto pro dashboard.
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: dashboard.php');
    exit; // PARE TUDO - igual return em Java
}

// 3. VERIFICA SE É PRIMEIRO ACESSO (dados mock não existem)
//    Equivalente a: if (database.isEmpty()) { inicializarDados(); }
if (!isset($_SESSION['usuarios'])) {
    // include = "import" em Java. Puxa o código do arquivo e executa aqui.
    include 'inc/dados-iniciais.php';
}

// 4. VARIÁVEL PARA MENSAGEM DE ERRO
//    Equivalente a: String erro = null;
$erro = '';

// 5. PROCESSAMENTO DO FORMULÁRIO (Método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 5.1 Pega os dados do formulário
    //     $_POST é um array com todos os campos do form
    //     O operador ?? é o "Elvis" do PHP: se não existir, usa valor padrão ''
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // 5.2 Busca o usuário no "banco" (array $_SESSION['usuarios'])
    $usuarioEncontrado = null;
    
    foreach ($_SESSION['usuarios'] as $usuario) {
        // Verifica email, senha E se o usuário está ativo
        if ($usuario['email'] === $email && 
            $usuario['senha'] === $senha && 
            $usuario['ativo'] === true) {
            
            $usuarioEncontrado = $usuario;
            break; // Sai do foreach (achou!)
        }
    }
    
    // 5.3 Se encontrou usuário válido...
    if ($usuarioEncontrado !== null) {
        
        // CRIA A SESSÃO DO USUÁRIO
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
        $_SESSION['usuario_nome'] = $usuarioEncontrado['nome'];
        $_SESSION['usuario_email'] = $usuarioEncontrado['email'];
        $_SESSION['usuario_perfil'] = $usuarioEncontrado['perfil'];
        
        // 5.4 Registra no log de auditoria
        //     Criamos um array e adicionamos no final de $_SESSION['logs']
        $novoLog = [
            'data' => date('d/m/Y H:i:s'),           // Data/hora atual
            'usuario' => $usuarioEncontrado['nome'],
            'acao' => 'Login realizado com sucesso',
            'ip' => $_SERVER['REMOTE_ADDR']          // IP do cliente
        ];
        $_SESSION['logs'][] = $novoLog; // [] adiciona no final do array
        
        // 5.5 Redireciona para o painel principal
        header('Location: dashboard.php');
        exit; // NUNCA ESQUEÇA O EXIT DEPOIS DE HEADER
        
    } else {
        // 5.6 Credenciais inválidas
        $erro = 'Email ou senha inválidos, ou usuário desativado!';
        
        // Também logamos tentativa falha (segurança)
        $novoLog = [
            'data' => date('d/m/Y H:i:s'),
            'usuario' => 'DESCONHECIDO',
            'acao' => "Tentativa de login falhou para email: {$email}",
            'ip' => $_SERVER['REMOTE_ADDR']
        ];
        $_SESSION['logs'][] = $novoLog;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mini ERP</title>
    <style>
        /* CSS INLINE - Comum em sistemas legados */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 28px;
        }
        
        .login-header p {
            color: #666;
            margin-top: 5px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-login:hover {
            background: #5a67d8;
        }
        
        .erro-mensagem {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #fcc;
            text-align: center;
        }
        
        .dica-login {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 13px;
            color: #666;
        }
        
        .dica-login strong {
            color: #333;
            display: block;
            margin-bottom: 8px;
        }
        
        .dica-login code {
            background: #e9ecef;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🏢 Mini ERP</h1>
            <p>Sistema de Gestão Empresarial</p>
        </div>
        
        <?php if ($erro !== ''): ?>
        <!-- 
            Se $erro não for vazio, mostra a div de erro.
            <?= $variavel ?> é atalho para <?php echo $variavel; ?>
        -->
        <div class="erro-mensagem">
            <?= htmlspecialchars($erro) ?>
            <!-- 
                htmlspecialchars() PREVINE XSS.
            -->
        </div>
        <?php endif; ?>
        
        <!-- 
            Formulário HTML.
            method="POST": Envia dados no corpo da requisição (não na URL)
            action="": Vazio = envia para a MESMA URL (login.php)
        -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">📧 Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="seu@email.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                    autofocus
                >
                <!-- 
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    Mantém o email digitado quando o login falha.
                    Melhor UX que limpar o campo.
                -->
            </div>
            
            <div class="form-group">
                <label for="senha">🔒 Senha</label>
                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    placeholder="••••••••"
                    required
                >
            </div>
            
            <button type="submit" class="btn-login">
                Entrar no Sistema
            </button>
        </form>
        
        <div class="dica-login">
            <strong>🔑 Credenciais para Teste:</strong>
            <div style="margin-top: 8px;">
                <code>admin@empresa.com / 123456</code> (Admin)<br>
                <code>joao@empresa.com / 123456</code> (Usuário)<br>
                <code>maria@empresa.com / 123456</code> (Usuário)
            </div>
            <p style="margin-top: 10px; font-style: italic;">
                ⚠️ Sistema em modo demonstração - dados salvos em memória
            </p>
        </div>
    </div>
</body>
</html>