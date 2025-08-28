<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Projetos - PHP Frontend</title>
    <link rel="stylesheet" href="/style.css">

</head>
<body>
    
    <header>
        <h1>Projetos</h1>
        <a href="form.php" class="botao-criar">Adicionar Novo Projeto</a>
    </header>

    <main>
        <h2>Lista de Projetos</h2>
        <table>
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Título</td>
                    <td>Responsável</td>
                    <td>Status</td>
                    <td>Criado em</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>

                <?php
                $apiUrl = 'http://api:8000';
                $response = file_get_contents("{$apiUrl}/todos_os_projetos");
                $data = json_decode($response, true);
                if ($data &&  isset($data['projetos']) && is_array($data['projetos'])) {
                    foreach ($data['projetos'] as $projeto) {
                        echo '<tr>';
                        echo "<td>{$projeto['id']}</td>";
                        echo "<td><a href='detalhes.php?id={$projeto['id']}'>{$projeto['titulo']}</a></td>";
                        echo "<td>{$projeto['responsavel']}</td>";
                        echo "<td>{$projeto['status']}</td>";
                        echo "<td>{$projeto['created_at']}</td>";
                        echo '<td>';
                        echo "<a href='form.php?id={$projeto['id']}' class='botao-editar'>Editar</a>";
                        echo "<form action='processar.php' method='POST'style='display:inline-block;'>";
                        echo "<input type='hidden' name='action' value='deletar'>";
                        echo "<input type='hidden' name='projeto_id' value='{$projeto['id']}'>";
                        echo "<button type='submit' class='botao-deletar' onclick=\"return confirm('Tem certeza que deseja deletar este projeto?');\">Deletar</button>";
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum projeto encontrado.</td></tr>";
                }
                ?>
            
            </tbody>
        </table>
    </main>
    
</body>
</html>