<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Queijaria Peruzzolo</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <img src="../assets/img/logo.png" alt="Queijaria Peruzzolo" class="logo">
        <h1>Crie sua conta</h1>
        
        <?php if (isset($_GET['erro'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>
        
        <form id="register-form" action="processa_cadastro.php" method="POST">
            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="input-group">
                <label for="senha">Senha (mínimo 6 caracteres)</label>
                <input type="password" id="senha" name="senha" minlength="6" required>
                <div class="password-strength">
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <span class="strength-text"></span>
                </div>
            </div>
            
            <div class="input-group">
                <label for="telefone">Telefone (DDD) X XXXX-XXXX</label>
                <input type="text" 
                       id="telefone" 
                       name="telefone" 
                       placeholder="(99) 9 9999-9999" 
                       maxlength="16"
                       inputmode="numeric"
                       required>
            </div>
            
            <button type="submit">Cadastrar</button>
        </form>
        
        <div class="login-link">
            Já tem uma conta? <a href="../login.php">Faça login</a>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>