<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Livro</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    
    <header>
        <h1>Detalhes do Livro</h1>
        <a href="index.php" class="botao-voltar">Voltar para a lista</a>
    </header>

    <main>
        <?php
            $apiUrl = 'http://api:8000';
            if (isset($_GET['id'])) {
                $livro_id = $_GET['id'];
                $response = @file_get_contents("{$apiUrl}/livros/{$livro_id}");
                $livro = json_decode($response, true);
                
                if ($livro) {
                    echo '<h2>' . htmlspecialchars($livro['nome']) . '</h2>';
                    echo '<p><strong>Autor:</strong> ' . htmlspecialchars($livro['autor']) . '</p>';
                    echo '<p><strong>ID:</strong> ' . htmlspecialchars($livro['id']) . '</p>';
                    echo '<p><strong>Status:</strong> ' . htmlspecialchars($livro['status']) . '</p>';
                    echo '<p><strong>Criado em:</strong> ' . htmlspecialchars($livro['created_at']) . '</p>';
                } else {
                    echo '<p>Livro não encontrado.</p>';
                }
            } else {
                echo '<p>ID do livro não especificado.</p>';
            }
        ?>
    </main>
</body>
</html>