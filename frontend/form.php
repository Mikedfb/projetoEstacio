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
            $livro = ['nome' => '', 'autor' => '', 'status' => 'ativo'];
            $action = "adicionar";

            if (isset($_GET['id'])) {
                $titulo = "Editar Livro";
                $action = "editar";
                $livro_id = $_GET['id'];
                $apiUrl = 'http://api:8000';
                
                $response = file_get_contents("{$apiUrl}/livros/{$livro_id}");
                $livro = json_decode($response, true);
                if (!$livro) {
                    echo "<h1> Erro ao carregar o livro! </h1>";
                    exit;
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

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="ativo" <?php echo ($livro['status'] ?? '') == 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                <option value="pausado" <?php echo ($livro['status'] ?? '') == 'pausado' ? 'selected' : ''; ?>>Pausado</option>
                <option value="finalizado" <?php echo ($livro['status'] ?? '') == 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
            </select>
            <br>

            <button type="submit">Salvar Livro</button>

        </form>
    </main>
</body>
</html>