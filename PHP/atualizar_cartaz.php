<?php
require_once 'conexao.php';

if (isset($_POST['atualizar'])) {
    $id = intval($_POST['id']);
    $novo_titulo = $conn->real_escape_string($_POST['novo_titulo']);
    
    $sql = "UPDATE cartazes SET titulo = '$novo_titulo' WHERE id = $id";
    
    $conn->query($sql);
}

header("Location: ../PAGES/galeria.php");
exit;
?>