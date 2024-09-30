<?php
session_start();

require_once 'conn.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuarioId'])) {
    header("Location: login.php");
    exit();
}

// Obter os dados do usuário atual
$userId = $_SESSION['usuarioId'];
$query = "SELECT * FROM usuarios WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);

// Processar a requisição POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = md5($_POST['senha']);

    // Atualizar apenas os campos que foram modificados
    if ($nome != $userData['nome']) {
        $query = "UPDATE usuarios SET nome = '$nome' WHERE id = '$userId'";
        mysqli_query($conn, $query);
    }
    if ($email != $userData['email']) {
        $query = "UPDATE usuarios SET email = '$email' WHERE id = '$userId'";
        mysqli_query($conn, $query);
    }
    if ($senha != $userData['senha']) {
        $query = "UPDATE usuarios SET senha = '$senha' WHERE id = '$userId'";
        mysqli_query($conn, $query);
    }

    $_SESSION['usuarioNome'] = $nome;
    echo "<div class='alert alert-success'>Perfil atualizado com sucesso!</div>";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Login</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Perfil do Usuário
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="editar-perfil.php">Editar Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Editar Perfil</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $userData['nome']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>