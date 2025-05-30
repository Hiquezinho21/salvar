<?php
class Database {
    private static $instance = null;
    private $connection;
    
    // Configurações do banco de dados
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'queijaria_peruzzolo';
    private $charset = 'utf8mb4';

    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("Erro de conexão: " . $e->getMessage());
            die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}

// Função auxiliar para obter a conexão
function getDBConnection() {
    return Database::getInstance();
}

// Teste de conexão (opcional)
try {
    $conn = getDBConnection();
    $conn->query("SELECT 1");
} catch (PDOException $e) {
    error_log("Teste de conexão falhou: " . $e->getMessage());
    die("Erro na configuração do banco de dados. Contate o administrador.");
}
?>