# Projeto de Biblioteca - CRUD com FastAPI e PHP

Este projeto é um sistema de CRUD (Create, Read, Update, Delete)

## Tecnologias Utilizadas

# * **Backend:** FastAPI, Tortoise ORM, Python
# * **Frontend:** PHP puro, HTML, CSS
# * **Banco de Dados:** PostgreSQL

## Estrutura do Projeto

Backend:
    main.py: Arquivo principal da aplicação FastAPI
    database: Pacote com arquivos relacionados ao banco de dados e os modelos.
        init.py: Vazio
        config.py: Configuração do Tortoise e conexão com o banco
        models.py: Modelos de dados

    routers: Pacote com as rotas (endpoints) da API
        init.py: Vazio
        books.py: Endpoints de CRUD para livros

Frontend: Contém todos os arquivos PHP e CSS do frontend.
    form.php: Frontend: formulário para adicionar/editar livros
    index.php: Frontend: página inicial com a lista de livros
    detalhes.php: Frontend: página para visualizar detalhes de um livro
    processar.php: Frontend: script para processar requisições para a API
    style.css: Estilização do frontend

docker-compose.yml: Arquivo de configuração que orquestra todos os serviços (API, Banco de Dados, Frontend).
Dockerfile: Arquivo de instrução para construir a imagem do container da API.

## Como Rodar o Projeto

A forma mais fácil de rodar todo o projeto é usando Docker Compose.

### Requisitos

*Docker Desktop* (para Windows, macOS ou Linux)

### Passo a Passo

1.  **Abra o terminal** na pasta raiz do projeto (onde o arquivo `docker-compose.yml` está localizado).

2.  **Execute o comando** para construir as imagens e iniciar todos os serviços:
    ```bash
    docker-compose up --build
    ```
    * Isso irá automaticamente criar a imagem da API, configurar o banco de dados e iniciar o servidor web PHP, todos conectados na mesma rede.

3.  **Acesse a aplicação:**
    * **Frontend (PHP):** Abra seu navegador e vá para `http://localhost`
    * **Documentação da API (Docs):** Para testar os endpoints, acesse `http://localhost:8000/docs`

### Como Parar a Aplicação

Quando você terminar de trabalhar, você pode parar e remover todos os containers com um único comando:

* Vá para o terminal onde o comando `docker-compose up` está rodando.
* Pressione `Ctrl + C` para parar os serviços.
* Em seguida, execute:
    ```bash
    docker-compose down
    ```
    Este comando irá remover os containers e redes para liberar os recursos do seu sistema.

