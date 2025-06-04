<?php
require_once 'config.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

// Testar conexão
echo "<p><strong>Teste 1 - Conexão:</strong></p>";
echo "<p>" . testarConexao() . "</p>";

// Testar se a tabela existe
echo "<p><strong>Teste 2 - Verificar Tabela:</strong></p>";
try {
    $pdo = conectarBanco();
    $stmt = $pdo->query("SHOW TABLES LIKE 'contatos'");
    $tabela = $stmt->fetch();
    
    if ($tabela) {
        echo "<p style='color: green;'>✅ Tabela 'contatos' encontrada!</p>";
        
        // Mostrar estrutura da tabela
        $stmt = $pdo->query("DESCRIBE contatos");
        $colunas = $stmt->fetchAll();
        
        echo "<p><strong>Estrutura da tabela:</strong></p>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th></tr>";
        foreach ($colunas as $coluna) {
            echo "<tr>";
            echo "<td>" . $coluna['Field'] . "</td>";
            echo "<td>" . $coluna['Type'] . "</td>";
            echo "<td>" . $coluna['Null'] . "</td>";
            echo "<td>" . $coluna['Key'] . "</td>";
            echo "<td>" . $coluna['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p style='color: red;'>❌ Tabela 'contatos' NÃO encontrada!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro ao verificar tabela: " . $e->getMessage() . "</p>";
}

// Testar inserção de dados de teste
echo "<p><strong>Teste 3 - Inserção de Teste:</strong></p>";
try {
    $pdo = conectarBanco();
    
    $sql = "INSERT INTO contatos (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    $nome_teste = "Teste Nome";
    $email_teste = "teste@email.com";
    $telefone_teste = "(11) 99999-9999";
    $mensagem_teste = "Esta é uma mensagem de teste para verificar se a inserção está funcionando.";
    
    if ($stmt->execute([$nome_teste, $email_teste, $telefone_teste, $mensagem_teste])) {
        echo "<p style='color: green;'>✅ Inserção de teste realizada com sucesso!</p>";
        echo "<p>ID do registro inserido: " . $pdo->lastInsertId() . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Falha na inserção de teste</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro na inserção de teste: " . $e->getMessage() . "</p>";
}

// Mostrar registros existentes
echo "<p><strong>Teste 4 - Registros Existentes:</strong></p>";
try {
    $pdo = conectarBanco();
    $stmt = $pdo->query("SELECT * FROM contatos ORDER BY data_envio DESC LIMIT 5");
    $contatos = $stmt->fetchAll();
    
    if (count($contatos) > 0) {
        echo "<p style='color: green;'>Encontrados " . count($contatos) . " registro(s):</p>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Data</th></tr>";
        foreach ($contatos as $contato) {
            echo "<tr>";
            echo "<td>" . $contato['id'] . "</td>";
            echo "<td>" . htmlspecialchars($contato['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($contato['email']) . "</td>";
            echo "<td>" . htmlspecialchars($contato['telefone']) . "</td>";
            echo "<td>" . $contato['data_envio'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠️ Nenhum registro encontrado na tabela</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro ao buscar registros: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>← Voltar para o portfólio</a></p>";
echo "<p><a href='admin_contatos.php'>Ver página de contatos</a></p>";
?>