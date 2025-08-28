<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar/Editar Projeto</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    
    <header>
        <?php
            $titulo = "Adicionar Projeto";
            $projeto = ['titulo' => '', 'responsavel' => '', 'status' => 'pendente'];
            $action = "adicionar";

            if (isset($_GET['id'])) {
                $titulo = "Editar Projeto";
                $action = "editar";
                $projeto_id = $_GET['id'];
                $apiUrl = 'http://api:8000';
                
                $response = file_get_contents("{$apiUrl}/projetos/{$projeto_id}");
                $projeto = json_decode($response, true);
                if (!$projeto) {
                    echo "<h1> Erro ao carregar o projeto! </h1>";
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
            <?php if (isset($projeto_id)): ?>
            <input type="hidden" name="projeto_id" value="<?php echo $projeto_id; ?>">

            <?php endif; ?>

            <label for="titulo">Título do Projeto:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" required>

            <br>

            <label for="responsavel">Responsável:</label>
            <input type="text" name="responsavel" value="<?php echo htmlspecialchars($projeto['responsavel']); ?>" required>
            <br>

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="pendente" <?php echo ($projeto['status'] ?? '') == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                <option value="em_progresso" <?php echo ($projeto['status'] ?? '') == 'em_progresso' ? 'selected' : ''; ?>>Em Progresso</option>
                <option value="concluido" <?php echo ($projeto['status'] ?? '') == 'concluido' ? 'selected' : ''; ?>>Concluido</option>
            </select>
            <br>

            <button type="submit">Salvar Projeto</button>

        </form>
    </main>
</body>
</html>