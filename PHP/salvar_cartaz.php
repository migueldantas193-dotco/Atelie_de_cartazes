<?php
require_once 'conexao.php';

header('Content-Type: application/json');
$dados = json_decode(file_get_contents('php://input'), true);

if (!empty($dados['imagem']) && !empty($dados['titulo'])) {
    $titulo = trim($dados['titulo']);
    $imagem_parts = explode(";base64,", $dados['imagem']);
    
    if (count($imagem_parts) < 2) {
        echo json_encode(["status" => "erro", "mensagem" => "Formato de imagem inválido."]);
        exit;
    }

    $imagem_decodificada = base64_decode($imagem_parts[1]);
    $diretoria = "../IMG/uploads/";
    
    if (!file_exists($diretoria)) {
        mkdir($diretoria, 0777, true);
    }

    $novo_nome = uniqid() . ".png";
    $destino = $diretoria . $novo_nome;
    $caminho_banco = "IMG/uploads/" . $novo_nome;

    if (file_put_contents($destino, $imagem_decodificada)) {
        $stmt = $conn->prepare("INSERT INTO cartazes (titulo, caminho_imagem) VALUES (?, ?)");
        $stmt->bind_param("ss", $titulo, $caminho_banco);

        if ($stmt->execute()) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Cartaz guardado com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro BD: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Falha ao gravar imagem."]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos."]);
}
?>