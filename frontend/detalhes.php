<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Projeto</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    
    <header>
        <h1>Detalhes do Projeto</h1>
        <a href="index.php" class="botao-voltar">Voltar para a lista</a>
    </header>

    <main>
        <?php
            $apiUrl = 'http://api:8000';
            if (isset($_GET['id'])) {
                $projeto_id = $_GET['id'];
                $response = @file_get_contents("{$apiUrl}/projetos/{$projeto_id}");
                $projeto = json_decode($response, true);
                
                if ($projeto) {
                    echo '<h2>' . htmlspecialchars($projeto['titulo']) . '</h2>';
                    echo '<p><strong>Responsável:</strong> ' . htmlspecialchars($projeto['responsavel']) . '</p>';
                    echo '<p><strong>ID:</strong> ' . htmlspecialchars($projeto['id']) . '</p>';
                    echo '<p><strong>Status:</strong> ' . htmlspecialchars($projeto['status']) . '</p>';
                    echo '<p><strong>Criado em:</strong> ' . htmlspecialchars($projeto['created_at']) . '</p>';
                } else {
                    echo '<p>Projeto não encontrado.</p>';
                }
            } else {
                echo '<p>ID do projeto não especificado.</p>';
            }
        ?>
    </main>
</body>
</html>