from fastapi import FastAPI, HTTPException
from pydantic import BaseModel

from database.config import init_db
from database.models import Book

app = FastAPI()
init_db(app)


class AddBookModel(BaseModel):
    nome: str
    autor: str

class UpdateBookModel(BaseModel):
    nome: str
    autor: str


@app.get("/todos_os_livros")
async def todos_os_livros():
    books = await Book.all()
    response_books = [{"id": book.id, "nome": book.name, "autor": book.autor} for book in books]
    return {"livros": response_books}


@app.post("/adicionar_livro")
async def adicionar_livro(livro: AddBookModel):
    new_book = await Book.create(name=livro.nome, autor=livro.autor)
    return {"id": new_book.id, "nome": new_book.name, "autor": new_book.autor}


@app.put("/atualizar_livro/{livro_id}")
async def atualizar_livro(livro_id: int, livro: UpdateBookModel):
    book_to_update = await Book.get_or_none(id=livro_id)
    if not book_to_update:
        raise HTTPException(status_code=404, detail="Livro não encontrado.")
    
    book_to_update.name = livro.nome
    book_to_update.autor = livro.autor
    await book_to_update.save()

    return {"message": "Livro atualizado com sucesso!", "livro_atualizado": {
        "id": book_to_update.id,
        "nome": book_to_update.name,
        "autor": book_to_update.autor
    }}


@app.delete("/deletar_livro/{livro_id}")
async def deletar_livro(livro_id: int):
    book_to_delete = await Book.get_or_none(id=livro_id)
    if not book_to_delete:
        raise HTTPException(status_code=404, detail="Livro não encontrado.")
    
    await book_to_delete.delete()
    return {"message": "Livro deletado com sucesso!"}