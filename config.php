<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_contatos');
define('DB_USER', 'root');
define('DB_PASS', ''); // Senha vazia é padrão no XAMPP

// Função para conectar ao banco de dados
function conectarBanco() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    } catch(PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}

// Função para testar conexão
function testarConexao() {
    try {
        $pdo = conectarBanco();
        return "Conexão com o banco de dados estabelecida com sucesso!";
    } catch(Exception $e) {
        return "Erro na conexão: " . $e->getMessage();
    }
}
?>