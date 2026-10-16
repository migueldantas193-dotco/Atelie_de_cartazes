<?php
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $busca = $conn->query("SELECT caminho_imagem FROM cartazes WHERE id = $id");
    
    if ($busca->num_rows > 0) {
        $cartaz = $busca->fetch_assoc();
        $caminho_arquivo = "../" . $cartaz['caminho_imagem'];
        
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo);
        }
        
        $conn->query("DELETE FROM cartazes WHERE id = $id");
    }
}

header("Location: ../PAGES/galeria.php");
exit;
?>