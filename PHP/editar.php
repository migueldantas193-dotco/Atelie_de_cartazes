<?php
require_once '../PHP/conexao.php';

if (!isset($_GET['id'])) {
    header("Location: galeria.php");
    exit;
}

$id = intval($_GET['id']);
$resultado = $conn->query("SELECT * FROM cartazes WHERE id = $id");

if ($resultado->num_rows === 0) {
    header("Location: galeria.php");
    exit;
}

$cartaz = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cartaz</title>
    <link rel="stylesheet" href="../CSS/flexbox.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Ateliê de Cartazes</h1>
        </div>
        <nav class="nav-links">
            <a href="../index.html">Home</a>
            <a href="tela.html">Criar</a>
            <a href="galeria.php">Galeria</a>
        </nav>
    </header>

    <main class="home-main">
        <h2 class="titulo-destaque">Editar Título</h2>
        
        <form class="form-upload" action="../PHP/atualizar_cartaz.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $cartaz['id']; ?>">
            
            <img src="../<?php echo $cartaz['caminho_imagem']; ?>" style="max-width: 200px; margin-bottom: 1rem;">
            
            <input type="text" name="novo_titulo" value="<?php echo htmlspecialchars($cartaz['titulo']); ?>" required>
            
            <button type="submit" name="atualizar" class="btn-principal">Salvar Alteração</button>
        </form>
    </main>
</body>
</html>