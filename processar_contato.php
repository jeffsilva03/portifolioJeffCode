<?php
// Ativar todos os erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Log de início
error_log("=== INÍCIO PROCESSAMENTO CONTATO ===");
error_log("Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST data: " . print_r($_POST, true));

require_once 'config.php';

// Função para limpar dados de entrada
function limparDados($dados) {
    return htmlspecialchars(strip_tags(trim($dados)));
}

// Função para validar email
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Processando POST request");
    
    // Receber e limpar os dados do formulário
    $nome = limparDados($_POST['nome'] ?? '');
    $email = limparDados($_POST['email'] ?? '');
    $telefone = limparDados($_POST['telefone'] ?? '');
    $mensagem = limparDados($_POST['mensagem'] ?? '');
    
    error_log("Dados limpos - Nome: $nome, Email: $email, Telefone: $telefone");
    
    // Array para armazenar erros
    $erros = [];
    
    // Validações
    if (empty($nome)) {
        $erros[] = "Nome é obrigatório";
        error_log("Erro: Nome vazio");
    }
    
    if (empty($email)) {
        $erros[] = "Email é obrigatório";
        error_log("Erro: Email vazio");
    } elseif (!validarEmail($email)) {
        $erros[] = "Email inválido";
        error_log("Erro: Email inválido - $email");
    }
    
    if (empty($mensagem)) {
        $erros[] = "Mensagem é obrigatória";
        error_log("Erro: Mensagem vazia");
    }
    
    error_log("Total de erros de validação: " . count($erros));
    
    // Se não há erros, salvar no banco de dados
    if (empty($erros)) {
        error_log("Iniciando conexão com banco...");
        
        try {
            $pdo = conectarBanco();
            error_log("Conexão estabelecida com sucesso");
            
            // Preparar a query
            $sql = "INSERT INTO contatos (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            error_log("Query preparada: $sql");
            
            // Executar a inserção
            $resultado = $stmt->execute([$nome, $email, $telefone, $mensagem]);
            error_log("Resultado da execução: " . ($resultado ? 'true' : 'false'));
            
            if ($resultado) {
                $id_inserido = $pdo->lastInsertId();
                $sucesso = "Mensagem enviada com sucesso! Entraremos em contato em breve por meio do e-mail informado";
                
                error_log("SUCESSO - Contato inserido - ID: $id_inserido, Nome: $nome, Email: $email");
                
                // Verificar se realmente foi inserido
                $stmt_verify = $pdo->prepare("SELECT * FROM contatos WHERE id = ?");
                $stmt_verify->execute([$id_inserido]);
                $registro = $stmt_verify->fetch();
                
                if ($registro) {
                    error_log("Verificação OK - Registro encontrado no banco");
                } else {
                    error_log("ALERTA - Registro não encontrado após inserção!");
                }
                
            } else {
                $erros[] = "Erro ao executar a inserção no banco de dados.";
                $error_info = $stmt->errorInfo();
                error_log("Erro na inserção - errorInfo: " . print_r($error_info, true));
            }
            
        } catch (PDOException $e) {
            $erros[] = "Erro no banco de dados: " . $e->getMessage();
            error_log("Erro PDO: " . $e->getMessage() . " | Linha: " . $e->getLine() . " | Arquivo: " . $e->getFile());
            
        } catch (Exception $e) {
            $erros[] = "Erro geral: " . $e->getMessage();
            error_log("Erro geral: " . $e->getMessage());
        }
    }
    
    // Iniciar sessão
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        error_log("Sessão iniciada");
    }
    
    // Definir mensagens na sessão
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        error_log("Erros definidos na sessão: " . print_r($erros, true));
    } else {
        $_SESSION['sucesso'] = $sucesso;
        error_log("Sucesso definido na sessão: $sucesso");
    }
    
    error_log("Redirecionando para: index.php#contato");
    
    // Redirecionar para a página do portfólio
    header('Location: index.php#contato');
    exit;
    
} else {
    error_log("Request não é POST - Method: " . $_SERVER['REQUEST_METHOD']);
    // Se não foi POST, redirecionar para a página principal
    header('Location: index.php');
    exit;
}

error_log("=== FIM PROCESSAMENTO CONTATO ===");
?>