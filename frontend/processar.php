<?php

$apiUrl = 'http://api:8000';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    switch ($action) {
        case 'adicionar':
        case 'editar':
            $nome = $_POST['nome'] ?? '';
            $autor = $_POST['autor'] ?? '';
            $status = $_POST['status'] ?? 'ativo';

            if (empty($nome) || empty($autor)) {
                echo "<h1>Erro!</h1>";
                echo "<p>Nome e Autor do livro são campos obrigatórios.</p>";
                echo "<a href='index.php'>Voltar</a>";
                exit;
            }

            $data = json_encode(['nome' => $nome, 'autor' => $autor, 'status' => $status]);

            if ($action === 'adicionar') {
                curl_setopt($ch, CURLOPT_URL, "{$apiUrl}/adicionar_livro");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else { // 'editar'
                $livro_id = $_POST['livro_id'] ?? '';
                curl_setopt($ch, CURLOPT_URL, "{$apiUrl}/atualizar_livro/{$livro_id}");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            break;

        case 'deletar':
            $livro_id = $_POST['livro_id'] ?? '';
            curl_setopt($ch, CURLOPT_URL, "{$apiUrl}/deletar_livro/{$livro_id}");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;

        default:
            echo "Ação desconhecida.";
            exit;
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code >= 200 && $http_code < 300) {
        header('Location: index.php');
        exit;
    } else {
        $error_data = json_decode($response, true);
        echo "<h1> Erro na API! </h1>";
        echo "<p> Código HTTP: {$http_code}</p>";
        
        if (isset($error_data['detail'])) {
            echo "<p> Mensagem de erro: " . htmlspecialchars($error_data['detail']) . "</p>";
        } else {
            echo "<p> Resposta da API: " . htmlspecialchars($response) . "</p>";
        }

        echo "<a href='index.php'>Voltar</a>";
    }
}