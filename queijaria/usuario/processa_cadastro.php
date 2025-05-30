<?php
session_start();
require_once('../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastro.php");
    exit();
}

// Dados do formulário
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];
$telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);

// Validações
$erros = [];
if (empty($nome)) $erros[] = "Nome é obrigatório";
if (empty($email)) $erros[] = "E-mail é obrigatório";
if (empty($senha)) $erros[] = "Senha é obrigatória";
if (empty($telefone)) $erros[] = "Telefone é obrigatório";

if (strlen($telefone) !== 11) {
    $erros[] = "Telefone inválido. Deve conter 11 dígitos (DDD + número)";
}

if (strlen($senha) < 6) {
    $erros[] = "A senha deve ter no mínimo 6 caracteres";
}

// Verifica se e-mail já existe
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $erros[] = "Este e-mail já está cadastrado";
}

// Se houver erros, redireciona
if (!empty($erros)) {
    header("Location: cadastro.php?erro=" . urlencode(implode("\\n", $erros)));
    exit();
}

// Cadastra o usuário
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (nome, email, senha, telefone) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senha_hash, $telefone);

if ($stmt->execute()) {
    // Login automático
    $_SESSION['usuario'] = [
        'id' => $stmt->insert_id,
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
        'tipo' => 'cliente'
    ];
    header("Location: ../index.php");
} else {
    header("Location: cadastro.php?erro=" . urlencode("Erro ao cadastrar. Tente novamente."));
}
?>