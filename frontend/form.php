<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar/Editar</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    
    <header>
        <?php
            $titulo = "Adicionar Livro";
            $livro = ['nome' => '', 'autor' => ''];
            $action = "adicionar";

            if (isset($_GET['id'])) {
                $titulo = "Editar Livro";
                $action = "editar";
                $livro_id = $_GET['id'];
                $apiUrl = 'http://127.0.0.1:8000';
                $response = file_get_contents("{$apiUrl}/todos_os_livros");
                $data = json_decode($response, true);
                foreach ($data['livros'] as $item) {
                    if ($item['id'] == $livro_id) {
                        $livro = $item;
                        break;
                    }
                }
            }
        ?>
        
        <h1><?php echo $titulo; ?></h1>
        <a href="index.php" class="botao-voltar">Voltar para a lista</a>
    </header>

    <main>
        <form action="processar.php" method="POST">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <?php if (isset($livro_id)): ?>
            <input type="hidden" name="livro_id" value="<?php echo $livro_id; ?>">

            <?php endif; ?>

            <label for="nome">Nome do Livro:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($livro['nome']); ?>" required>

            <br>

            <label for="autor">Autor:</label>
            <input type="text" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>

            <br>

            <button type="submit">Salvar Livro</button>

        </form>
    </main>
</body>
</html>