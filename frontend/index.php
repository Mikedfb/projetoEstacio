<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Biblioteca - PHP Frontend </title>
    <link rel="stylesheet" href="/style.css">

</head>
<body>
    
    <header>
        <h1>Livros da Biblioteca</h1>
        <a href="form.php" class="botao-criar">Adicionar Novo Livro</a>
    </header>

    <main>
        <h2>Lista de Livros</h2>
        <table>
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Nome</td>
                    <td>Autor</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>

                <?php
                $apiUrl = 'http://127.0.0.1:8000';
                $response = file_get_contents("{$apiUrl}/todos_os_livros");
                $data = json_decode($response, true);
                if ($data &&  isset($data['livros']) && is_array($data['livros'])) {
                    foreach ($data['livros'] as $livro) {
                        echo '<tr>';
                        echo "<td>{$livro['id']}</td>";
                        echo "<td>{$livro['nome']}</td>";
                        echo "<td>{$livro['autor']}</td>";
                        echo '<td>';
                        echo "<a href='form.php?id={$livro['id']}' class='botao-editar'>Editar</a>";
                        echo "<form action='processar.php' method='POST'style='display:inline-block;'>";
                        echo "<input = type='hidden' name='action' value='deletar'>";
                        echo "<input type='hidden' name='livro_id' value='{$livro['id']}'>";
                        echo "<button type='submit' class='botao-deletar' onclick=\"return confirm('Tem certeza que deseja deletar este livro?');\">Deletar</button>";
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                        
                    }
                } else {
                    echo "<tr><td> colspan='4'>Nenhum livro encontrado.</td></tr>";
                }
                ?>
            
            </tbody>
        </table>
    </main>
    
</body>
</html>