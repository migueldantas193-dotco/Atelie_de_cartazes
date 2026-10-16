<?php
require_once '../PHP/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ateliê de Cartazes | Galeria</title>
    <link rel="stylesheet" href="../CSS/flexbox.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
 
    <main class="home-main">
        <h2 class="titulo-destaque">Sua Galeria</h2>

        <form class="form-upload" action="../PHP/salvar_cartaz.php" method="POST" enctype="multipart/form-data">
            <h3>Salvar um novo cartaz</h3>
            <input type="text" name="titulo" placeholder="Dê um título à sua arte" required>
            <input type="file" name="imagem" accept="image/*" required>
            <button type="submit" name="enviar" class="btn-principal">Salvar na Galeria</button>
        </form>

        <div class="grid-galeria">
            <?php
                 @var mysqli 
            $resultado = $conn->query("SELECT * FROM cartazes ORDER BY data_upload DESC");
            
            if ($resultado->num_rows > 0) {
                while ($linha = $resultado->fetch_assoc()) {
                    echo "<div class='cartao-galeria'>";
                    echo "<h4>" . htmlspecialchars($linha['titulo']) . "</h4>";
                    echo "<img src='../" . $linha['caminho_imagem'] . "' alt='Cartaz'>";
                    
                    echo "<a href='editar.php?id=" . $linha['id'] . "' class='btn-ferramenta'>Editar</a>";
                     
                    echo "<a href='../PHP/deletar_cartaz.php?id=" . $linha['id'] . "' class='btn-ferramenta' style='color: red;'>Excluir</a>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum cartaz salvo ainda.</p>";
            }
            ?>
        </div>


    </main>
</body>
</html>