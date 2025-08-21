# routers/books.py
from fastapi import APIRouter, HTTPException
from pydantic import BaseModel, Field

from database.models import Book

router = APIRouter()

# Modelos Pydantic para a validação e estrutura dos dados
class BookBase(BaseModel):
    nome: str = Field(..., min_length=2, max_length=100)
    autor: str = Field(..., min_length=2, max_length=100)
    status: str = Field("ativo") 

@router.get("/")
async def root():
    return {"message": "Bem-vindo à API de Biblioteca com FastAPI! Acesse /docs para a documentação e /todos_os_livros para ver a lista de livros."}

@router.get("/todos_os_livros")
async def get_all_books():
    books = await Book.all()
    response_books = [{"id": book.id, "nome": book.name, "autor": book.autor, "status": book.status, "created_at": book.created_at.strftime("%Y-%m-%d %H:%M:%S")} for book in books]
    return {"livros": response_books}

@router.get("/livros/{livro_id}")
async def get_book(livro_id: int):
    book = await Book.get_or_none(id=livro_id)
    if not book:
        raise HTTPException(status_code=404, detail="Livro não encontrado.")
    return {"id": book.id, "nome": book.name, "autor": book.autor, "status": book.status, "created_at": book.created_at.strftime("%Y-%m-%d %H:%M:%S")}

@router.post("/adicionar_livro")
async def add_book(livro: BookBase):
    new_book = await Book.create(name=livro.nome, autor=livro.autor, status=livro.status)
    return {"id": new_book.id, "nome": new_book.name, "autor": new_book.autor, "status": new_book.status, "created_at": new_book.created_at.strftime("%Y-%m-%d %H:%M:%S")}

@router.put("/atualizar_livro/{livro_id}")
async def update_book(livro_id: int, livro: BookBase):
    book_to_update = await Book.get_or_none(id=livro_id)
    if not book_to_update:
        raise HTTPException(status_code=404, detail="Livro não encontrado.")
    
    book_to_update.name = livro.nome
    book_to_update.autor = livro.autor
    book_to_update.status = livro.status
    await book_to_update.save()

    return {"message": "Livro atualizado com sucesso!", "livro_atualizado": {
        "id": book_to_update.id,
        "nome": book_to_update.name,
        "autor": book_to_update.autor,
        "status": book_to_update.status,
        "created_at": book_to_update.created_at.strftime("%Y-%m-%d %H:%M:%S")
    }}

@router.delete("/deletar_livro/{livro_id}")
async def delete_book(livro_id: int):
    book_to_delete = await Book.get_or_none(id=livro_id)
    if not book_to_delete:
        raise HTTPException(status_code=404, detail="Livro não encontrado.")
    
    await book_to_delete.delete()
    return {"message": "Livro deletado com sucesso!"}